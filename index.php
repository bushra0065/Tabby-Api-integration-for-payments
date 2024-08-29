<?php
$apiUrl = "https://api.tabby.ai/api/v2/checkout";


$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer pk_test_f08c30c1-9a66-4708-9d26-6ef547c732f6'
);


$currency = "AED"; 
$merchantCode = "li"; 


$orderData = array(
    "tax_amount" => "5.00",
    "shipping_amount" => "0.00",
    "discount_amount" => "0.00",
    "updated_at" => "2019-08-24T14:15:22Z",
    "reference_id" => "string",
    // "items" => array(
    //     array(
    //         "title" => "Product 1",
    //         "description" => "Product 1 description",
    //         "quantity" => 1,
    //         "unit_price" => "20.00",
    //         "discount_amount" => "0.00",
    //         "reference_id" => "item_1",
    //         "image_url" => "http://example.com/product1.jpg",
    //         "product_url" => "http://example.com/product1",
    //         "gender" => "Male",
    //         "category" => "Clothing",
    //         "color" => "Blue",
    //         "product_material" => "Cotton",
    //         "size_type" => "Regular",
    //         "size" => "M",
    //         "brand" => "Brand X"
    //     ),
    //     array(
    //         "title" => "Product 2",
    //         "description" => "Product 2 description",
    //         "quantity" => 2,
    //         "unit_price" => "30.00",
    //         "discount_amount" => "0.00",
    //         "reference_id" => "item_2",
    //         "image_url" => "http://example.com/product2.jpg",
    //         "product_url" => "http://example.com/product2",
    //         "gender" => "Female",
    //         "category" => "Accessories",
    //         "color" => "Red",
    //         "product_material" => "Leather",
    //         "size_type" => "One Size",
    //         "size" => "NA",
    //         "brand" => "Brand Y"
    //     )

    // )
);

$data = array(
    "payment" => array(
        "amount" => "105",
        "currency" => $currency,
        "description" => "string",
        "buyer" => array(
            "phone" => "500000001",
            "email" => "card.success@tabby.ai",
            "name" => "string",
            "dob" => "2019-08-24"
        ),
        "buyer_history" => array(
            "registered_since" => "2019-08-24T14:15:22Z",
            "loyalty_level" => 0,
            "wishlist_count" => 0,
            "is_social_networks_connected" => true,
            "is_phone_number_verified" => true,
            "is_email_verified" => true
        ),
        "order" => $orderData,
        "shipping_address" => array(
            "city" => "string",
            "address" => "string",
            "zip" => "string"
        ),
        "meta" => array(
            "order_id" => "#1234",
            "customer" => "#customer-id"
        ),
        "attachment" => array(
            "body" => "{\"flight_reservation_details\": {\"pnr\": \"TR9088999\",\"itinerary\": [...],\"insurance\": [...],\"passengers\": [...],\"affiliate_name\": \"some affiliate\"}}",
            "content_type" => "application/vnd.tabby.v1+json"
        )
    ),
    
    "lang" => "en",
    "merchant_code" => $merchantCode,
    "merchant_urls" => array(
        "success" => "http://localhost/tabby.php/success.php",
        "cancel" => "http://localhost/tabby.php/cancel.php",
        "failure" => "http://localhost/tabby.php/fail.php"
    )
);


$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'cURL error: ' . curl_error($curl);
} else {
    // Parse the API response
    $responseData = json_decode($response, true);

    if ($responseData) {
        // Extract payment details
        $paymentId = $responseData['payment']['id'];
        $amount = $responseData['payment']['amount'];
        $currency = $responseData['payment']['currency'];

        // Check if the required indexes exist in the response
        if (isset($responseData['configuration']['available_products']['installments'][0]['web_url'])) {
            $webUrl = $responseData['configuration']['available_products']['installments'][0]['web_url'];
            echo "Payment URL: <a href='$webUrl'>Complete Payment</a><br>";
        } else {
            echo "Payment URL not found in response.<br>";
        }

        if (isset($responseData['configuration']['available_products']['installments'][0]['qr_code'])) {
            $qrCodeUrl = $responseData['configuration']['available_products']['installments'][0]['qr_code'];
            echo "QR Code URL: <a href='$qrCodeUrl'>QR Code</a><br>";
        } else {
            echo "QR Code URL not found in response.<br>";
        }

        // Display the extracted information to the user or do further processing
        echo "Payment ID: $paymentId<br>";
        echo "Amount: $amount $currency<br>";
    } else {
        // Handle parsing error or empty response
        echo "Error parsing API response.";
    }
}
?>
