<?php
// Simple script to receive mail (from a form or API), save it, and reply

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data (or JSON input)
    $sender_email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? 'No Subject';
    $message = $_POST['message'] ?? '';

    if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        // 1. Store the email (you can modify this to use a database)
        $log = "From: $sender_email\nSubject: $subject\nMessage:\n$message\n\n";
        file_put_contents("emails.txt", $log, FILE_APPEND);

        // 2. Send a reply email
        $reply_subject = "Re: $subject";
        $reply_message = "Hi,\n\nThank you for your message. We have received your email and will get back to you shortly.\n\nBest regards,\nDreamSpot";
        $headers = "From: dreamspotitservices@gmail.com\r\n" .
                   "Reply-To: no-reply@yourdomain.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        if (mail($sender_email, $reply_subject, $reply_message, $headers)) {
            echo "Email received and reply sent.";
        } else {
            echo "Email received but failed to send reply.";
        }
    } else {
        echo "Invalid email address.";
    }
} else {
    echo "Invalid request method.";
}
?>
