<?php

namespace FinacialIndexProfile\Client;

use \FinacialIndexProfile\Client\Configuration;
use \FinacialIndexProfile\Client\ApiException;
use \FinacialIndexProfile\Client\ObjectSerializer;

class FipApiTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        $password = getenv('KEY_PASSWORD');
        $this->signer = new \FinacialIndexProfile\Client\Interceptor\KeyHandler(
            "/example/route/keypair.p12",
            "/example/route/cdc_cert_dev.pem",
            $password
        );
        $config = new \FinacialIndexProfile\Client\Configuration();
        $config->setHost('the_url');

        $events = new \FinacialIndexProfile\Client\Interceptor\MiddlewareEvents($this->signer);
        $handler = \GuzzleHttp\HandlerStack::create();
        $handler->push($events->add_signature_header('x-signature'));
        $handler->push($events->verify_signature_header('x-signature'));

        $client = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->apiInstance = new \FinacialIndexProfile\Client\Api\FipApi($client, $config);
        $this->x_api_key = "your_api_key";
        $this->username = "your_username";
        $this->password = "your_password";
    }

    public function testMadurez()
    {
        $folioConsulta = "10000000";
        try {
            $result = $this->apiInstance->madurez($this->x_api_key, $this->username, $this->password, $folioConsulta);
            print_r($result);
            $this->assertTrue($result->getFolioScore()!==null);
        } catch (Exception $e) {
            echo 'Exception when calling MadurezSimulacionApi->getReporte: ', $e->getMessage(), PHP_EOL;
        }
    }
}
