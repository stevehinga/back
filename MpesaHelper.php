<?php

class MpesaHelper {

    /**
     * This is used to generate tokens for the live environment
     * @return mixed
     */
    public static function generateLiveToken() {
        // Manually setting the Consumer Key and Secret
        $consumer_key = 'NkBADucrKFaTYKenfGKwzCjL6yPeLOcAudXj5Ue3gBWjnSvi'; // Replace with your consumer key
        $consumer_secret = 'MDy5GcPUrgHAT7247zGpPd3z7umVD70Volw8jJJLqoniVIaA8gIGxd6WoqaKGE5E'; // Replace with your consumer secret

        // Ensure the credentials are set
        if (!isset($consumer_key) || !isset($consumer_secret)) {
            die("Please declare the consumer key and consumer secret as defined in the documentation.");
        }

        // Safaricom OAuth token URL (live environment)
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        // Initialize cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        // Add Authorization Header with the credentials
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        
        // Basic cURL settings
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL verification for production

        // Execute the cURL request
        $curl_response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get HTTP status code
        
        // Close the cURL session
        curl_close($curl);

        // Check for cURL errors or non-200 response
        if ($curl_response === false || $httpCode !== 200) {
            $errorMsg = curl_error($curl) ?: "HTTP Status: $httpCode - Error while generating access token.";
            die("Error: $errorMsg");
        }

        // Decode the JSON response
        $response = json_decode($curl_response);

        // Return the access token or handle error
        if (isset($response->access_token)) {
            return $response->access_token;
        } else {
            die("Error: Failed to generate access token. Response: " . json_encode($response));
        }
    }
}

?>
