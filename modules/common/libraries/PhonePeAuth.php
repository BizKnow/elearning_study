<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PhonePeAuth {
    private $client;
    private $clientId;
    private $clientSecret;
    private $baseUrl;

    public function __construct() {
        $this->client = new Client();
        $this->clientId = PHONEPAY_MID; // Replace with your Client ID
        $this->clientSecret = PHONEPAY_SALT; // Replace with your Client Secret
        $this->baseUrl = "https://api.phonepe.com/apis/identity-manager/v1/oauth/token";
    }

    // 🔹 Fetch OAuth Token
    public function getAuthToken() {
        try {
            $response = $this->client->post($this->baseUrl, [
                "headers" => [
                    "Content-Type" => "application/x-www-form-urlencoded"
                ],
                "form_params" => [
                    "clientId" => $this->clientId,
                    "clientSecret" => $this->clientSecret,
                    "grantType" => "client_credentials"
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
