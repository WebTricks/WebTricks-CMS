<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in
 * the future. If you wish to customize WebTricks for your needs please go to 
 * http://www.webtricksframework.com for more information.
 *
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Class to work with Market packages
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Market_Package
{
    /*
     * Current version of market package format
     */
    const PACKAGE_VERSION_2X = '2';

    /*
     * Previous version of market package format
     */
    const PACKAGE_VERSION_1X = '1';

    /**
     * Contain SimpleXMLElement for composing document.
     *
     * @var SimpleXMLElement
     */
    protected $_packageXml;

    /**
     * Internal cache
     *
     * @var array
     */
    protected $_authors;

    /**
     * Internal cache
     *
     * @var array
     */
    protected $_contents;

    /**
     * Internal cache
     *
     * @var array
     */
    protected $_hashContents;

    /**
     * Internal cache
     *
     * @var array
     */
    protected $_compatible;

    /**
     * Internal cache
     *
     * @var array
     */
    protected $_dependencyPhpExtensions;

    /**
     * Internal cache
     *
     * @var array
     */
    protected $_dependencyPackages;

    /**
     * A helper object that can read from a package archive
     *
     * @var Cream_Market_Package_Reader
     */
    protected $_reader;

    /**
     * A helper object that can create and write to a package archive
     *
     * @var Cream_Market_Package_Writer
     */
    protected $_writer;

    /**
     * Validator object
     *
     * @var Cream_Market_Validator
     */
    protected $_validator = null;

    /**
     * Validation errors
     *
     * @var array
     */
    protected $_validationErrors = array();

    /**
    * Object with target
    *
    * @var Cream_Market_Package_Target
    */
    protected $_target = null;

	/**
	 * Create a new instance of this class.
	 * 
     * @param null|string|resource $source
	 * @return Cream_Market_Package
	 */
	public static function instance($source = null)
	{
		return Cream::instance(__CLASS__, $source);
	}

    /**
     * Creates a package object (empty, or from existing archive, or from package definition xml)
     *
     * @param null|string|resource $source
     */
    public function __init($source = null)
    {
        libxml_use_internal_errors(true);

        if (is_string($source)) {
            // check what's in the string (a package definition or a package filename)
            if (0 === strpos($source, "<?xml")) {
                // package definition xml
                $this->_init($source);
            } elseif (is_file($source) && is_readable($source)) {
                // package archive filename
                $this->_loadFile($source);
            } else {
                throw new Cream_Exceptions_Exception('Invalid package source');
            }
        } elseif (is_resource($source)) {
            $this->_loadResource($source);
        } elseif (is_null($source)) {
            $this->_init();
        } else {
            throw new Cream_Exceptions_Exception('Invalid package source');
        }
    }

    /**
     * Initializes an empty package object
     *
     * @param null|string $definition optional package definition xml
     * @return void
     */
    protected function _init($definition=null)
    {

        if (!is_null($definition)) {
            $this->_packageXml = simplexml_load_string($definition);
        } else {
            $packageXmlStub = <<<END
<?xml version="1.0"?>
<package>
    <name />
    <version />
    <stability />
    <license />
    <channel />
    <extends />
    <summary />
    <description />
    <notes />
    <authors />
    <date />
    <time />
    <contents />
    <compatible />
    <dependencies />
</package>
END;
            $this->_packageXml = simplexml_load_string($packageXmlStub);
        }
    }

    /**
     * Loads a package from specified file
     *
     * @param string $filename
     * @return void
     */
    protected function _loadFile($filename='')
    {
        if (is_null($this->_reader)) {
            $this->_reader = Cream_Market_Package_Reader::instance($filename);
        }
        $content = $this->_reader->load();
        $this->_packageXml = simplexml_load_string($content);
    }

    /**
     * Creates a package and saves it
     *
     * @param string $path
     * @return void
     */
    public function save($path)
    {
        $this->validate();
        $path = rtrim($path, "\\/") . DS;
        $this->_savePackage($path);
    }

    /**
     * Creates a package archive and saves it to specified path
     *
     * @param string $path
     * @return void
     */
    protected function _savePackage($path)
    {
        $fileName = $this->getReleaseFilename();
        if (is_null($this->_writer)) {
            $this->_writer = Cream_Market_Package_Writer::instance($this->getContents(), $path.$fileName);
        }
        $this->_writer->composePackage();
		$this->_writer->addPackageXml($this->getPackageXml());
		$this->_writer->archivePackage();
    }

    /**
    * Retrieve Target object
    *
    * @return Cream_Market_Package_Target
    */
    protected function getTarget()
    {
        if (!$this->_target instanceof Cream_Market_Package_Target) {
            $this->_target = Cream_Market_Package_Target::instance();
        }
        return $this->_target;
    }

    public function setTarget($arg)
    {
        if ($arg instanceof Cream_Market_Package_Target) {
            $this->_target = $arg;
        }
    }

    /* Mutators */

    /**
     * Puts value to name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->_packageXml->name = $name;
    }

    /**
     * Puts value to <channel />
     *
     * @param string $channel
     * @return void
     */
    public function setChannel($channel)
    {
        $this->_packageXml->channel = $channel;
    }

    /**
     * Puts value to <summary />
     *
     * @param string $summary
     * @return void
     */
    public function setSummary($summary)
    {
        $this->_packageXml->summary = $summary;
    }

    /**
     * Puts value to <description />
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->_packageXml->description = $description;
    }

    /**
     * Puts value to <authors />
     *
     * array(
     *     array('name'=>'Name1', 'user'=>'User1', 'email'=>'email1@email.com'),
     *     array('name'=>'Name2', 'user'=>'User2', 'email'=>'email2@email.com'),
     * );
     *
     * @param array $authors
     * @return void
     */
    public function setAuthors($authors)
    {
        $this->_authors = $authors;
        foreach ($authors as $_author) {
            $this->addAuthor($_author['name'], $_author['user'], $_author['email']);
        }
    }

    /**
    * Add author to <authors/>
    *
    * @param string $name
    * @param string $user
    * @param string $email
    * @return void
    */
    public function addAuthor($name=null, $user=null, $email=null)
    {
        $this->_authors[] = array(
            'name' =>$name,
            'user' =>$user,
            'email'=>$email
        );
        $author = $this->_packageXml->authors->addChild('author');
        $author->addChild('name', $name);
        $author->addChild('user', $user);
        $author->addChild('email', $email);
    }

    /**
     * Puts value to <date/>. Format should be Y-M-D.
     *
     * @param string $date
     * @return void
     */
    public function setDate($date)
    {
        $this->_packageXml->date = $date;
    }

    /**
     * Puts value to <time />. Format should be H:i:s.
     *
     * @param string $time
     * @return void
     */
    public function setTime($time)
    {
        $this->_packageXml->time = $time;
    }

    /**
     * Puts value to <version/>. Format should be X.Y.Z.
     *
     * @param string $version
     * @return void
     */
    public function setVersion($version)
    {
        $this->_packageXml->version = $version;
    }

    /**
     * Puts value to <stability/>. It can be alpha, beta, devel and stable.
     *
     * @param string $stability
     * @return void
     */
    public function setStability($stability)
    {
        $this->_packageXml->stability = $stability;
    }

    /**
     * Puts value to <license/>, also method can used for set attribute URI.
     *
     * @param string $license
     * @param string $uri
     * @return void
     */
    public function setLicense($license, $uri=null)
    {
        $this->_packageXml->license = $license;
        if ($uri) {
            $this->_packageXml->license['uri'] = $uri;
        }
    }

    /**
     * Puts value to <notes/>.
     *
     * @param string $notes
     * @return void
     */
    public function setNotes($notes)
    {
        $this->_packageXml->notes = $notes;
    }

    /**
    * Retrieve SimpleXMLElement node by xpath. If it absent, create new.
    * For comparing nodes method uses attribute "name" in each nodes.
    * If attribute "name" is same for both nodes, nodes are same.
    *
    * @param string $tag
    * @param SimpleXMLElement $parent
    * @param string $name
    * @return SimpleXMLElement
    */
    protected function _getNode($tag, $parent, $name='')
    {
        $found = false;
        foreach ($parent->xpath($tag) as $_node) {
            if ($_node['name'] == $name) {
                $node = $_node;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $node = $parent->addChild($tag);
            if ($name) {
                $node->addAttribute('name', $name);
            }
        }
        return $node;
    }

    /**
     * Add directory or file to <contents />.
     *
     * @param string $path Path to directory or file
     * @param string $targetName Target name.
     * @param string $hash MD5 hash of the file
     * @return void
     */
    public function addContent($path, $targetName)
    {
        $found = false;
        $parent = $this->_getNode('target', $this->_packageXml->contents, $targetName);
        $source = str_replace('\\', '/', $path);
        $directories = explode('/', dirname($source));
        foreach ($directories as $directory) {
            $parent = $this->_getNode('dir', $parent, $directory);
        }
        $fileName = basename($source);
        if ($fileName!='') {
            $fileNode = $parent->addChild('file');
            $fileNode->addAttribute('name', $fileName);
            $targetDir = $this->getTarget()->getTargetUri($targetName);
            $hash = md5_file($targetDir.DS.$path);
            $fileNode->addAttribute('hash', $hash);
        }
    }

    /**
     * Add directory recursively (with subdirectory and file).
     * Exclude and Include can be add using Regular Expression.
     *
     * @param string $targetName Target name
     * @param string $targetDir Path for target name
     * @param string $path Path to directory
     * @param string $exclude Exclude
     * @param string $include Include
     * @return void
     */
    public function addContentDir($targetName, $path, $exclude=null, $include=null)
    {
        $targetDir = $this->getTarget()->getTargetUri($targetName);
        $targetDirLen = strlen($targetDir . DS);
        //get all subdirectories and files.
        $entries = @glob($targetDir. DS . $path . DS . "{,.}*", GLOB_BRACE);
        if (!empty($entries)) {
            foreach ($entries as $entry) {
                $filePath = substr($entry, $targetDirLen);
                // TODO: Check directory before includes/excludes
                if (is_dir($entry)) {
                    $baseName = basename($entry);
                    if (in_array($baseName, array('.', '..', '.svn'))) {
                        continue;
                    }
                    //for subdirectory call method recursively
                    $this->addContentDir($targetName, $filePath, $exclude, $include);
                    continue;
                }
                if (!empty($include) && !preg_match($include, $filePath)) {
                    continue;
                }
                if (!empty($exclude) && preg_match($exclude, $filePath)) {
                    continue;
                }

                if (is_file($entry)) {
                    $this->addContent($filePath, $targetName);
                }
            }
        }
    }

    /**
     * Add value to <compatible />.
     *
     * @param string $packageName
     * @param string $channel
     * @param string $minVersion
     * @param string $maxVersion
     * @return void
     */
    public function addCompatible($packageName, $channel, $minVersion, $maxVersion)
    {
        $package = $this->_packageXml->compatible->addChild('package');
        $package->addChild('name', $packageName);
        $package->addChild('channel', $channel);
        $package->addChild('min', $minVersion);
        $package->addChild('max', $maxVersion);
    }

    /**
     * Set dependency from php version.
     *
     * @param string $minVersion
     * @param string $maxVersion
     * @return void
     */
    public function setDependencyPhpVersion($minVersion, $maxVersion)
    {
        $parent = $this->_packageXml->dependencies;
        $parent = $this->_getNode('required', $parent);
        $parent = $this->_getNode('php', $parent);
        $parent->addChild('min', $minVersion);
        $parent->addChild('max', $maxVersion);
    }

    /**
     * Check PHP version restriction
	 * 
     * @param $phpVersion PHP_VERSION by default
     * @return true | string
     */
    public function checkPhpVersion()
    {
        $min = $this->getDependencyPhpVersionMin();
        $max = $this->getDependencyPhpVersionMax();

        $minOk = $min? version_compare(PHP_VERSION, $min, ">=") : true;
        $maxOk = $max? version_compare(PHP_VERSION, $max, "<=") : true;

        if(!$minOk || !$maxOk) {
            $err = "requires PHP version ";
            if($min && $max) {
                $err .= " >= $min and <= $max ";
            } elseif($min) {
                $err .= " >= $min ";
            } elseif($max) {
                $err .=  " <= $max ";
            }
            $err .= " current is: ".PHP_VERSION;
            return $err;
        }
        return true;
    }


    /**
     * Check PHP extensions availability
	 * 
     * @throws Exceptiom on failure
     * @return true | array
     */
    public function checkPhpDependencies()
    {
        $errors = array();
        foreach($this->getDependencyPhpExtensions() as $dep)
        {
            if(!extension_loaded($dep['name'])) {
                $errors[] = $dep;
            }
        }
        if(count($errors)) {
            return $errors;
        }
        return true;
    }


    /**
     * Set dependency from php extensions.
     *
     * $extension has next view:
     * array('curl', 'mysql')
     *
     * @param array|string $extensions
     * @return void
     */
    public function setDependencyPhpExtensions($extensions)
    {
        foreach($extensions as $_extension) {
            $this->addDependencyExtension(
                $_extension['name'],
                $_extension['min_version'],
                $_extension['max_version']
            );
        }
    }

    /**
    * Set dependency from another packages.
    *
    * $packages should contain:
    * array(
    *     array('name'=>'test1', 'channel'=>'test1', 'min_version'=>'0.0.1', 'max_version'=>'0.1.0'),
    *     array('name'=>'test2', 'channel'=>'test2', 'min_version'=>'0.0.1', 'max_version'=>'0.1.0'),
    * )
    *
    * @param array $packages
    * @param bool $clear
    * @return void
    */
    public function setDependencyPackages($packages, $clear = false)
    {
        if($clear) {
            unset($this->_packageXml->dependencies->required->package);
        }

        foreach($packages as $_package) {

            $filesArrayCondition = isset($_package['files']) && is_array($_package['files']);
            $filesArray = $filesArrayCondition ? $_package['files'] : array();

            $this->addDependencyPackage(
                $_package['name'],
                $_package['channel'],
                $_package['min_version'],
                $_package['max_version'],
                $filesArray
            );
        }
    }

    /**
     * Add package to dependency packages.
     *
     * @param string $package
     * @param string $channel
     * @param string $minVersion
     * @param string $maxVersion
     * @return void
     */
    public function addDependencyPackage($name, $channel, $minVersion, $maxVersion, $files = array())
    {
        $parent = $this->_packageXml->dependencies;
        $parent = $this->_getNode('required', $parent);
        $parent = $parent->addChild('package');
        $parent->addChild('name', $name);
        $parent->addChild('channel', $channel);
        $parent->addChild('min', $minVersion);
        $parent->addChild('max', $maxVersion);
        if(count($files)) {
            $parent = $parent->addChild('files');
            foreach($files as $row) {
                if(!empty($row['target']) && !empty($row['path'])) {
                    $node = $parent->addChild("file");
                    $node["target"] = $row['target'];
                    $node["path"] =  $row['path'];

                }
            }
        }
    }

    /**
     * Add package to dependency extension.
     *
     * @param string $package
     * @param string $minVersion
     * @param string $maxVersion
     * @return void
     */
    public function addDependencyExtension($name, $minVersion, $maxVersion)
    {
        $parent = $this->_packageXml->dependencies;
        $parent = $this->_getNode('required', $parent);
        $parent = $parent->addChild('extension');
        $parent->addChild('name', $name);
        $parent->addChild('min', $minVersion);
        $parent->addChild('max', $maxVersion);
    }

    /* Accessors */

    /**
     * Getter
     *
     * @return string
     */
    public function getName()
    {
        return (string)$this->_packageXml->name;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getChannel()
    {
        return (string)$this->_packageXml->channel;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getSummary()
    {
        return (string)$this->_packageXml->summary;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->_packageXml->description;
    }

    /**
     * Get list of authors in associative array.
     *
     * @return array
     */
    public function getAuthors()
    {
        if (is_array($this->_authors)) return $this->_authors;
        $this->_authors = array();
        if(!isset($this->_packageXml->authors->author)) {
            return array();
        }
        foreach ($this->_packageXml->authors->author as $_author) {
            $this->_authors[] = array(
                'name' => (string)$_author->name,
                'user' => (string)$_author->user,
                'email'=> (string)$_author->email
            );
        }
        return $this->_authors;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getDate()
    {
        return (string)$this->_packageXml->date;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getTime()
    {
        return (string)$this->_packageXml->time;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getVersion()
    {
        return (string)$this->_packageXml->version;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getStability()
    {
        return (string)$this->_packageXml->stability;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getLicense()
    {
        return (string)$this->_packageXml->license;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getLicenseUri()
    {
        return (string)$this->_packageXml->license['uri'];
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getNotes()
    {
        return (string)$this->_packageXml->notes;
    }

    /**
     * Create list of all files from package.xml
     *
     * @return array
     */
    public function getContents()
    {
        if (is_array($this->_contents)) return $this->_contents;
        $this->_contents = array();
        if(!isset($this->_packageXml->contents->target)) {
            return $this->_contents;
        }
        foreach($this->_packageXml->contents->target as $target) {
            $targetUri = $this->getTarget()->getTargetUri($target['name']);
            $this->_getList($target, $targetUri);
        }
        return $this->_contents;
    }

    /**
    * Helper for getContents(). Create recursively list.
    *
    * @param SimpleXMLElement $parent
    * @param string $path
    */
    protected function _getList($parent, $path)
    {
        if (count($parent) == 0) {
            $this->_contents[] = $path;
        } else {
            foreach($parent as $_content) {
                $this->_getList($_content, ($path ? $path . DS : '')  . $_content['name']);
            }
        }
    }

    /**
     * Create list of all files from package.xml with hash
     *
     * @return array
     */
    public function getHashContents()
    {
        if (is_array($this->_hashContents)) return $this->_hashContents;
        $this->_hashContents = array();
        if(!isset($this->_packageXml->contents->target)) {
            return $this->_hashContents;
        }
        foreach($this->_packageXml->contents->target as $target) {
            $targetUri = $this->getTarget()->getTargetUri($target['name']);
            $this->_getHashList($target, $targetUri);
        }
        return $this->_hashContents;
    }

    /**
    * Helper for getHashContents(). Create recursively list.
    *
    * @param SimpleXMLElement $parent
    * @param string $path
    */
    protected function _getHashList($parent, $path, $hash='')
    {
        if (count($parent) == 0) {
            $this->_hashContents[$path] = $hash;
        } else {
            foreach($parent as $_content) {
                $contentHash = '';
                if (isset($_content['hash'])) {
                    $contentHash = (string)$_content['hash'];
                }
                $this->_getHashList($_content, ($path ? $path . DS : '')  . $_content['name'], $contentHash);
            }
        }
    }

    /**
     * Get compatible packages.
     *
     * @return array
     */
    public function getCompatible()
    {
        if (is_array($this->_compatible)) return $this->_compatible;
        $this->_compatible = array();
        if(!isset($this->_packageXml->compatible->package)) {
            return array();
        }
        foreach ($this->_packageXml->compatible->package as $_package) {
            $this->_compatible[] = array(
                'name'    => (string)$_package->name,
                'channel' => (string)$_package->channel,
                'min'     => (string)$_package->min,
                'max'     => (string)$_package->max
            );
        }
        return $this->_compatible;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getDependencyPhpVersionMin()
    {
        if(!isset($this->_packageXml->dependencies->required->php->min)) {
            return false;
        }
        return (string)$this->_packageXml->dependencies->required->php->min;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getDependencyPhpVersionMax()
    {
        if(!isset($this->_packageXml->dependencies->required->php->max)) {
            return false;
        }
        return (string)$this->_packageXml->dependencies->required->php->max;
    }

    /**
     * Get list of php extensions.
     *
     * @return array
     */
    public function getDependencyPhpExtensions()
    {
        if (is_array($this->_dependencyPhpExtensions)) return $this->_dependencyPhpExtensions;
        $this->_dependencyPhpExtensions = array();
        foreach($this->_packageXml->dependencies->required->extension as $_package) {
            $this->_dependencyPhpExtensions[] = array(
                'name'    => (string)$_package->name,
                'min'     => (string)$_package->min,
                'max'     => (string)$_package->max,
            );
        }
        return $this->_dependencyPhpExtensions;
    }

    /**
     * Get list of dependency packages.
     *
     * @return array
     */
    public function getDependencyPackages()
    {
        $this->_dependencyPackages = array();
        foreach($this->_packageXml->dependencies->required->package as $_package) {
            $add = array(
                'name'    => (string)$_package->name,
                'channel' => (string)$_package->channel,
                'min'     => (string)$_package->min,
                'max'     => (string)$_package->max,
            );
            if(isset($_package->files)) {
                $add['files'] = array();
                foreach($_package->files as $node) {
                    if(isset($node->file)) {

                        $add['files'][] = array('target' => (string) $node->file['target'], 'path'=> (string) $node->file['path']);
                    }
                }
            }
            $this->_dependencyPackages[] = $add;
        }
        return $this->_dependencyPackages;
    }




    /**
     * Get string with XML content.
     *
     * @return string
     */
    public function getPackageXml()
    {
        return $this->_packageXml->asXml();
    }


    /**
     * Validator instance (single)
     *
     *  @return Cream_Market_Validator
     */
    protected function validator()
    {
        if(is_null($this->_validator)) {
            $this->_validator = Cream_Market_Validator::instance();
        }
        return $this->_validator;
    }

    /**
     * Get validation error strings
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_validationErrors;
    }

    /**
     * Setter for validation errors
     *
     * @param array $errors
     * @return
     */
    protected function setErrors(array $errors)
    {
        $this->_validationErrors = $errors;
    }

    /**
     * Check validation result.
     * Returns true if package data is invalid.
     *
     * @return bool
     */
    public function hasErrors()
    {
    	return count($this->_validationErrors) != 0;
    }

    /**
     * Validate package. Errors can be
     * retreived by calling getErrors();
     *
     * @return bool
     */
    public function validate()
    {
        $v = $this->validator();

        /**
         * Validation map
         *
         * Format:
         *
         * 'key' =>  array(
         *    'method' => this class method name to call, string, required
         *    'method_args' => optional args for 'method' call, array, optional
         *    'v_method' => validator method to call, string, required
         *    'error' => custom error string when validation fails, optional
         *               if not set, error string fprmatted as "Invalid '$key' specified"
         *    'v_error_method' => validator method - when called returned error string
         *                        prepared by validator, optional,
         *                        if not set => see 'error'
         *    'optional' => optional value, if it's empty validation result ignored
         *
         */
        $validateMap = array(
           'name' => array('method' => 'getName',
                           'v_method' => 'validatePackageName',
                           'error'=>"Invalid package name, allowed: [a-zA-Z0-9_-] chars"),
           'version' => array('method' => 'getVersion',
                           'v_method' => 'validateVersion',
                           'error'=>"Invalid version, should be like: x.x.x"),
           'stability' => array('method' => 'getStability',
                           'v_method' => 'validateStability',
                           'error'=>"Invalid stability"),
           'date' => array('method' => 'getDate',
                           'v_method' => 'validateDate',
                           'error'=>"Invalid date, should be YYYY-DD-MM"),
           'license_uri' => array('method' => 'getLicenseUri',
                           'v_method' => 'validateLicenseUrl',
                           'error'=>"Invalid license URL"),
           'channel' => array('method' => 'getChannel',
                           'v_method' => 'validateChannelNameOrUri',
                           'error'=>"Invalid channel URL"),
           'authors' => array('method' => 'getAuthors',
                           'v_method' => 'validateAuthors',
                           'v_error_method' => 'getErrors'),
           'php_min' => array('method' => 'getDependencyPhpVersionMin',
                           'v_method' => 'validateVersion',
                           'error' => 'PHP minimum version invalid',
                           'optional' => true ),
           'php_max' => array('method' => 'getDependencyPhpVersionMax',
                           'v_method' => 'validateVersion',
                           'error' => 'PHP maximum version invalid',
                           'optional' => true ),
           'compatible' => array('method' => 'getCompatible',
                           'v_method' => 'validateCompatible',
                           'v_error_method' => 'getErrors'),


        );

        $errors = array();
        /**
         * Iterate validation map
         */
         foreach($validateMap as $name=>$data) {

            /**
             * Check mandatory rules fields
             */
             if(!isset($data['method'], $data['v_method'])) {
             throw new Cream_Exceptions_Exception("Invalid rules specified!");
         }

            $method = $data['method'];
            $validatorMethod = $data['v_method'];

            /**
             * If $optional === false, value is mandatory
              */
            $optional = isset($data['optional']) ? (bool) $data['optional'] : false;

            /**
             * Check for method availability, package
             */
            if(!method_exists($this, $method)) {
                throw new Cream_Exceptions_Exception("Invalid method specified for Package : $method");
            }

            /**
             * Check for method availability, validator
             */
            if(!method_exists($v, $validatorMethod)) {
                throw new Cream_Exceptions_Exception("Invalid method specified for Validator : $validatorMethod");
            }

            /**
             * If    $data['error'] => get error string from $data['error']
             * Else  concatenate "Invalid '{$name}' specified"
             */
            $errorString = isset($data['error']) ? $data['error'] : "Invalid '{$name}' specified";

            /**
             * Additional method args check
             * array() by default
             */
            $methodArgs = isset($data['method_args']) ? $data['method_args'] : array();

            /**
             * Call package method
             */
            $out = @call_user_func_array(array($this, $method), $methodArgs);

            /**
             * Skip if result is empty and value is optional
             */
            if(empty($out) && $optional) {
               continue;
            }

            /**
            * Additional validator arguments, merged with array($out)
            */
            $validatorArgs = isset($data['v_args']) ? array_merge(array($out), $data['v_args']) : array($out);

            /**
             * Get validation result
             */
            $result = call_user_func_array(array($v, $validatorMethod), $validatorArgs);

            /**
             * Skip if validation success
             */
            if($result) {
                continue;
            }

            /**
             * From where to get error string?
             * If    validator callback method specified, call it to get errors array
             * Else  get it from $errorString - local error string
             */
            $validatorFetchErrorsMethod = isset($data['v_error_method']) ? $data['v_error_method'] : false;
            if (false !== $validatorFetchErrorsMethod) {
                $errorString = call_user_func_array(array($v, $validatorFetchErrorsMethod), array());
            }

            /**
             * If   errors is array => merge
             * Else append
             */
            if(is_array($errorString)) {
                $errors = array_merge($errors, $errorString);
            } else {
                $errors[] = $errorString;
            }
        }
        /**
         * Set local errors
         */
        $this->setErrors($errors);
        /**
         * Return true if there's no errors :)
         */
        return ! $this->hasErrors();
    }

    /**
     * Return package release filename w/o extension
	 * 
     * @return string
     */
    public function getReleaseFilename()
    {
        return $this->getName()."-".$this->getVersion();
    }

    /**
     * Return release filepath w/o extension
	 * 
     * @return string
     */
    public function getRelaseDirFilename()
    {
        return $this->getName() . DS . $this->getVersion() . DS . $this->getReleaseFilename();
    }

    /**
    * Clear dependencies
    *
    * @return void
    */
    public function clearDependencies()
    {
        $this->_packageXml->dependencies = null;
    }

    /**
    * Clear contents
    *
    * @return voids
    */
    public function clearContents()
    {
        $this->_packageXml->contents = null;
    }
}