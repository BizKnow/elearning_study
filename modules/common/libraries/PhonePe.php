<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PhonePe {
    private $client;
    private $merchantId;
    private $saltKey;
    private $saltIndex;
    private $baseUrl;

    public function __construct() {
        $this->client = new Client();
        $this->merchantId = PHONEPAY_MID;//"YOUR_MERCHANT_ID"; // Replace with your Merchant ID
        $this->saltKey = PHONEPAY_SALT;//"YOUR_SALT_KEY"; // Replace with your Salt Key
        $this->saltIndex = 1;//"YOUR_SALT_INDEX"; // Replace with your Salt Index
        $this->baseUrl = "https://api.phonepe.com/apis/hermes";
    }

    // 🔹 Generate checksum
    private function generateChecksum($payload, $url) {
        $hash = hash("sha256", $payload . $url . $this->saltKey);
        return $hash . "###" . $this->saltIndex;
    }

    // 🔹 Make API request
    private function makeRequest($endpoint, $payload) {
        $encodedPayload = base64_encode(json_encode($payload));
        $checksum = $this->generateChecksum($encodedPayload, $endpoint);

        try {
            $response = $this->client->post($this->baseUrl . $endpoint, [
                "headers" => [
                    "Content-Type" => "application/json",
                    "X-VERIFY" => $checksum
                ],
                "json" => ["request" => $encodedPayload]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // 🔹 Initiate Payment
    public function initiatePayment($orderId, $amount, $callbackUrl, $mobile = null,$user_id = 'USER123') {
        $payload = [
            "merchantId" => $this->merchantId,
            "merchantTransactionId" => $orderId,
            "merchantUserId" => $user_id,
            "amount" => $amount, // Amount in paise
            "redirectUrl" => $callbackUrl,
            "callbackUrl" => $callbackUrl,
            "mobileNumber" => $mobile,
            "redirectMode" => 'POST',
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];

        return $this->makeRequest("/pg/v1/pay", $payload);
    }

    // 🔹 Check Payment Status
    public function checkPaymentStatus($orderId) {
        $endpoint = "/pg/v1/status/" . $this->merchantId . "/" . $orderId;
        $checksum = $this->generateChecksum("", $endpoint);

        try {
            $response = $this->client->get($this->baseUrl . $endpoint, [
                "headers" => [
                    "Content-Type" => "application/json",
                    "X-VERIFY" => $checksum
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // 🔹 Refund Payment
    public function refundPayment($orderId, $refundId, $amount) {
        $payload = [
            "merchantId" => $this->merchantId,
            "merchantTransactionId" => $orderId,
            "merchantUserId" => "USER123",
            "originalTransactionId" => $orderId,
            "refundTransactionId" => $refundId,
            "amount" => $amount, // Amount in paise
            "callbackUrl" => base_url("phonepe/refund_response"),
        ];

        return $this->makeRequest("/pg/v1/refund", $payload);
    }
}
