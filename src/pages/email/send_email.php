<?php
session_start(); // Start the session

require '../../../vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;

function sendTestEmail($to, $subject, $messageText)
{
    $client = new Client();
    $client->setApplicationName('Gmail API PHP Quickstart');
    $client->setScopes(Gmail::GMAIL_SEND);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file
    $credentialsPath = 'token.json';

    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
        $client->setAccessToken($accessToken);
    }

    // Check if the token is valid
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            // If a refresh token is available, use it
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        } else {
            // No refresh token, so we need to go through the OAuth flow
            $authUrl = $client->createAuthUrl();
            header("Location: $authUrl");
            exit;
        }
    }

    // Create the Gmail service
    $service = new Gmail($client);

    // Prepare the email
    $rawMessage = "From: your-email@gmail.com\r\n";
    $rawMessage .= "To: $to\r\n";
    $rawMessage .= "Subject: $subject\r\n\r\n";
    $rawMessage .= $messageText;
    $rawMessage = base64_encode($rawMessage);
    $rawMessage = str_replace(['+', '/', '='], ['-', '_', ''], $rawMessage);

    $message = new Google\Service\Gmail\Message();
    $message->setRaw($rawMessage);

    try {
        $service->users_messages->send('me', $message);

        // Set session variable on success
        $_SESSION['success'] = "Email sent successfully to $to";
        header("Location: email_form.php");
        exit(); // Ensure no further code is executed
    } catch (Exception $e) {
        echo "Error sending email: " . $e->getMessage();
    }
}

// Start the process
if (isset($_GET['code'])) {
    $client = new Client();
    $client->setAuthConfig('credentials.json');

    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Store the access token in token.json
        if (array_key_exists('access_token', $token)) {
            file_put_contents('token.json', json_encode($token));
            sendTestEmail('recipient@example.com', 'Test Email Subject', 'This is a test email message.');
        } else {
            echo "Error retrieving access token: " . json_encode($token);
        }
    } catch (Exception $e) {
        echo "Error retrieving access token: " . $e->getMessage();
    }
} else {
    sendTestEmail('recipient@example.com', 'Test Email Subject', 'This is a test email message.');
}
