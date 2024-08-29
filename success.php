<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2ecc71;
        }
        p {
            color: #333;
            margin: 10px 0;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Retrieve payment ID from the query string
        $paymentId = $_GET['payment_id'];

        // Your Tabby Pay secret key
        $secretKey = 'sk_test_df211283-3811-4bd0-8863-3202301ccd2c'; // Replace with your actual secret key

        // API endpoint to retrieve payment details
        $apiUrl = "https://api.tabby.ai/api/v1/payments/$paymentId";

        // Set up cURL
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $secretKey"
        ]);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            echo '<h1>Error retrieving payment details.</h1>';
            exit;
        }

        // Close cURL
        curl_close($curl);



        // Decode the JSON response
        $paymentDetails = json_decode($response, true);


//         echo"<pre>";
// print_r($paymentDetails);

// echo"</pre>";


        // Handle payment details
        if ($paymentDetails && isset($paymentDetails['id'])) {
            // Extract relevant data from $paymentDetails
            $amount = $paymentDetails['amount'];
            $status = $paymentDetails['status'];

            // Output payment details
            echo "<h1>Payment Details</h1>";
            echo "<p>Amount: $amount</p>";
            echo "<p>Status: $status</p>"; // Display the status
        } else {
            echo '<h1>Error retrieving payment details.</h1>';
        }
        ?>
        <p><a href="index.php">Go back to homepage</a></p>
    </div>
</body>
</html>
