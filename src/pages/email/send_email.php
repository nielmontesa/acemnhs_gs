<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session at the beginning
session_start();

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
    $rawMessage = "From: nirumontesa@gmail.com\r\n"; // Replace with your actual email
    $rawMessage .= "To: $to\r\n";
    $rawMessage .= "Subject: $subject\r\n\r\n";
    $rawMessage .= $messageText;
    $rawMessage = base64_encode($rawMessage);
    $rawMessage = str_replace(['+', '/', '='], ['-', '_', ''], $rawMessage);

    $message = new Google\Service\Gmail\Message();
    $message->setRaw($rawMessage);

    try {
        $service->users_messages->send('me', $message);
        return true; // Return true if email sent successfully
    } catch (Exception $e) {
        return false; // Return false if there's an error
    }
}

// Start the process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $recipient = $_POST['email']; // Update to match the form input name
    $subject = $_POST['subject'];  // Update to match the form input name
    $content = $_POST['message'];   // Update to match the form input name

    // If there's an authorization code, handle it
    if (isset($_GET['code'])) {
        $client = new Client();
        $client->setAuthConfig('credentials.json');

        try {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            // Store the access token in token.json
            if (array_key_exists('access_token', $token)) {
                file_put_contents('token.json', json_encode($token));
                if (sendTestEmail($recipient, $subject, $content)) {
                    $_SESSION['success'] = "Email sent successfully to $recipient!";
                } else {
                    $_SESSION['error'] = "Failed to send email.";
                }
            } else {
                $_SESSION['error'] = "Error retrieving access token: " . json_encode($token);
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error retrieving access token: " . $e->getMessage();
        }
    } else {
        if (sendTestEmail($recipient, $subject, $content)) {
            $_SESSION['success'] = "Email sent successfully to $recipient!";
        } else {
            $_SESSION['error'] = "Failed to send email.";
        }
    }

    // Redirect back to email_form.php
    header("Location: email_form.php");
    exit();
}
