<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.0.5/src/Exception.php';
require 'PHPMailer-6.0.5/src/PHPMailer.php';
require 'PHPMailer-6.0.5/src/SMTP.php';


class EMAIL{
	private $mailer;
	private $siteRoot = "https://zenithcard.io";
	
	private $to;
	private $name;
	
	
	function __construct($name,$to){
		$this->to = $to;
		$this->name = $name;
		
		//Set up the SMTP
		$this->mailer = new PHPMailer;
        $this->mailer->isSMTP();
        $this->mailer->SMTPSecure = "ssl"; 
        $this->mailer->Host = 'server123.web-hosting.com';
        $this->mailer->Port = 465;
        $this->mailer->CharSet = 'utf-8';
        $this->mailer->SMTPAuth = true;
	}
	
	private function setHead($head){
		$root = $this->siteRoot;
		$heading = "<html><head></head><body style=\"border: 1px solid #003300; line-heght:1.5\">
										<div style=\"text-align:center;background-color: #003300; padding: 10px 5px;\">
											<h2 style=\"color: #fff\">$head</h2>
										</div>
										<div style=\"text-align: center\">
											<a href=\"$root\">
												<img src=\"$root/images/logo2x.png\" width=\"200px\" height=\"auto\" style=\"margin:20px 0px\" alt=\"ZenithCard Logo\" title=\"visit zenithcard.io\">
											</a>
										</div>";
		return $heading;
	}
	
	private function setFoot(){
		$footer = "<div style=\"text-align:center;background-color: #003300; color: #fff; padding: 10px 5px; margin-top: 20px\">
						<p>Copyright &copy; 2018, ZenithCard.io.</p>
					</div>
					</body></html>";
		return $footer;
	}

	private function relativeURL(){
		$rel = "";
		$i = 2;
		while($i < substr_count($_SERVER['PHP_SELF'],'/')){
			$rel .= '../';
			$i++;
		}
		return $rel;
	}


	private function logMail($action){
		$filePath = $this->relativeURL().'resources/mato/lib/php/mail/logs/'.date('d - m - Y',time()).'.txt'; //record logs in a single file for each day.
		$content = "[".date('H : i : s',time())."] ".$action."\n";
		try{
			$file = fopen($filePath,'a');
			fwrite($file,$content);
			fclose($file);
		}
		catch(Exception $e){
			//do nothing, just catch the exception when thrown
		}
	}

	public function sendVerification($verificationCode){
		$mail = $this->mailer; //get the mailer object
		$root = $this->siteRoot;
		$to = $this->to;
		$name = $this->name;
		
		$verifyLink = $root."/account/verify";
		$dummy = SHA1(uniqid());//attach a dummy variable to cause distraction
		$autoVerifyLink = $verifyLink."/?mail=$to&ZAVC=$verificationCode&Ztkn=$dummy";
		
		$HTMLmsg = $this->setHead('Verify Your Email');
		$HTMLmsg .= "
					<div style=\"text-align: center; padding: 10px 5px; font-size: 18px;\">
						<p>
							<strong>$name</strong>,We are glad to have you register to be part of ZenithCard. To proceed, you need to verify that this email belongs to you
						</p>
						<p>Here is the PIN for your email verification:</p>
						<div style=\"font-weight:bold; font-size:30px; border:2px dotted #003300; margin:20px 10%; padding:10px; background-color: #32cd32; color:#003300; letter-spacing:5px\">
							$verificationCode
						</div>
						<p>Keep this PIN secure, it is unique to your ZenithCard account and you might need it some other time. We take your privacy and security seriously</p>
						<div>
							<p>Visit the <a href=\"$verifyLink\">Account Verification Page</a> and provide this code to verify your email.</p><br/><br/>
							<a href=\"$autoVerifyLink\" style=\"padding: 10px 20px; background-color: #32cd32; color: #003300; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 25px; box-shadow: 0px 10px 10px rgba(0,0,0,0.1) inset;\">CLICK TO VERIFY EMAIL</a>
						</div>
					</div>
					";
		$HTMLmsg .= $this->setFoot();
		
        $mail->Username = 'accounts@zenithcard.io';
        $mail->Password = '<html>Zenith</html>';
        $mail->setFrom('accounts@zenithcard.io', 'ZenithCard Account');
        $mail->addAddress($to);
        $mail->Subject = "Verify Your Email";
		$mail->msgHTML($HTMLmsg);
		$mail->AltBody = nl2br(strip_tags($HTMLmsg))."Follow this link to verify your email: $autoVerifyLink";
		
		 if ($mail->send()){
			 $log = "Success: Verification email was sent to $name<$to>
";
			 $this->logMail($log);
            return true;
        } else {
			$log = "Failed: Verification email failed to send to $name<$to> *PHPMAILER ERROR>> ".$mail->ErrorInfo."
";
			$this->logMail($log);
            return $mail->ErrorInfo;
        }
	}

