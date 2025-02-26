<?php

namespace SevenShores\Hubspot\Resources;

use SevenShores\Hubspot\Exceptions\BadRequest;
use SevenShores\Hubspot\Http\Response;
use SevenShores\Hubspot\Utils;

class OAuth2 extends Resource
{
    protected $endpoint = 'https://api.hubapi.com/oauth/v1';

    /**
     * Initiate an Integration with OAuth 2.0
     *
     * @param string $clientId      The Client ID of your app.
     * @param string $redirectURI   The URL that you want the visitor redirected to after granting access to your app. For security reasons, this URL must use https.
     * @param array  $scopes  A set of scopes that your app will need access to.
     * @param array  $optionalScopes   A set of optional scopes that your app will need access to.
     * @return string
     */
    public function getAuthUrl($clientId, $redirectURI, $scopes = [], $optionalScopes = [])
    {
        return Utils\OAuth2::getAuthUrl($clientId, $redirectURI, $scopes, $optionalScopes);
    }

    /**
     * Get OAuth 2.0 Access Token and Refresh Tokens by using a one-time code
     *
     * @param string $clientId The Client ID of your app.
     * @param string $clientSecret The Client Secret of your app.
     * @param string $redirectURI The redirect URI that was used when the user authorized your app. This must exactly match the redirect_uri used when initiating the OAuth 2.0 connection.
     * @param string $tokenCode The code parameter returned to your redirect URI when the user authorized your app. Or a refresh token.
     * @return Response
     * @throws BadRequest
     */
    public function getTokensByCode($clientId, $clientSecret, $redirectURI, $tokenCode)
    {
        $options['form_params'] = [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectURI,
            'code' => $tokenCode
        ];

        $options['headers']['content-type'] = 'application/x-www-form-urlencoded';

        return $this->client->request('post', $this->endpoint . '/token', $options, [], false);
    }

    /**
     * Get OAuth 2.0 Access Token and Refresh Tokens by using a refresh token
     * Note: Contrary to HubSpot documentation, $redirectURI is NOT required.
     *
     * @param string $clientId The Client ID of your app.
     * @param string $clientSecret The Client Secret of your app.
     * @param string $refreshToken The refresh token.
     * @return Response
     * @throws BadRequest
     */
    public function getTokensByRefresh($clientId, $clientSecret, $refreshToken)
    {
        $options['form_params'] = [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken
        ];

        $options['headers']['content-type'] = 'application/x-www-form-urlencoded';

        return $this->client->request('post', $this->endpoint . '/token', $options, null, false);
    }

    /**
     * Get Information for OAuth 2.0 Access Token
     *
     * @param int $token The access token that you want to get the information for.
     * @return Response
     * @throws BadRequest
     */
    public function getAccessTokenInfo($token)
    {
        return $this->client->request('get', $this->endpoint . "/access-tokens/{$token}", [], null, false);
    }

    /**
     * Get Information for OAuth 2.0 Refresh Token
     *
     * @param int $token The refresh token that you want to get the information for.
     * @return Response
     * @throws BadRequest
     */
    public function getRefreshTokenInfo($token)
    {
        return $this->client->request('get', $this->endpoint . "/refresh-tokens/{$token}", [], null, false);
    }

    /**
     * Delete OAuth 2.0 Refresh Token
     *
     * @param int $token The refresh token that you want to delete.
     * @return Response
     * @throws BadRequest
     */
    public function deleteRefreshToken($token)
    {
        return $this->client->request('delete', $this->endpoint . "/refresh-tokens/{$token}", [], null, false);
    }
}
