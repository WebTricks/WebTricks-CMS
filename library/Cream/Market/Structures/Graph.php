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

class Cream_Market_Structures_Graph
{
    protected $_nodes = array();
    protected $_directed = false;
    protected $_nodeClassName = 'Cream_Market_Structures_Node';

    const ACYCLIC_VISITED_KEY = 'acyclic-test-visited';
    const SORT_VISITED_KEY = 'topological-sort-visited';
    const SORT_LEVEL_KEY = 'topological-sort-level';
    
	/**
	 * Create a new instance of this class.
	 * 
	 * @param bool $directed directed graph?
	 * @return Cream_Market_Structures_Graph
	 */
	public static function instance($directed = true)
	{
		return Cream::instance(__CLASS__, $directed);
	}
	 
    /**
     * Constructor
     * @param bool $directed directed graph?
     * @return void
     */
    public function __init($directed = true)
    {
        $this->_directed = $directed;
    }

    /**
     * Is graph directed?
     *
     * @return bool
     */
    public function isDirected()
    {
        return (boolean) $this->_directed;
    }

    /**
     * Add node to list
     *
     * @param Cream_Market_Structures_Graph_Node $newNode
     * @return void
     */
    public function addNode(&$newNode)
    {
        if(!$newNode instanceof $this->_nodeClassName) {
            throw new Exception(__METHOD__." : invalid node class, should be instance of: ".$this->_nodeClassName);
        }
        foreach($this->_nodes as $key => $node) {
            if($newNode === $node) {
                throw new Exception(__METHOD__." : received duplicate object");
            }
        }
        $this->_nodes[] =& $newNode;
        $newNode->setGraph($this);
    }

    /**
     * Remove a Node from the Graph
     * @param  Cream_Market_Structures_Graph_Node  $node
     */
    public function removeNode(&$node)
    {

    }

    /**
     * Return set of nodes
     * @return   array
     */
    public function &getNodes()
    {
        return $this->_nodes;
    }

    /**
     * Is asyclic
     * @return unknown_type
     */
    public function isAcyclic()
    {
        if (!$this->isDirected()) {
            return false;
        }
        return self::_isAcyclic($this);
    }

    /**
     *
     * This is a variant of Graph::inDegree which does
     * not count nodes marked as visited.
     *
     * @return integer
     */
    protected static function _nonVisitedInDegree(&$node, $metadataKey)
    {
        $result = 0;
        $graphNodes =& $node->getGraph()->getNodes();
        foreach (array_keys($graphNodes) as $key) {
            if ((!$graphNodes[$key]->getMetadata($metadataKey)) && $graphNodes[$key]->connectsTo($node)) {
                $result++;
            }
        }
        return $result;
    }

    /**
     * Is graph acyclic?
     * @param $graph
     * @return bool
     */
    protected static function _isAcyclic(&$graph)
    {
        // Mark every node as not visited
        $nodes =& $graph->getNodes();
        $nodeKeys = array_keys($nodes);
        $refGenerator = array();
        foreach($nodeKeys as $key) {
            $refGenerator[] = false;
            $nodes[$key]->setMetadata(self::ACYCLIC_VISITED_KEY, $refGenerator[sizeof($refGenerator) - 1]);
        }

        // Iteratively peel off leaf nodes
        do {
            // Find out which nodes are leafs (excluding visited nodes)
            $leafNodes = array();
            foreach($nodeKeys as $key) {
                if ((!$nodes[$key]->getMetadata(self::ACYCLIC_VISITED_KEY)) &&
                self::_nonVisitedInDegree($nodes[$key], self::ACYCLIC_VISITED_KEY) == 0) {
                    $leafNodes[] =& $nodes[$key];
                }
            }
            // Mark leafs as visited
            for ($i=sizeof($leafNodes) - 1; $i>=0; $i--) {
                $visited =& $leafNodes[$i]->getMetadata(self::ACYCLIC_VISITED_KEY);
                $visited = true;
                $leafNodes[$i]->setMetadata(self::ACYCLIC_VISITED_KEY, $visited);
            }
        } while (sizeof($leafNodes) > 0);


        // If graph is a DAG, there should be no non-visited nodes.
        // Let's try to prove otherwise
        $result = true;
        foreach($nodeKeys as $key) {
            if (!$nodes[$key]->getMetadata(self::ACYCLIC_VISITED_KEY)) {
                $result = false;
                break;
            }
        }

        // Cleanup visited marks
        foreach($nodeKeys as $key) {
            $nodes[$key]->unsetMetadata(self::ACYCLIC_VISITED_KEY);
        }

        return $result;
    }

    /**
     *
     * sort returns the graph's nodes, sorted by topological order.
     *
     * The result is an array with
     * as many entries as topological levels.
     *
     * Each entry in this array is an array of nodes within
     * the given topological level.
     *
     * @return   array
     */
    public function topologicalSort()
    {
        // We only sort graphs
        self::_topologicalSort($this);
        $result = array();
        // Fill out result array
        $nodes =& $this->getNodes();
        $nodeKeys = array_keys($nodes);
        foreach($nodeKeys as $key) {
            $k = $nodes[$key]->getMetadata(self::SORT_LEVEL_KEY);
            if (!array_key_exists($k, $result)) {
                $result[$k] = array();   
            }
            $result[$k][] =& $nodes[$key];
            $nodes[$key]->unsetMetadata(self::SORT_LEVEL_KEY);
        }
        return $result;
    }

    protected static function _topologicalSort(&$graph)
    {
        // Mark every node as not visited
        $nodes =& $graph->getNodes();
        $nodeKeys = array_keys($nodes);
        $refGenerator = array();
        foreach($nodeKeys as $key) {
            $refGenerator[] = false;
            $nodes[$key]->setMetadata(self::SORT_VISITED_KEY, $refGenerator[sizeof($refGenerator) - 1]);
        }

        // Iteratively peel off leaf nodes
        $topologicalLevel = 0;
        do {
            // Find out which nodes are leafs (excluding visited nodes)
            $leafNodes = array();
            foreach($nodeKeys as $key) {
                if ((!$nodes[$key]->getMetadata(self::SORT_VISITED_KEY)) && self::_nonVisitedInDegree($nodes[$key], self::SORT_VISITED_KEY) == 0) {
                    $leafNodes[] =& $nodes[$key];
                }
            }
            // Mark leafs as visited
            $refGenerator[] = $topologicalLevel;
            for ($i=sizeof($leafNodes) - 1; $i>=0; $i--) {
                $visited =& $leafNodes[$i]->getMetadata(self::SORT_VISITED_KEY);
                $visited = true;
                $leafNodes[$i]->setMetadata(self::SORT_VISITED_KEY, $visited);
                $leafNodes[$i]->setMetadata(self::SORT_LEVEL_KEY, $refGenerator[sizeof($refGenerator) - 1]);
            }
            $topologicalLevel++;
        } while (sizeof($leafNodes) > 0);

        foreach($nodeKeys as $key) {
            $nodes[$key]->unsetMetadata(self::SORT_VISITED_KEY);
        }
    }

}
