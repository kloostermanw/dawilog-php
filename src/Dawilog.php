<?php

namespace Dawilog;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Psy\Util\Json;

class Dawilog
{
    /**
     * @var GuzzleClient
     */
    protected $client;
    protected $dsn;

    /**
     * Dawilog constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleClient();
        $this->dsn = config('dawilog.dsn');
    }

    /**
     * @param $exception
     */
    public function sendException($exception): void
    {
        $exceptions[] = [
            'type' => \get_class($exception),
            'value' => $exception->getMessage(),
            'trace' => $exception->getTrace(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        $objDawilogEvent = new DawilogEvent();
        $objDawilogEvent->setExceptions($exceptions);
        $this->send($objDawilogEvent);
    }

    /**
     * @param $objDawilogEvent
     */
    public function send($objDawilogEvent): void
    {
        $body = JSON::encode($objDawilogEvent->toArray());
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $options = [
            'verify' => false,
            'body' => $body,
            'headers' => $headers
        ];

        try {
            $response = $this->client->post($this->getUrl(), $options);
        } catch (GuzzleException $e) {
        }
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        [$url, $uuid, $account, $project] = explode(":", $this->dsn);
        $strReturn = "https://" . $url . "/dwlog/event/" . $account . "/" . $project . "/" . $uuid;

        return $strReturn;
    }
}