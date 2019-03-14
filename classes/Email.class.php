<?php

// classes/Email.class.php
/**
 * Email class conceptualizes an email. 
 * It contains the information that the Courier
 * needs to send an email message to a recipient
 */
class Email {
    var $recipient,
        $sender,
        $subject,
        $message_text,
        $message_html;
}

?>
