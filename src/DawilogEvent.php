<?php

namespace Dawilog;

use Ramsey\Uuid\Uuid;

class DawilogEvent
{
    protected $eventId;
    protected $exceptions = [];
    protected $timestamp;
    protected $environment;
    protected $serverVars;
    protected $version;
    protected $release;
    protected $meta = [];

    /**
     * DawilogEvent constructor.
     */
    public function __construct()
    {
        $this->eventId = $uuid = Uuid::uuid4();
        $this->timestamp = gmdate('c');
        $this->environment = config('dawilog.environment');
        $this->serverVars = $_SERVER;
        $this->release = config('dawilog.release');

        if (is_callable(config('dawilog.callable-meta'))) {
            $arrMeta = config('dawilog.callable-meta');
            if (is_array($arrMeta)) {
                $this->meta = $arrMeta;
            }
        }
    }

    public function toArray()
    {
        $objReturn = [
            "event_id" => $this->eventId,
            "exceptions" => $this->exceptions,
            "timestamp" => $this->timestamp,
            "environment" => $this->environment,
            "server_vars" => $this->serverVars,
            "release" => $this->release,
            "meta" => $this->meta,
        ];

        if (!is_null($this->version)) {
            $objReturn['version'] = $this->version;
        }

        return $objReturn;
    }

    public function setExceptions($exceptions)
    {
        $this->exceptions = $exceptions;
    }
}
