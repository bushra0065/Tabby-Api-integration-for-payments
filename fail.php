<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
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
            color: #e74c3c;
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
        <h1>Payment Failed</h1>
        <?php
        // Retrieve payment ID from the query string
        $paymentId = $_GET['payment_id'];

        // Define a list of common failure reasons
        $failureReasons = array(
            "Payment declined by bank",
            "Invalid card details",
            "Insufficient funds",
            "Expired card",
            "Payment timeout",
            "Network error",
            "Transaction not allowed"
        );

        // Choose a random failure reason from the list
        $randomFailureReason = $failureReasons[array_rand($failureReasons)];

        // Output failure details
        echo "<p>Payment ID: $paymentId</p>";
        echo "<p>Failure Reason: $randomFailureReason</p>";
        ?>
        <p><a href="index.php">Go back to homepage</a></p>
    </div>
</body>
</html>
