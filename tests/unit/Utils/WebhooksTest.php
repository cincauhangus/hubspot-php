<?php

namespace SevenShores\Hubspot\Tests\Unit\Utils;

use SevenShores\Hubspot\Utils;

class WebhooksTest extends \PHPUnit_Framework_TestCase
{
    protected $secret = 'clientSecret';
    protected $requestBody = 'SomeBody';
    
    /** @test */
    public function validation_hubspot_signature_valid_data()
    {
        $result = Utils\Webhooks::isHubspotSignatureValid(
            hash('sha256', $this->secret . $this->requestBody),
            $this->secret,
            $this->requestBody
        );
        
        $this->assertEquals(
            true,
            $result
        );
    }
    
    /** @test */
    public function validation_hubspot_signature_invalid_data()
    {
        $result = Utils\Webhooks::isHubspotSignatureValid(
            hash('sha256', $this->secret . $this->requestBody . '1'),
            $this->secret,
            $this->requestBody
        );
        
        $this->assertEquals(
            false,
            $result
        );
    }
}
