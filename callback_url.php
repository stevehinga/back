<?php
// Include your MikroTik API file and database connection
include 'mikrotikAPI.php';
include 'config.php';

// Read the MPesa callback from Safaricom
$callbackData = json_decode(file_get_contents('php://input'), true);

// Log the callback for debugging
file_put_contents('mpesa_stk_debug.log', json_encode($callbackData, JSON_PRETTY_PRINT), FILE_APPEND);

// Verify that the transaction was successful
if ($callbackData['Body']['stkCallback']['ResultCode'] == 0) {
    // Get payment details from the callback
    $phoneNumber = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
    $amountPaid = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $transactionID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];

    // Retrieve the MAC address from the database based on phone number or transaction ID
    $result = $conn->query("SELECT mac_address, package FROM sessions WHERE phone_number = '$phoneNumber' AND status = 'pending'");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $macAddress = $row['mac_address'];
        $package = $row['package'];

        // Instantiate MikroTik API
        $mikrotikAPI = new MikroTikAPI('router_ip', 'admin', 'password');

        // Grant access by adding MAC address to the HotSpot user list
        $timeLimit = ($package == '24_hours') ? '24h' : '1h';  // Example package-based time limit
        $mikrotikAPI->addMacToHotspot($macAddress, $timeLimit);

        // Update the session status in the database
        $conn->query("UPDATE sessions SET status = 'active' WHERE mac_address = '$macAddress'");

        // Log success
        file_put_contents('mpesa_stk_debug.log', "Payment successful, access granted to MAC: $macAddress for $timeLimit.", FILE_APPEND);
    } else {
        // Handle the case where MAC address was not found
        file_put_contents('mpesa_stk_debug.log', "MAC address not found for phone: $phoneNumber.", FILE_APPEND);
    }
} else {
    // Log payment failure
    file_put_contents('mpesa_stk_debug.log', "Payment failed for transaction ID: " . $callbackData['Body']['stkCallback']['CheckoutRequestID'], FILE_APPEND);
}
?>
