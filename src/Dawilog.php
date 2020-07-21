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

    public function __construct()
    {
        $this->client = new GuzzleClient();
        $this->dsn = config('dawilog.dsn');
    }

    public function sendException($exception)
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

    public function send($objDawilogEvent)
    {
//        $request = $this->factory->createRequest(
//            'POST',
//            $this->getUrl(),
//            [
//                'Content-Type' => 'application/json',
//            ],
//            JSON::encode($objDawilogEvent->toArray())
//        );

//        $url = $this->getUrl();
//        $body = "{'dd':'test123'}";
//        $b = JSON::encode($objDawilogEvent->toArray());
//
//        $request = new GuzzleRequest(
//            'POST',
//            $this->getUrl(),
//            [
//                'Content-Type' => 'application/json',
//            ],
//            $body
//        );
//
//
//        try {
//            $response = $this->client->send($request, ['timeout' => 2]);
//        } catch (GuzzleException $e) {
//        }


//        $promise = $this->client->sendAsync($request);
//
//        $promise->then(
//            function (ResponseInterface $res) {
//                echo $res->getStatusCode() . "\n";
//            },
//            function (RequestException $e) {
//                echo $e->getMessage() . "\n";
//                echo $e->getRequest()->getMethod();
//            }
//        );

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




        $a= "end";
    }

    public function getUrl()
    {
        [$url, $uuid, $account, $project] = explode(":", $this->dsn);
        $strReturn = "https://" . $url . "/dwlog/event/" . $account . "/" . $project . "/" . $uuid;

        return $strReturn;
    }


}