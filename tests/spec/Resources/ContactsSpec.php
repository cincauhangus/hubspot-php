<?php

namespace spec\SevenShores\Hubspot\Resources;

use SevenShores\Hubspot\Http\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactsSpec extends ObjectBehavior
{
    private $client;

    private $apiKey = 'demo';

    private $baseUrl = 'https://api.hubapi.com';

    private $headers = [
        'User-Agent' => 'Fungku_HubSpot_PHP/0.9 (https://github.com/fungku/hubspot-php)',
    ];

    private function getUrl($endpoint)
    {
        return $this->baseUrl . $endpoint . '?hapikey=' . $this->apiKey;
    }

    public function let(Client $client)
    {
        $this->beConstructedWith('demo', $client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('SevenShores\Hubspot\Resources\Contacts');
    }
}
