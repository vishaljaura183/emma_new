<?php
class mailer {
	var $subject="";
	var $message="";
	var $recipentname="";
	var $recipentemail="";
	public function __construct($subject, $message, $recipentname, $recipentemail)
	{
		mailer::sendMail($subject, $message, $recipentname, $recipentemail);
	}
	public static function sendMail($subject, $message, $recipentname , $recipentemail, $filesPathArray="",  $sendername = "Election USA Team", $senderemail = "", $salutation = "Hi ", $complimentary_closing = "Thank you")
	{
			require_once 'Zend/Mail.php';
			require_once 'Zend/Mail/Transport/Smtp.php';
			
			$config = array('auth' => 'login',
			'server' => 'smtp.gmail.com',
			'username' => 'ilook2.seasia@gmail.com',
			'password' => 'mind@123',
			'ssl' => 'ssl',
			'port' => '465'
			);
			
			$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
			
			
			$formated_msg = "Test message";
			
			try 
			{
				$mail = new Zend_Mail();
				$mail->addHeader("MIME-Version", "1.0");
				$mail->addHeader("Content-type", "text/html; charset=iso-8859-1");
				$mail->setBodyHtml($formated_msg);
				
				if(isset($senderemail) && $senderemail !='')
				{
				$mail->setFrom($senderemail, $sendername);
				}
				else
				{
					$mail->setFrom("team@elections_usa.com", $sendername);
				}
				
				$mail->addTo($recipentemail,$recipentname);
				$mail->setSubject($subject);
				
				//attachments code
				if( $filesPathArray )
				{
					foreach ( $filesPathArray as $filePath )
					{
						$at = new Zend_Mime_Part(file_get_contents($filePath));
						$at->filename = basename($filePath);
						$at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
						$at->encoding = Zend_Mime::ENCODING_8BIT;
						$mail->addAttachment($at);
					}
				}
				//--attachments code
				$mail->send($transport);
				return true;
	// 			die;
				
			}
			catch (Zend_Mail_Transport_Exception $e) 
			{
	   			throw $e; die;
				//return false;
				
			}
			catch (Zend_Mail_Protocol_Exception $e)
			{
	  			throw $e; die;
				//return false;
				
			}
			catch (Zend_Exception $e)
			{
	   			throw $e; die;
				//return false;
				
			}
	}
}