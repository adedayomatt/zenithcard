	<?php
require('../resources/master.php');

if($status == 0){
	$tool->redirect_to("../login/?_rdr=$current_url");//Visitors are not allowed here
}

if(isset($_POST['send_my_PIN'])){
	$maill = new EMAIL($user->firstName,$user->email);
	$sendMail = $maill->sendPIN($user->pin);
	if($sendMail == true){
		$PINsent = true;
	}
	else{
		$PINsent = false;
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
		<link rel="shortcut icon" href="../images/favicon.png">
		<title>ZenithCard &#8226; Account</title>
		<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/css/style.css?ver=1.1">
		<link rel="stylesheet" href="assets/styles.css">
		<script  type="text/javascript" language="javascript" src="../resources/mato/tools/fontawesome-free-5.0.9/svg-with-js/js/fontawesome-all.min.js"></script>
	</head>
	<body>
		<style>
			a.ref-share-link{
				margin: 10px;
				text-decoration: none;
			}
			a.ref-share-link>svg{
				font-size: 50px !important;
			}
			a.ref-share-link.whatsapp{
				color: rgb(37, 211, 102);
			}
			a.ref-share-link.facebook{
				color: rgb(59, 89, 152);
			}
			a.ref-share-link.twitter{
				color: rgb(85, 172, 238);
			}
			a.ref-share-link.linkedin{
				color: rgb(0, 123, 181);
			}
			a.ref-share-link.google-plus{
				color: rgb(219, 68, 55);
			}
			a.ref-share-link:hover{
				text-decoration: none;
				color: #000;
			}
												
		</style>	
												
						<div style="text-align: center; color: #fff">
							<a href="../"><img src="../images/logo-white2x.png" width="300px" height="auto" title="Go to zenithcard.io"></a>
							<h2>ACCOUNT</h2>
						</div>

						<div class="main">
							<div class="main-inner">
										<div style="text-align: center;">
											<img src="../images/avatar/<?php echo $user->avatar ?>" width="100px" height="100px" alt="<?php echo $user->fullName.' avatar' ?>" style="border-radius: 50%">
										</div>

										<?php
										if(isset($PINsent)){
											if($PINsent == true){
												?>
												<div class="report-container successful"><i class="fas fa-check-circle"></i>  Your PIN has been sent to your email</div>
												<?php
											}
											else{
												?>
												<div class="report-container successful"><i class="fas fa-times-circle"></i>  We couldn't send your PIN to your mail now.</div>
												<?php
											}
										}
										?>

										<ul style="padding:0px;margin:0px">
											<li class="account-status">
												<span class="x">Name: </span> <?php echo $user->fullName?>
											</li>
											<?php
											if($user->verification == 1){
												?>
												<li class="account-status">
													<span class="x">Email: </span> </span> <?php echo $user->email ?> <span style="margin-left: 10px;color: green"><i class="fas fa-check-circle"></i> Verified</span>
												</li>
												<?php
											}
											else{
												?>
												<li class="account-status">
													<span class="x">Email: </span> <?php echo $user->email ?> <span style="margin-left: 10px;color: red"><i class="fas fa-times-circle"></i> Not Verified</span>
													<p class="help-block">check the email we sent to you via <strong><?php echo $user->email?></strong> for verification procedure </p>
												</li>
											<?php
											}
											?>
											<li class="account-status">
												<span class="x">KYC Completed: </span><?php echo $user->KYCcompleted ?> 
												<?php
												if($user->KYCcompleted == 'None'){
													?>
													<div style="text-align:center">
														<a href="../dashboard/?target=KYC-individual#KYC-individual" class="btn"> Complete KYC Individual</a>
														<a href="../dashboard/?target=KYC-legal#KYC-legal" class="btn"> Complete KYC Legal Entity</a>
													</div>
													<?php
												}
												?>
												<p class="help-block">KYC once completed is not editable</p>
											</li>
											<li class="account-status">
												<span class="x">Token Balance: </span><?php echo $user->zentToken ?> ZENT</li>
											<li class="account-status">
												<span class="x">Referal Link: </span> <?php echo $user->referalLink ?></span>
												<p class="help-block">Share the your referal link and get 100 ZENT token bonus everytime a your referal link is used to register</p>
												<p class="help-block">Share link on: </p>
												<div style="text-align:center">
													<a href="<?php echo $user->whatsappShareLink ?>" class="ref-share-link whatsapp" title="share on whatsapp"> <i class="fab fa-whatsapp-square"></i>&nbspWhatsApp</a>
													<a href="<?php echo $user->facebookShareLink ?>" class="ref-share-link facebook" title="share on facebook"> <i class="fab fa-facebook-square"></i>&nbspFacebook</a>
													<a href="<?php echo $user->twitterShareLink ?>" class="ref-share-link twitter" title="share on twitter"> <i class="fab fa-twitter-square"></i>&nbspTwitter</a>
													<a href="<?php echo $user->linkedinShareLink ?>" class="ref-share-link linkedin" title="share on linkedin"> <i class="fab fa-linkedin"></i>&nbspLinkedIn</a>
													<a href="<?php echo $user->googlePlusShareLink ?>" class="ref-share-link google-plus" title="share on google plus"> <i class="fab fa-google-plus-square"></i>&nbspGoogle Plus</a>
												</div>
											</li>
											<li class="account-status">
												<span class="x">My Refers: </span><?php echo $user->referred ?> 
												<p class="help-block">Number of people that have used your referal link to register</p>
											</li>
											<li class="account-status">
												<span class="x">PIN: </span>
												<form action="<?php $_PHP_SELF ?>" method="POST" style="display: inline">
													<input type="submit" name="send_my_PIN" value="SEND MY PIN" class="btn btn-default">
													<p class="help-block">Your ZenithCard account PIN will be sent to <?php echo $user->email ?> 
												</form>
											</li>
										</ul>
							</div>
						</div><!-- .col  -->

												
	<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/5aaa8d354b401e45400dc354/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
<!--End of Tawk.to Script-->


	</body>
</html>