<?php

namespace SevenShores\Hubspot\Resources;

use SevenShores\Hubspot\Exceptions\HubspotException;

class Deals extends Resource
{
    /**
     * @param array $deal Array of deal properties.
     * @return mixed
     * @throws HubSpotException
     */
    public function create(array $deal)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal";

        $options['json'] = $deal;

        return $this->client->request('post', $endpoint, $options);
    }

    /**
     * @param int $id The deal id.
     * @param array $deal The deal properties to update.
     * @return mixed
     */
    public function update($id, array $deal)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$id}";

        $options['json'] = $deal;

        return $this->client->request('put', $endpoint, $options);
    }

    /**
     * Update a group of existing deal records by their dealId.
     *
     * @see https://developers.hubspot.com/docs/methods/deals/batch-update-deals
     *
     * @param array $deals The deals and properties.
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function updateBatch(array $deals)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/batch-async/update";

        $options['json'] = $deals;

        return $this->client->request('post', $endpoint, $options);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\SevenShores\Hubspot\Http\Response
     * @throws \SevenShores\Hubspot\Exceptions\BadRequest
     */
    public function getAll(array $params = [])
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/paged";

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$id}";

        return $this->client->request('delete', $endpoint);
    }

    /**
     * @param array $params Optional parameters ['limit', 'offset']
     * @return mixed
     */
    public function getRecentlyModified(array $params = [])
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/recent/modified";
        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * @param array $params Optional parameters ['limit', 'offset']
     * @return mixed
     */
    public function getRecentlyCreated(array $params = [])
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/recent/created";
        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$id}";

        return $this->client->request('get', $endpoint);
    }

    /**
     * @param int $dealId
     * @param int|int[] $companyIds
     * @return mixed
     */
    public function associateWithCompany($dealId, $companyIds)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$dealId}/associations/COMPANY";

        $queryString = build_query_string(['id' => (array)$companyIds]);

        return $this->client->request('put', $endpoint, [], $queryString);
    }

    /**
     * @param int $dealId
     * @param int|int[] $companyIds
     * @return mixed
     */
    public function disassociateFromCompany($dealId, $companyIds)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$dealId}/associations/COMPANY";

        $queryString = build_query_string(['id' => (array)$companyIds]);

        return $this->client->request('delete', $endpoint, [], $queryString);
    }

    /**
     * @param int $dealId
     * @param int|int[] $contactIds
     * @return mixed
     */
    public function associateWithContact($dealId, $contactIds)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$dealId}/associations/CONTACT";

        $queryString = build_query_string(['id' => (array)$contactIds]);

        return $this->client->request('put', $endpoint, [], $queryString);
    }

    /**
     * @param int $contactId
     * @param array $params Optional parameters ['limit', 'offset']
     * @return mixed
     */
    public function associatedWithContact($contactId, $params = [])
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/associated/contact/{$contactId}/paged";

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }

    /**
     * @param int $dealId
     * @param int|int[] $contactIds
     * @return mixed
     */
    public function disassociateFromContact($dealId, $contactIds)
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/{$dealId}/associations/CONTACT";

        $queryString = build_query_string(['id' => (array)$contactIds]);

        return $this->client->request('delete', $endpoint, [], $queryString);
    }

    /**
     * @param string $objectType
     * @param int $objectId
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface|\SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/deals/get-associated-deals
     */
    public function getAssociatedDeals($objectType, $objectId, $params = [])
    {
        $endpoint = "https://api.hubapi.com/deals/v1/deal/associated/{$objectType}/{$objectId}/paged";

        $queryString = build_query_string($params);

        return $this->client->request('get', $endpoint, [], $queryString);
    }
}