	public function sendPIN($pin){
		$mail = $this->mailer; //get the mailer object
		$root = $this->siteRoot;
		$to = $this->to;
		$name = $this->name;
		
		$HTMLmsg = $this->setHead('Your Zenith PIN');
		$HTMLmsg .= "
					<div style=\"text-align: center; padding: 10px 5px; font-size: 18px;\">
						<p>
							<strong>$name</strong>, Your Zenith PIN is:
						</p>
						<div style=\"font-weight:bold; font-size:30px; border:2px dotted #003300; margin:20px 10%; padding:10px; background-color: #32cd32; color:#003300; letter-spacing:5px\">
							$pin
						</div>
						<div>
							<h3>Make sure you keep this PIN secured!</h3>
							<a href=\"$root\" style=\"padding: 10px 20px; background-color: #32cd32; color: #003300; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 25px; box-shadow: 0px 10px 10px rgba(0,0,0,0.1) inset;\">GO TO ZENITHCARD</a>
						</div>
					</div>
					";
		
		$HTMLmsg .= $this->setFoot();
		
        $mail->Username = 'accounts@zenithcard.io';
        $mail->Password = '<html>Zenith</html>';
        $mail->setFrom('accounts@zenithcard.io', 'ZenithCard Account');
        $mail->addAddress($to);
        $mail->Subject = "Your Zenith PIN";
		$mail->msgHTML($HTMLmsg);
		$mail->AltBody = nl2br(strip_tags($HTMLmsg));
		
		 if ($mail->send()){
			 $log = "Success: Zenith PIN was sent to $name<$to>
";
			$this->logMail($log);
            return true;
        } else {
			$log = "Failed: Zenith PIN failed to send to $name<$to> *PHPMAILER ERROR>> ".$mail->ErrorInfo."
";
			$this->logMail($log);
            return $mail->ErrorInfo;
        }
	}
	
public function sendResetPassword($password){
		$mail = $this->mailer; //get the mailer object
		$root = $this->siteRoot;
		$to = $this->to;
		$name = $this->name;
		
		$HTMLmsg = $this->setHead('Password Reset');
		$HTMLmsg .= "
					<div style=\"text-align: center; padding: 10px 5px; font-size: 18px;\">
						<p>
							<strong>$name</strong>, We are sorry about the lose of your password, don't worry, we've got! We have helped you reset your password. Your new password is:
						</p>
						<div style=\"font-weight:bold; font-size:30px; border:2px dotted #003300; margin:20px 10%; padding:10px; background-color: #32cd32; color:#003300; letter-spacing:5px\">
							$password
						</div>
						<div>
							<p>You can change the password later from your dashboard on <a href=\"$root/dashboard/?target=settings#settings\">your dashboard</a></p>
							<a href=\"$root/login\" style=\"padding: 10px 20px; background-color: #32cd32; color: #003300; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 25px; box-shadow: 0px 10px 10px rgba(0,0,0,0.1) inset;\">LOGIN NOW</a>
						</div>
					</div>
					";
		
		$HTMLmsg .= $this->setFoot();
		
        $mail->Username = 'accounts@zenithcard.io';
        $mail->Password = '<html>Zenith</html>';
        $mail->setFrom('accounts@zenithcard.io', 'ZenithCard Account');
        $mail->addAddress($to);
        $mail->Subject = "Password Reset";
		$mail->msgHTML($HTMLmsg);
		$mail->AltBody = nl2br(strip_tags($HTMLmsg))."\n\n Go to $root/dashboard/?target=settings#settings to change the password";
		
		 if ($mail->send()){
			 $log = "Success: Reset Password was sent to $name<$to>
";
			$this->logMail($log);
            return true;
        } else {
			$log = "Failed: Reset password failed to send $name<$to> *PHPMAILER ERROR>> ".$mail->ErrorInfo."
";
			$this->logMail($log);
            return $mail->ErrorInfo;
        }
	}
	

	public function sendMailFromAccount($subject,$body){
		$mail = $this->mailer; //get the mailer object
		$root = $this->siteRoot;
		$to = $this->to;
		$name = $this->name;
		
		$HTMLmsg = $this->setHead($subject).'<div style=\"padding: 5px\">'.$body.'</div>'.$this->setFoot();
		
        $mail->Username = 'accounts@zenithcard.io';
        $mail->Password = '<html>Zenith</html>';
        $mail->setFrom('accounts@zenithcard.io', 'ZenithCard Account');
        $mail->addAddress($to);
        $mail->Subject = $subject;
		$mail->msgHTML($HTMLmsg);
		$mail->AltBody = nl2br(strip_tags($HTMLmsg));
		
		 if ($mail->send()){
			 $log = "Success: E-mail sent to $name<$to> from ".$mail->Username.": \"".$mail->AltBody."\"
";
			$this->logMail($log);
            return true;
        } else {
			$log = "Failed: E-mail failed to send to $name<$to> from ".$mail->Username.": \"".$mail->AltBody."\" *PHPMAILER ERROR>> ".$mail->ErrorInfo."
";
			$this->logMail($log);
            return $mail->ErrorInfo;
        }
	}

	public function sendNotification($subject,$body){
		$mail = $this->mailer; //get the mailer object
		$root = $this->siteRoot;
		$to = $this->to;
		$name = $this->name;
		
		$HTMLmsg = $this->setHead("Nofication")."<div style=\"padding: 5px\">".$body."</div>".$this->setFoot();
		
        $mail->Username = 'notifications@zenithcard.io';
        $mail->Password = '<html>Zenith</html>';
        $mail->setFrom('notifications@zenithcard.io', 'ZenithCard Notification');
        $mail->addAddress($to);
        $mail->Subject = $subject;
		$mail->msgHTML($HTMLmsg);
		$mail->AltBody = nl2br(strip_tags($HTMLmsg));
		
		 if ($mail->send()){
			 $log = "Success: Notification sent to $name<$to> from ".$mail->Username.": \"".$mail->AltBody."\"
";
			$this->logMail($log);
            return true;
        } else {
			$log = "Failed: Notification failed to send to $name<$to> from ".$mail->Username.": \"".$mail->AltBody."\" *PHPMAILER ERROR>> ".$mail->ErrorInfo."
";
			$this->logMail($log);
            return $mail->ErrorInfo;
        }	
		}
		
}

 ?>
