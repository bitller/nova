<?php

namespace App\Helpers;

use App\LogType;

/**
 * Helpers for log types
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogTypes {

    /**
     * Info key
     *
     * @var string
     */
    private $infoKey = 'info';

    /**
     * Warning key
     *
     * @var string
     */
    private $warningKey = 'warning';

    /**
     * Danger key
     *
     * @var string
     */
    private $dangerKey = 'danger';

    /**
     * Return log type id that match the given key
     *
     * @param string $key
     * @return int
     */
    public function getLogTypeId($key) {

        $logType = new LogType();
        $log = $logType->where('key', $key)->first();

        return $log->id;

    }

    /**
     * Return info id
     *
     * @return mixed
     */
    public function getInfoId() {
        return $this->getLogTypeId($this->infoKey);
    }

    /**
     * Return warning id
     *
     * @return int
     */
    public function getWarningId() {
        return $this->getLogTypeId($this->warningKey);
    }

    /**
     * Return danger id
     *
     * @return int
     */
    public function getDangerId() {
        return $this->getLogTypeId($this->dangerKey);
    }

}