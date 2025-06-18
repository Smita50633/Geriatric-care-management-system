

<?php
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

// Twilio credentials
$sid = "";
$token = "";
$twilio = new Client($sid, $token);

// Ensure the phone number is in E.164 format
$to = ""; // Replace with valid number
$from = ""; // Your Twilio number

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
