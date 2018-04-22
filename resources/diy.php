<style>
.f,.s{
	margin: 5px 10%;
}
.f{
	color: red;
}
.s{
	color: green;
}
</style>


<?php

/*For running queries manually*/
require('master.php');
$db = new database();
$success = 0;
$failed = 0;
$root =  "https://zenithcard.io";
//$q = "SELECT * FROM users WHERE verification = 0";
$q = "SELECT * FROM users WHERE email='adedayomatt@gmail.com'";
$runQ = $db->query_object($q);
$total = $runQ->rowCount();
echo "<h3>$total records fetched...</h3>";
$a = 0;

while($row = $runQ->fetch(PDO::FETCH_ASSOC)){

	/*Update Password*/
	//updatePassword($row['user_id']);
	
	/*Send notification to users*/
	Notify($row['first_name'],$row['email'],$row['referal_code'],$row['pin'],$row['password']);
	
	/*Send Verification code to all users*/
	//sendV($row['first_name'],$row['last_name'],$row['email'],$row['pin']);
	
	
	/*Allocate PIN for every user*/
	//updatePIN($row['user_id']);

	
}

function updatePassword($id){
	GLOBAL $db;
	GLOBAL $success;
	GLOBAL $failed;
	$newPassword = substr(SHA1(uniqid()),10,6);
	$newPasswordHash = SHA1($newPassword);
	$newToken = SHA1(MD5(uniqid()));
	if($db->query_object("UPDATE users set password = '$newPassword',password_hash='$newPasswordHash',token='$newToken' WHERE user_id = $id")->rowCount()==1){	
	$success++;
	echo "<pre class=\"s\">Password updated for $id</pre>";
	}
	else{
		$failed++;
		echo "<pre style=\"f\">Password failed to update for $id</pre>";
	}
	
}

/*******Functions to do stuffs*******************/
function Notify($name,$email,$refCode,$pin,$password){
	GLOBAL $root;
	GLOBAL $success;
	GLOBAL $failed;
	$subject = "New Updates From ZenithCard.io";
	$body = "
			<div style=\"padding: 10px; line-height: 35px;\">
				<p>Hello $name, greetings to you from ZenithCard Team, we wish to notify you that we have updated <a href=\"$root\">our website</a> to improve our security and protecting our users</p>
				<p>Here are some of the things you should note:</p>
				<ul>
					<li>Our home page is now <strong><a href=\"$root\">$root</a></strong></li>
					<li>Your Referal Link is  <strong>$root/register/?ref=$refCode</strong>, share this link and get people to participate in our ICO and you get 100 ZENT bonus, go to <strong><a href=\"$root/dashboard/?target=referal#referal-program\"> $root/dashboard/?target=referal#referal-program </a></strong> and share your referal link with just one click!</li>
					<li>Our contribution channels (BTC and ETH) are now available. Go to $root/dashboard/?target=contribute#contribute to see our wallet address or scan the QR Code</li>
					<li>Your Zenith PIN is <strong>$pin</strong>, you will need this PIN to verify that you are the owner of this email that was used to register the ZenithCard account</li>
					<li>We have reset your password to <strong>$password</strong>, use this password for your next login and feel free to change it to another secure password here <strong><a href=\"$root/dashboard/?target=settings#settings\"> $root/dashboard/?target=settings#settings </a></strong></li>
					<li>You can now view your ZenithCard account status at <strong><a href=\"$root/account\"> $root/account </a></strong></li>
					<li>If you ever forget your ZenithCard account password, go to <strong><a href=\"$root/account/resetpswd\"> $root/account/resetpswd </a></strong> to reset your password</li>
				</ul>
				<p>We implore to verify that you own this email by going to <a href=\"$root/account/verify\">$root/account/verify</a></p>
				<p>If you encounter any issue regarding <strong><i>ONLY</i></strong> your ZenithCard account, you can write to <a href=\"mailto: accounts@zenithcard.io\">accounts@zenithcard.io</a></p>
				<br/><br/><br/>
				<p>Warm Regards<br/>ZenithCard Team</p>
			</div>";
			
			$mail = new EMAIL($name,$email);
			$sendEmail = $mail->sendNotification($subject,$body);
	if($sendEmail){	
	$success++;
	echo "<pre class=\"s\">Notification sent to $name</pre>";
	}
	else{
		$failed++;
		echo "<pre style=\"f\">Notification failed to send to $name ***Technical Error: $sendEmail </pre>";
	}
	
}
//This sends Verification code i.e Zenith PIN
function sendV($fn,$ln,$m,$pin){
	GLOBAL $success;
	GLOBAL $failed;
	
	$fullName = $fn.' '.$ln;
	
	$m = new EMAIL($fn,$m);
	$sendEmail = $m->sendVerification($pin);
	if($sendEmail){
	echo "<pre class=\"s\">Verification code ($pin) sent to $fullName</pre>";
	$success++;
	}
	else{
		echo "<pre style=\"f\">Verification code ($pin) failed to send to $fullName ***Technical Error: $sendEmail </pre>";
	}
}

//Update user PIN
function updatePIN($id){
	GLOBAL $db;
	GLOBAL $success;
	GLOBAL $failed;
	
	$pin = getPIN();
	if($db->query_object("UPDATE users SET pin = $pin WHERE user_id = $id")){
		$success++;
		echo "<pre class=\"s\">PIN $pin assigned to user <strong>$id</strong></pre>";
	}
	else{
		$failed++;
		echo "<pre class=\"f\">PIN $pin failed to assign to user <strong>$id</strong></pre>";
	}
}

//Generate PIN, no interaction with the database
function getPIN(){
	GLOBAL $db;
	
		$pin = rand(100000,999999);
		 if($db->query_object("SELECT pin FROM users WHERE pin = $pin")->rowCount() > 0){
			 getPIN();
		 }
		 else{
		return $pin; 
		 }
	 }
echo "<hr/>";	
echo "<h2 class=\"s\">Success: $success</h2>";
echo "<h2 class=\"f\">Failed: $failed</h2>";

?>