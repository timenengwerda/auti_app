<?php
class Mail{
	function __construct($to, $body, $subject){
			require_once('lib/swift/swift_required.php');
			$transport = Swift_SmtpTransport::newInstance('localhost', 25);
			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance( $subject )
				->setSubject($subject)
				->setFrom(array('noreply@dagplanner.nl' => 'Dagplanner'))
				->setTo( $to )
				->setBody($body, 'text/html');
			if($mailer->Send($message, $failures))
			{
				return true;
			}else{
				return false;
			}
	}
}
?>