<?php

// Set your Tabby Pay credentials
$publicKey = 'pk_test_f08c30c1-9a66-4708-****'; 
$secretKey = 'sk_test_df211283-3811-4bd0-****8'; 


$baseUrl = 'https://api.tabby.ai/api/v1';
$paymentsEndpoint = $baseUrl . '/payments';


$queryParams = [
    
];

// Prepare headers
$headers = [
    'Authorization: Bearer ' . $secretKey,
];

// Build the API URL with query parameters
$apiUrl = $paymentsEndpoint . '?' . http_build_query($queryParams);

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
]);

// Execute cURL request and get the response
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
    echo 'cURL Error: ' . curl_error($curl);
}

// Close cURL session
curl_close($curl);

// Decode the JSON response
$data = json_decode($response, true);

// Simulated payment IDs from the dashboard
$dashboardPaymentIds = ['b1b1263c-b01f-4099-beb8-aea20591efe1', 'fbc927e6-9b2f-4d34-b129-fe214f01b102'];

// Display the payment data in a styled table
if (isset($data['payments'])) {
    echo '<style>
            table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #ddd;
                margin-top: 20px;
            }
            
            th, td {
                text-align: left;
                padding: 8px;
            }
            
            th {
                background-color: #f2f2f2;
            }
            
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
          </style>';
    
    echo '<table>';
    echo '<tr><th>Payment ID</th><th>Amount</th><th>Currency</th><th>Status</th><th>Type</th><th>Customer</th><th>Refunded</th><th>Creation Date</th><th>Order Number</th></tr>';
    foreach ($data['payments'] as $payment) {
        if (in_array($payment['id'], $dashboardPaymentIds)) {
            echo '<tr>';
            echo '<td>' . $payment['id'] . '</td>';
            echo '<td>' . $payment['amount'] . '</td>';
            echo '<td>' . $payment['currency'] . '</td>';
            echo '<td>' . $payment['status'] . '</td>';
            echo '<td>' . $payment['product']['type'] . '</td>';
            echo '<td>' . $payment['buyer']['name'] . '</td>';
            echo '<td>' . (isset($payment['refunds']) && !empty($payment['refunds']) ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $payment['created_at'] . '</td>';
            echo '<td>' . $payment['order']['reference_id'] . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
} else {
    echo 'No payments found.';
}
?>
