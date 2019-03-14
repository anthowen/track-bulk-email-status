<?php
// sendmail.php

require_once('classes/Email.class.php');
require_once('classes/Courier.class.php');

// construct the email
$Email = new Email();
$Email->sender = 'webmaster@mail3tiresandoil.com';
$Email->recipient = 'test.list.0@gmail.com';
$Email->subject = "Thank you for subscribing!";
$Email->message_text = "Hello!";
$Email->message_html = "<h1>Hello!</h1>

<p>Thank you for subscribing to our newsletter!  We are excited to bring you <strong>updates about</strong> the new <strong>services</strong> we are offering.</p>
<img src='http://michele.sk/send-email/vipcard_image.php?campaignID=67&subscriptionID=1' alt='VIP card' />
<p>We hope you enjoy our service!</p>

<p>Thank you,<br />
The team.</p>";

// send the email
$Courier = new Courier();
$sent = $Courier->send($Email);

?>
<h1>Send Email</h1>
<? if ($sent = Courier::SENT_OK) { ?>
    <p>Email sent to <?= $Email->recipient; ?></p>
<? } else { ?>
	<p>Email was not sent to <?= $Email->recipient; ?></p>
<? } ?>
