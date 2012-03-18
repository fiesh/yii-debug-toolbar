<?php
/**
 * YiiDebugToolbarPanelLogging class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelLogging represents an ...
 *
 * Description of YiiDebugToolbarPanelLogging
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbarPanelLogging extends YiiDebugToolbarPanel
{
    /**
     * Message count.
     *
     * @var integer
     */
    private $_countMessages;

    /**
     * Logs.
     *
     * @var array
     */
    private $_logs;

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        $time = round(Yii::getLogger()->getExecutionTime(),2);
        $mem = round(Yii::getLogger()->getMemoryUsage()/1048576,1);
        return "<span>$time</span>s / <span>$mem</span>mb";
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return YiiDebug::t('Log Messages');
    }

    /**
     * Get logs.
     *
     * @return array
     */
    public function getLogs()
    {
        if (null === $this->_logs)
        {
            $this->_logs = $this->filterLogs();
        }
        return $this->_logs;
    }

    /**
     * Get count of messages.
     *
     * @return integer
     */
    public function getCountMessages()
    {
        if (null === $this->_countMessages)
        {
            $this->_countMessages = count($this->logs);
        }
        return $this->_countMessages;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $profileLogs = $this->getProfileLogs($this->logs);

        $this->render('logging', array(
            'logs' => $this->logs,
            'profileLogs' => $this->processSummary($profileLogs),
        ));
    }

    /**
     * Get filter logs.
     *
     * @return array
     */
    protected function filterLogs()
    {
        $logs = array();
        foreach ($this->owner->getLogs() as $entry)
        {
            if (CLogger::LEVEL_PROFILE !== $entry[1] && false === strpos($entry[2], 'system.db.CDbCommand'))
            {
                $logs[] = $entry;
            }
        }
        return $logs;
    }

    /**
     * Gets profile logs (not db ones)
     * @return array
     */
    protected function getProfileLogs() {
        $logs = array();
        foreach ($this->owner->getLogs() as $entry)
        {
            if (CLogger::LEVEL_PROFILE === $entry[1] && false === strpos($entry[2], 'system.db.CDbCommand'))
            {
                $logs[] = $entry;
            }
        }
        return $logs;
    }

    /**
     * Processing summary.
     *
     * @param array $logs Logs.
     * @return array
     */
    protected function processSummary(array $logs)
    {
        if (empty($logs))
        {
            return $logs;
        }
        $stack = array();
        foreach($logs as $log)
        {
            $message = $log[0];
            if(0 === strncasecmp($message, 'begin:', 6))
            {
                $log[0]  =substr($message, 6);
                $stack[] =$log;
            }
            else if(0 === strncasecmp($message,'end:',4))
            {
                $token = substr($message,4);
                if(null !== ($last = array_pop($stack)) && $last[0] === $token)
                {
                    $delta = $log[3] - $last[3];

                    if(isset($results[$token]))
                        $results[$token] = $this->aggregateResult($results[$token], $delta);
                    else{
                        $results[$token] = array($token, 1, $delta, $delta, $delta);
                    }
                }
                else
                    throw new CException(Yii::t('yii-debug-toolbar',
                        'Mismatching code block "{token}". Make sure the calls to Yii::beginProfile() and Yii::endProfile() be properly nested.',
                        array('{token}' => $token)));
            }
        }

        $now = microtime(true);
        while(null !== ($last = array_pop($stack)))
        {
            $delta = $now - $last[3];
            $token = $last[0];

            if(isset($results[$token]))
                $results[$token] = $this->aggregateResult($results[$token], $delta);
            else{
                $results[$token] = array($token, 1, $delta, $delta, $delta);
            }
        }

        $entries = array_values($results);
        $func    = create_function('$a,$b','return $a[4]<$b[4]?1:0;');

        usort($entries, $func);

        return $entries;
    }

    /**
     * Aggregates the report result.
     * @param array $result log result for this code block
     * @param float $delta time spent for this code block
     * @return array
     */
    protected function aggregateResult($result,$delta)
    {
        list($token,$calls,$min,$max,$total)=$result;
        if($delta<$min)
            $min=$delta;
        else if($delta>$max)
            $max=$delta;
        $calls++;
        $total+=$delta;
        return array($token,$calls,$min,$max,$total);
    }
}
