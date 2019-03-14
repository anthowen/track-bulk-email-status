<?php
// classes/Courier.class.php

/**
 * This class emails converts and emails data from the Email class
 * It takes an Email and uses the mail() function to send it out
 *
 */
class Courier {
    const SENT_OK = 0;
	const SENT_FAIL = 1;
	
	/**
	 * Make text rfj2047 compliant	
	 * We can convert HTML
 	 * character entities into ISO-8859-1, 
 	 * then converting the charset to 
 	 * Base64 for rfc2047 email subject compatibility.
	 */
	public function rfc2047_sanitize($input) {
		$output = mb_encode_mimeheader(
			html_entity_decode(
				$input,
				ENT_QUOTES,
				'ISO-8859-1'),
			'ISO-8859-1','B',"\n");
		return $output;
	}
	
    /**
	 * Set the Email object to draw the information from
	 *
	 * @parameter $Email the email to send
	 */
	public function send( $Email=null ) {
		// let's create the headers to show where the email 
		// originated from.
		$headers[] = 'From: '.$Email->sender;
		// $headers[] = 'Reply-To: '.$Email->sender;
		$headers[] = 'Reply-To: basily.judanov.85@gmail.com'; 
		
		
		// Subjects are tricky.  Even some 
		// sophisticated email clients don't
		// understand unicode subject lines. 
		$subject = $this->rfc2047_sanitize($Email->subject);
		
		$message = "";
		
		// if the email is HTML, then let's tell the MTA about the mime-type and all that
		if ($Email->message_html) {
			// set up a mime boundary so that we can encode
			// the email inside it, hiding it from clients
			// that can only read plain text emails
			$mime_boundary = '<<<--==+X['.md5(time()).']';
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-Type: multipart/mixed;';
			$headers[] = ' boundary="'.$mime_boundary.'"';
			$message = $Email->message_html;
			
			$message .= "\n";
			$message .= "--".$mime_boundary."\n";
		}
			
		// since this is a mime/multipart message, we need to re-iterate
		// the message contents in order for mime-aware clients to read it
		if ($Email->message_html) {
			$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
			$message .= "Content-Transfer-Encoding: 7bit\n";
			$message .= "\n";
			$message .= $Email->message_html;
		} else {	
			$message .= 'Content-type: text/plain; charset=iso-8859-1';
			$message .= "Content-Transfer-Encoding:  7bit\n";
			$message .= "\n";
			$message .= $Email->message_text;
		}
		$message .= "\n";
		$message .= "--".$mime_boundary."\n";
    	$message .= $Email->message_text;
		
		
		
		// try to send the email. 
		$result = mail( $Email->recipient, 
			$subject, 
			$message, 
			implode("\n",$headers) 
		);
				
		// if it fails, let's throw up an error
		if ( !$result ) {
			return self::SEND_FAIL;
		} // fi result
		
		return self::SEND_OK;

	} // send
	
	
}

?>