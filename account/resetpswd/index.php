	<?php
require('../../resources/master.php');

$passwordSent = false;
function verifyEmail($email){
	$db = new database();
	$matchedAccount = array();
	$getUser = $db->query_object("SELECT user_id,first_name,email,pin FROM users WHERE email = '$email'");
	if($getUser->rowCount() == 1){
		$account =  $getUser->fetch(PDO::FETCH_ASSOC);
		$matchedAccount['id'] = $account['user_id'];
		$matchedAccount['name'] = $account['first_name'];
		$matchedAccount['email'] = $account['email'];
		$matchedAccount['pin'] = $account['pin'];
	}
	return $matchedAccount; //Return an array of properties of the account that  matched the email address
}

if(isset($_POST['reset_password'])){
	
	$email = trim(htmlentities($_POST['r_email']));
	$pin = trim(htmlentities($_POST['r_pin']));
	$matchedAccount = verifyEmail($email);

	if(!empty($matchedAccount)){
		$db = new database();
		$accountId = $matchedAccount['id'];
		$accountPIN = $matchedAccount['pin'];
		
		if($pin == $accountPIN){
		$newPassword = substr(SHA1(uniqid()),5,8);
		$newPasswordHash = SHA1($newPassword);
		$newToken = SHA1(MD5(time()));
		$updatePassword = $db->query_object("UPDATE users SET password = '$newPassword',password_hash='$newPasswordHash',token='$newToken' WHERE email='$email'"); 
		if($updatePassword->rowCount() == 1){
			$mail = new EMAIL($matchedAccount['name'],$matchedAccount['email']);
			$mail->sendResetPassword($newPassword);//Send the new password to the owner
			$passwordReset = true;
			$passwordSent = true;
			$report = "Your password has been reset successfully, check your mail for the new password";
		}
		else{
			$passwordReset = false;
			$report = "Sorry, something went wrong while resetting your password, try again later";
			}
		}
		else{
			$passwordReset = false;
			$report = "Incorrect Zenith PIN";
		}

	}
	else{
		$passwordReset = false;
		$report = "Sorry, we couldn't find any ZenithCard account associated with that email address";
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="ZenithCard">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Cryptocurrency Backed Debit Card">
		<link rel="shortcut icon" href="../../images/favicon.png">
		<title>ZenithCard &#8226; Reset Password</title>
		<link rel="stylesheet" href="../../assets/css/style.css?ver=1.1">
		<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/styles.css">
		<script  type="text/javascript" language="javascript" src="../../resources/mato/tools/fontawesome-free-5.0.9/svg-with-js/js/fontawesome-all.min.js"></script>
	</head>
	<body>
											<style>
										
											</style>
						<div style="text-align: center; color: #fff">
							<a href="../"><img src="../../images/logo-white2x.png" width="300px" height="auto" title="Go to zenithcard.io"></a>
							<h2>RESET PASSWORD</h2>
						</div>
						<div class="main">
							<div class="main-inner">
								<form action="<?php $_PHP_SELF ?>" method="POST" id="verification-form">
								<?php
										if(isset($passwordReset) && isset($report)){
												if($passwordReset == true){
												?>
												<div class="report-container successful"><i class="fas fa-check-circle"></i>  <?php echo $report ?></div>
												<?php
											}
											else{
												?>
												<div class="report-container failed"><i class="fas fa-times-circle"></i>  <?php echo $report ?></div>
												<?php
											}
										}
									if(!$passwordSent){
									?>
									<div class="form-group">
										<label>Enter the email address you registered your ZenithCard account with</label>
										<div class="input-group">
											<span class="input-group-addon" id="at"><i class="fas fa-at" style="color:#003300"></i></span>
											<input type="email" name="r_email" class="form-control" value="<?php echo (isset($_POST['r_email']) ? $_POST['r_email'] : '' )?>" placeholder="you@example.com" aria-describedby="at" required>
										</div>
									</div>
									
									<div class="form-group">
										<label>Your Zenith PIN</label>
										<div class="input-group">
											<span class="input-group-addon" id="key"><i class="fas fa-key" style="color:#003300"></i></span>
											<input type="text" name="r_pin" class="form-control" value="<?php echo (isset($_POST['r_pin']) ? $_POST['r_pin'] : '' )?>" placeholder="PIN" aria-describedby="key" maxlength="6" required>
										</div>
									</div>
									
									<div style="text-align: center">
										<input type="submit" name="reset_password" value="Reset Password" class="btn btn-default btn-lg">
									</div>
									<?php
									}
									?>
								</form>
							</div>
						</div><!-- .col  -->

	</body>
</html>