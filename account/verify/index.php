	<?php
require('../../resources/master.php');

$verified = false;
$verificationReport = "";
function verifyAccount($Vmail,$Vpin){
	GLOBAL $verificationReport;
	GLOBAL $verified;
	$db = new database();

	$email = trim(htmlentities($Vmail));
	$pin = trim(htmlentities($Vpin));
	
	$checkEmail = $db->query_object("SELECT email,refree,pin,verification FROM users WHERE email = '$email'");
	if($checkEmail->rowCount() == 1){
		$v = $checkEmail->fetch(PDO::FETCH_ASSOC);
		if($v['verification'] == 0){ //if email has not been verified before
			if($v['pin'] == $pin){
				if($db->query_object("UPDATE users SET verification = 1 WHERE email = '$email'")->rowCount() == 1){// update profile to verified
					$verificationReport = "<i class=\"fas fa-check-circle\"></i> Account verification successful!";
					$verified = true;
					if($v['refree'] != ''){//if the user was referred
						if(giftRefree(v['refree'])){
							$refreeGifted = true;
						}
					}
				}
				else{
					$verificationReport = "<i class=\"fas fa-times-circle\"></i> Couldn't verify your account";
					$verified = false;
				}
			}
			else{
			$verificationReport = "<i class=\"fas fa-times-circle\"></i> Incorrect PIN";
			$verified = false;
			}
		}
		else{
			$verificationReport = "<i class=\"fas fa-check-circle\"></i> Your email is already verified";
			$verified = true;
		}

	}
	else{
		$verificationReport = "<i class=\"fas fa-times-circle\"></i> We are sorry, but $email was never registered on ZenithCard";//email was not found
		$verified = false;
	}
}

function giftRefree($refreeCode){
	$referalBonus = ZENT::$referalBonus;
	$bonus = false;
	
	$getRefree = $this->db->query_object("SELECT user_id FROM users WHERE (referal_code = '$refreeCode' )");
	if($getRefree->rowCount() == 1){//Confirm refree existence
		$r = $getRefree->fetch(PDO::FETCH_ASSOC);
		$refreeId = $r['user_id'];
		$zentCredit = new ZENT();
		if($zentCredit->creditZent(ZENT::$referalBonus,$refreeId,1)){// credit the referee
			$bonus = true;
			}
		}
	return $bonus;
}


if(isset($_GET['mail']) && isset($_GET['ZAVC']) && isset($_GET['Ztkn'])){ //For auto verification from mail box
	verifyAccount($_GET['mail'],$_GET['ZAVC']);
}
if(isset($_POST['verify'])){
	verifyAccount($_POST['v_email'],$_POST['PIN']);
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
		<title>ZenithCard &#8226; Email Verification</title>
		<link rel="stylesheet" href="../../assets/css/style.css?ver=1.1">
		<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/styles.css">
		<script  type="text/javascript" language="javascript" src="../../resources/mato/tools/fontawesome-free-5.0.9/svg-with-js/js/fontawesome-all.min.js"></script>
	</head>
	<body>
						<div style="text-align: center; color: #fff">
							<a href="../"><img src="../../images/logo-white2x.png" width="300px" height="auto" title="Go to zenithcard.io"></a>
							<h2>EMAIL VERIFICATION</h2>
						</div>
						<div class="main">
							<div class="main-inner">
								<form action="<?php $_PHP_SELF ?>" method="POST" id="verification-form">
									<?php
									if($verificationReport != ""){
										?>
										<div class="text-center report-container <?php echo ($verified == true ? 'successful' : 'failed')?>">
											<p><?php echo $verificationReport ?></p>
										</div>
											<?php
											if($verified && $status == 0){
												?>
												<div class="text-center">
													<a href="../../login" class="btn btn-lg">Login Now</a>
												</div>
												<?php
											}
									}
									if(!$verified){
									?>
									<div class="form-group">
										<label>Enter the email address you want to verify</label>
										<div class="input-group">
											<span class="input-group-addon" id="at"><i class="fas fa-at" style="color:#003300"></i></span>
											<input type="email" name="v_email" class="form-control" value="<?php echo (isset($_POST['v_email']) ? $_POST['v_email'] : '' )?>" placeholder="you@example.com" aria-describedby="at" required>
										</div>
									</div>
									
									<div class="form-group">
										<label>Enter the PIN sent to the email address</label>
										<div class="input-group">
											<span class="input-group-addon" id="key"><i class="fas fa-key" style="color:#003300"></i></span>
											<input type="text" name="PIN" class="form-control" value="<?php echo (isset($_POST['PIN']) ? $_POST['PIN'] : '' )?>" placeholder="PIN" aria-describedby="key" maxlength="6" required>
										</div>
									</div>
									
									<div style="text-align: center">
										<input type="submit" name="verify" value="Verify" class="btn btn-default btn-lg">
									</div>
									<?php
									}
									?>
								</form>
							</div>
						</div><!-- .col  -->

	</body>
</html>