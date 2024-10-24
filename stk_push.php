<?php
// Handle preflight (OPTIONS) request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Send necessary CORS headers for preflight request
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200); // Always respond with 200 for preflight
    exit();
}

// CORS headers for actual requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Proceed with your existing backend logic below
// Include the MpesaHelper class for token generation
include 'MpesaHelper.php';

$request = json_decode(file_get_contents('php://input'), true);

if (!isset($request['phoneNumber']) || !isset($request['amount'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing phone number or amount.']);
    exit;
}

$phoneNumber = preg_replace('/\D/', '', $request['phoneNumber']);
$amount = $request['amount'];

if (strlen($phoneNumber) !== 12 || substr($phoneNumber, 0, 3) !== '254') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid phone number format.']);
    exit;
}

$accessToken = MpesaHelper::generateLiveToken();
$url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$shortCode = '4904586';
$passKey = '52fae986b1f97de25c3eeb3535baf53016e80b248dd9ac7222d61688d89dcb4c';
$callbackURL = 'https://mchwaapi.wifimashinani.co.ke/callback_url.php';

$timestamp = date("YmdHis");
$password = base64_encode($shortCode . $passKey . $timestamp);

$stkPushData = [
    "BusinessShortCode" => $shortCode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phoneNumber,
    "PartyB" => $shortCode,
    "PhoneNumber" => $phoneNumber,
    "CallBackURL" => $callbackURL,
    "AccountReference" => "WIFI_PURCHASE",
    "TransactionDesc" => "Payment for WiFi"
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkPushData));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 60);  // Extended timeout for slower connections

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);
curl_close($curl);

// Log detailed response and cURL errors
$logData = [
    'httpCode' => $httpCode,
    'curlError' => $curlError,
    'response' => json_decode($response, true)
];
file_put_contents('mpesa_stk_debug.log', json_encode($logData, JSON_PRETTY_PRINT), FILE_APPEND);

if ($curlError) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to initiate payment. cURL Error: ' . $curlError]);
    exit;
}

$responseData = json_decode($response, true);

if ($httpCode === 200 && isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
    echo json_encode(['status' => 'success', 'message' => 'Payment initiated successfully. Check your phone.']);
} else {
    file_put_contents('mpesa_stk_debug.log', "Error in STK Push: " . json_encode($responseData, JSON_PRETTY_PRINT), FILE_APPEND);

    $errorMessage = isset($responseData['errorMessage']) ? $responseData['errorMessage'] : 'Unknown error occurred.';
    echo json_encode(['status' => 'error', 'message' => 'Failed to initiate payment. Error: ' . $errorMessage]);
}
