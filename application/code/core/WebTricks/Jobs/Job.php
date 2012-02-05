<?php 
/**
 * WebTricks
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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Job model
 *
 * @method string getJobCode()
 * @method Mage_Cron_Model_Schedule setJobCode(string $value)
 * @method string getStatus()
 * @method Mage_Cron_Model_Schedule setStatus(string $value)
 * @method string getMessages()
 * @method Mage_Cron_Model_Schedule setMessages(string $value)
 * @method string getCreatedAt()
 * @method Mage_Cron_Model_Schedule setCreatedAt(string $value)
 * @method string getScheduledAt()
 * @method Mage_Cron_Model_Schedule setScheduledAt(string $value)
 * @method string getExecutedAt()
 * @method Mage_Cron_Model_Schedule setExecutedAt(string $value)
 * @method string getFinishedAt()
 * @method Mage_Cron_Model_Schedule setFinishedAt(string $value)
 *
 * @package     WebTricks_Jobs
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Jobs_Job extends Cream_ApplicationComponent
{
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

    public function setCronExpr($expr)
    {
        $e = preg_split('#\s+#', $expr, null, PREG_SPLIT_NO_EMPTY);
        if (sizeof($e)<5 || sizeof($e)>6) {
            throw Mage::exception('Mage_Cron', 'Invalid cron expression: '.$expr);
        }        

        $this->setCronExprArr($e);
    }

    /**
     * Checks the observer's cron expression against time
     *
     * Supports $this->setCronExpr('* 0-5,10-59/5 2-10,15-25 january-june/2 mon-fri')
     *
     * @param string|numeric $time
     * @return boolean
     */
    public function trySchedule($time)
    {
        $e = $this->getCronExprArr();
        if (!$e || !$time) {
            return false;
        }
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }

        $d = getdate(Mage::getSingleton('core/date')->timestamp($time));

        $match = $this->matchCronExpression($e[0], $d['minutes'])
            && $this->matchCronExpression($e[1], $d['hours'])
            && $this->matchCronExpression($e[2], $d['mday'])
            && $this->matchCronExpression($e[3], $d['mon'])
            && $this->matchCronExpression($e[4], $d['wday']);

        if ($match) {
            $this->setCreatedAt(strftime('%Y-%m-%d %H:%M:%S', time()));
            $this->setScheduledAt(strftime('%Y-%m-%d %H:%M', $time));
        }
        return $match;
    }

    public function matchCronExpression($expr, $num)
    {
        // handle ALL match
        if ($expr==='*') {
            return true;
        }

        // handle multiple options
        if (strpos($expr,',')!==false) {
            foreach (explode(',',$expr) as $e) {
                if ($this->matchCronExpression($e, $num)) {
                    return true;
                }
            }
            return false;
        }

        // handle modulus
        if (strpos($expr,'/')!==false) {
            $e = explode('/', $expr);
            if (sizeof($e)!==2) {
                throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'match/modulus': ".$expr);
            }
            if (!is_numeric($e[1])) {
                throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting numeric modulus: ".$expr);
            }
            $expr = $e[0];
            $mod = $e[1];
        } else {
            $mod = 1;
        }

        // handle all match by modulus
        if ($expr==='*') {
            $from = 0;
            $to = 60;
        }
        // handle range
        elseif (strpos($expr,'-')!==false) {
            $e = explode('-', $expr);
            if (sizeof($e)!==2) {
                throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'from-to' structure: ".$expr);
            }

            $from = $this->getNumeric($e[0]);
            $to = $this->getNumeric($e[1]);
        }
        // handle regular token
        else {
            $from = $this->getNumeric($expr);
            $to = $from;
        }

        if ($from===false || $to===false) {
            throw Mage::exception('Mage_Cron', "Invalid cron expression: ".$expr);
        }

        return ($num>=$from) && ($num<=$to) && ($num%$mod===0);
    }

    public function getNumeric($value)
    {
        static $data = array(
            'jan'=>1,
            'feb'=>2,
            'mar'=>3,
            'apr'=>4,
            'may'=>5,
            'jun'=>6,
            'jul'=>7,
            'aug'=>8,
            'sep'=>9,
            'oct'=>10,
            'nov'=>11,
            'dec'=>12,

            'sun'=>0,
            'mon'=>1,
            'tue'=>2,
            'wed'=>3,
            'thu'=>4,
            'fri'=>5,
            'sat'=>6,
        );

        if (is_numeric($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = strtolower(substr($value,0,3));
            if (isset($data[$value])) {
                return $data[$value];
            }
        }

        return false;
    }

    /**
     * Sets a job to STATUS_RUNNING only if it is currently in STATUS_PENDING.
     * Returns true if status was changed and false otherwise.
     *
     * This is used to implement locking for cron jobs.
     *
     * @return boolean
     */
    public function tryLockJob()
    {
        return $this->_getResource()->trySetJobStatusAtomic($this->getId(), self::STATUS_RUNNING, self::STATUS_PENDING);
    }
}