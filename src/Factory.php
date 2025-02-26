<?php

namespace SevenShores\Hubspot;

use SevenShores\Hubspot\Http\Client;

/**
 * Class Factory.
 *
 * @method \SevenShores\Hubspot\Resources\Analytics          analytics()
 * @method \SevenShores\Hubspot\Resources\BlogAuthors        blogAuthors()
 * @method \SevenShores\Hubspot\Resources\BlogPosts          blogPosts()
 * @method \SevenShores\Hubspot\Resources\Blogs              blogs()
 * @method \SevenShores\Hubspot\Resources\BlogTopics         blogTopics()
 * @method \SevenShores\Hubspot\Resources\CalendarEvents     calendarEvents()
 * @method \SevenShores\Hubspot\Resources\Comments           comments()
 * @method \SevenShores\Hubspot\Resources\Companies          companies()
 * @method \SevenShores\Hubspot\Resources\CompanyProperties  companyProperties()
 * @method \SevenShores\Hubspot\Resources\ContactLists       contactLists()
 * @method \SevenShores\Hubspot\Resources\ContactProperties  contactProperties()
 * @method \SevenShores\Hubspot\Resources\Contacts           contacts()
 * @method \SevenShores\Hubspot\Resources\CrmAssociations    crmAssociations()
 * @method \SevenShores\Hubspot\Resources\CrmPipelines       crmPipelines()
 * @method \SevenShores\Hubspot\Resources\DealPipelines      dealPipelines()
 * @method \SevenShores\Hubspot\Resources\DealProperties     dealProperties()
 * @method \SevenShores\Hubspot\Resources\Deals              deals()
 * @method \SevenShores\Hubspot\Resources\EcommerceBridge    ecommerceBridge()
 * @method \SevenShores\Hubspot\Resources\Email              email()
 * @method \SevenShores\Hubspot\Resources\EmailEvents        emailEvents()
 * @method \SevenShores\Hubspot\Resources\Engagements        engagements()
 * @method \SevenShores\Hubspot\Resources\Events             events()
 * @method \SevenShores\Hubspot\Resources\Files              files()
 * @method \SevenShores\Hubspot\Resources\Forms              forms()
 * @method \SevenShores\Hubspot\Resources\HubDB              hubDB()
 * @method \SevenShores\Hubspot\Resources\Integration        integration()
 * @method \SevenShores\Hubspot\Resources\Keywords           keywords()
 * @method \SevenShores\Hubspot\Resources\OAuth2             oAuth2()
 * @method \SevenShores\Hubspot\Resources\Owners             owners()
 * @method \SevenShores\Hubspot\Resources\Pages              pages()
 * @method \SevenShores\Hubspot\Resources\SingleEmail        singleEmail()
 * @method \SevenShores\Hubspot\Resources\SocialMedia        socialMedia()
 * @method \SevenShores\Hubspot\Resources\Tickets            tickets()
 * @method \SevenShores\Hubspot\Resources\Timeline           timeline()
 * @method \SevenShores\Hubspot\Resources\Webhooks           webhooks()
 * @method \SevenShores\Hubspot\Resources\Workflows          workflows()
 */
class Factory
{
    /** @var Client */
    private $client;

    /**
     * C O N S T R U C T O R ( ^_^)y.
     *
     * @param array  $config        An array of configurations. You need at least the 'key'.
     * @param Client $client
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     */
    public function __construct($config = [], $client = null, $clientOptions = [], $wrapResponse = true)
    {
        $this->client = $client ?: new Client($config, null, $clientOptions, $wrapResponse);
    }

    /**
     * Create an instance of the service with an API key.
     *
     * @param string $api_key       Hubspot API key.
     * @param Client $client        An Http client.
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function create($api_key = null, $client = null, $clientOptions = [], $wrapResponse = true)
    {
        return new static(['key' => $api_key], $client, $clientOptions, $wrapResponse);
    }

    /**
     * Create an instance of the service with an Oauth token.
     *
     * @param string $token         Hubspot oauth access token.
     * @param Client $client        An Http client.
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function createWithToken($token, $client = null, $clientOptions = [], $wrapResponse = true)
    {
        return new static(['key' => $token, 'oauth' => true], $client, $clientOptions, $wrapResponse);
    }

    /**
     * Return an instance of a Resource based on the method called.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return \SevenShores\Hubspot\Resources\Resource
     */
    public function __call($name, $args)
    {
        $resource = 'SevenShores\\Hubspot\\Resources\\'.ucfirst($name);

        return new $resource($this->client);
    }
}
