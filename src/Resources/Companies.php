<?php

namespace SevenShores\Hubspot\Resources;

class Companies extends Resource
{

    /**
     * Create a company
     * @param array $properties Array of company properties.
     *
     * @see http://developers.hubspot.com/docs/methods/companies/create_company
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function create($properties)
    {
        $endpoint = 'https://api.hubapi.com/companies/v2/companies/';
        $options['json'] = ['properties' => $properties];

        return $this->client->request('post', $endpoint, $options);
    }

    /**
     * Updates a company
     * @param int $id The company id.
     * @param array $properties The company properties to update.
     *
     * @see http://developers.hubspot.com/docs/methods/companies/update_company
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function update($id, $properties)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$id}";
        $options['json'] = ['properties' => $properties];

        return $this->client->request('put', $endpoint, $options);
    }

    /**
     * @param array $companies The companies and properties.
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function updateBatch($companies)
    {
        $endpoint = "https://api.hubapi.com/companies/v1/batch-async/update";
        $options['json'] = $companies;

        return $this->client->request('post', $endpoint, $options);
    }

    /**
     * Deletes a company
     * @param int $id The company id
     *
     * @see http://developers.hubspot.com/docs/methods/companies/delete_company
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function delete($id)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$id}";

        return $this->client->request('delete', $endpoint);
    }

    /**
     * Returns all companies
     * @param array $params Array of optional parameters ['limit', 'offset', 'properties']
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get-all-companies
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function all($params = [])
    {
        $endpoint = 'https://api.hubapi.com/companies/v2/companies/paged';

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * Returns the recently modified companies
     * @param array $params Array of optional parameters ['count', 'offset']
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get_companies_modified
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getRecentlyModified($params = [])
    {
        $endpoint = 'https://api.hubapi.com/companies/v2/companies/recent/modified';

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * Returns the recently created companies
     * @param array $params Array of optional parameters ['count', 'offset']
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get_companies_created
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getRecentlyCreated($params = [])
    {
        $endpoint = 'https://api.hubapi.com/companies/v2/companies/recent/created';

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * Returns an array of companies that have a matching domain
     * @deprecated use searchByDomain instead
     * @param string $domain The domain of the company eq. 'example.com'.
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get_companies_by_domain
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getByDomain($domain)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/domain/{$domain}";

        return $this->client->request('get', $endpoint);
    }

    /**
     * @param string $domain
     * @param array $properties
     * @param int $limit
     * @param int $offset
     *
     * @see https://developers.hubspot.com/docs/methods/companies/search_companies_by_domain
     *
     * @return \Psr\Http\Message\ResponseInterface|\SevenShores\Hubspot\Http\Response
     */
    public function searchByDomain($domain, $properties = [], $limit = 100, $offset = 0)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/domains/{$domain}/companies";
        $options['json'] = [
            'limit' => $limit,
            'offset' => [
                'isPrimary' => true,
                'companyId' => $offset
            ],
            'requestOptions' => [
                'properties' => $properties
            ]
        ];
        return $this->client->request('post', $endpoint, $options);
    }

    /**
     * Returns a company with id $id
     * @param int $id
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get_company
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getById($id)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$id}";

        return $this->client->request('get', $endpoint);
    }

    /**
     * Associates a given contact to a given company
     * If a contact is already associated to a different company, the contact will be added to the new company
     * @param int $contactId
     * @param int $companyId
     *
     * @see http://developers.hubspot.com/docs/methods/companies/add_contact_to_company
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function addContact($contactId, $companyId)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$companyId}/contacts/{$contactId}";

        return $this->client->request('put', $endpoint);
    }

    /**
     * Returns an array of the associated contacts for the given company
     * @param int $companyId The id of the company.
     * @param array $params Array of optional parameters ['count', 'vidOffset']
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get_company_contacts
     * @see CrmAssociations::get is used to manage associations between objects
     *
     * @deprecated
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getAssociatedContacts($companyId, $params = [])
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$companyId}/contacts";

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * Returns all of the contact IDs who are associated with the given company
     * @param int $companyId The id of the company.
     * @param array $params Array of optional parameters ['count', 'vidOffset']
     *
     * @see http://developers.hubspot.com/docs/methods/companies/get_company_contacts_by_id
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getAssociatedContactIds($companyId, $params = [])
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$companyId}/vids";

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * Removes a contact from a company
     * @param int $contactId
     * @param int $companyId
     *
     * @see http://developers.hubspot.com/docs/methods/companies/remove_contact_from_company
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function removeContact($contactId, $companyId)
    {
        $endpoint = "https://api.hubapi.com/companies/v2/companies/{$companyId}/contacts/{$contactId}";

        return $this->client->request('delete', $endpoint);
    }
}
