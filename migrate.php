<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php'; // Ensure the path is correct

use PhpImap\Mailbox;
use PhpImap\Exceptions\ConnectionException;

function migrate_emails($sourceDetails, $destinationDetails) {
    try {
        $sourceMailbox = new Mailbox(
            "{" . $sourceDetails['server'] . ":993/imap/ssl}INBOX", 
            $sourceDetails['user'], 
            $sourceDetails['password']
        );

        $destinationImap = imap_open(
            "{" . $destinationDetails['server'] . ":993/imap/ssl}INBOX", 
            $destinationDetails['user'], 
            $destinationDetails['password']
        );

        if (!$destinationImap) {
            throw new Exception("Failed to connect to destination IMAP server: " . imap_last_error());
        }

        $mailsIds = $sourceMailbox->searchMailbox('ALL');
        if(!$mailsIds) {
            return 'No emails found in the source mailbox.';
        }

        foreach ($mailsIds as $mailId) {
            $mail = $sourceMailbox->getMail($mailId);

            $headers = $mail->headersRaw;
            $body = $mail->textPlain . "\r\n" . $mail->textHtml;
            $fullMessage = $headers . "\r\n\r\n" . $body;

            $result = imap_append(
                $destinationImap, 
                "{" . $destinationDetails['server'] . ":993/imap/ssl}INBOX", 
                $fullMessage, 
                "\\Seen", 
                $mail->date
            );

            if (!$result) {
                throw new Exception("Failed to append message: " . imap_last_error());
            }
        }

        imap_close($destinationImap);

        return "Emails migrated successfully.";
    } catch (ConnectionException $ex) {
        error_log("IMAP connection error: " . $ex->getMessage());
        return "IMAP connection error: " . $ex->getMessage();
    } catch (Exception $ex) {
        error_log("An error occurred: " . $ex->getMessage());
        return "An error occurred: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    ob_start();
    try {
        $sourceDetails = $_POST['source'];
        $destinationDetails = $_POST['destination'];
        if (empty($sourceDetails) || empty($destinationDetails)) {
            throw new Exception("Source or destination details are missing.");
        }
        $result = migrate_emails($sourceDetails, $destinationDetails);
        $response = ['message' => $result];
        $json_response = json_encode($response);
        if ($json_response === false) {
            throw new Exception("JSON encoding error: " . json_last_error_msg());
        }
        ob_end_clean();
        echo $json_response;
    } catch (Exception $ex) {
        error_log("An unexpected error occurred: " . $ex->getMessage());
        ob_end_clean();
        $response = ['message' => 'An unexpected error occurred: ' . $ex->getMessage()];
        echo json_encode($response);
    }
}
?>
