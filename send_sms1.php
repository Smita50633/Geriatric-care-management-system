

<?php
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

// Twilio credentials
$sid = "AC23ab781639900367433e8a0c3977f183";
$token = "5e678811209a993b7e34c667149a8923";
$twilio = new Client($sid, $token);

// Ensure the phone number is in E.164 format
$to = "+917411017326"; // Replace with valid number
$from = "+18059940688"; // Your Twilio number

try {
    $message = $twilio->messages->create(
        $to,
        [
            "from" => $from,
            "body" => "🚨Emergency Alert.Need your attention!"
        ]
    );

    // Send JavaScript alert and stay on the same page
    echo "<script>
            alert(" . json_encode('Message sent successfully!') . ");
            window.location.href = document.referrer;
          </script>";
} catch (Exception $e) {
    echo "<script>
            alert(" . json_encode('Error: ' . $e->getMessage()) . ");
            window.location.href = document.referrer;
          </script>";
}
?>
