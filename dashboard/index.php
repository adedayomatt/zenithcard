<?php
require('../resources/master.php');
if($status == 0){
	$tool->redirect_to("../login/?_rdr=$current_url");
}

//This part is for uploading new avatar
	if(isset($_POST['upload_avatar']) && isset($_FILES['avatar'])){
		$avatar = new Avatar($user->id,$user->firstName);
		
		$size = ($_FILES['avatar']['size'])/1000000;
		if($avatar->avatarIsImage($_FILES['avatar']['type'])){
			$format = '.'.substr($_FILES['avatar']['type'],1+strpos($_FILES['avatar']['type'],'/'));
			$newAvatar = $avatar->avatarId.$format;
			if (!move_uploaded_file ($_FILES['avatar']['tmp_name'],'../images/avatar/'.$newAvatar)) {
			$photoUploadReport = 'upload unsuccesful try again: '.$_FILES['avatar']['error'];

			}
		else{
			$avatar->updateAvatar($format);
			$user->avatar = $newAvatar;
			//discard the tmp file
			if(is_file($_FILES['avatar']['tmp_name']) && file_exists($_FILES['avatar']['tmp_name'])){
				unlink($_FILES['avatar']['tmp_name']);
						}
					$photoUploadReport = "Display picture changed successfully";
					$user->avatar = $newAvatar;
			}	
		}
		else{
			$photoUploadReport = "Unsupported file format";
		}
		
	}

 function cleanInput($input){
	return trim(htmlentities($input));
	}	
//If KYC individual is submitted
	if(isset($_POST['submit_KYC_individual'])){ //complete KYC legal individual
		$kycData = array_map('cleanInput',$_POST);	
		$kyci = new KYCI($kycData);
		if($kyci->KYCexists()){
			$kycIndividualReport = $kyci->updateKYCIndividual();
		}
		else{
			$kycIndividualReport = $kyci->addKYCIndividual();
		}
	}
	
	else if(isset($_POST['submit_KYC_legal'])){ //complete KYC legal entity
		$kycData = array_map('cleanInput',$_POST);	
		$kycl = new KYCL($kycData);
		if($kycl->KYCexists()){
			$kycLegalReport = $kycl->updateKYCLegal();
		}
		else{
			$kycLegalReport = $kycl->addKYCLegal();
		}
	}
	else if(isset($_POST['changePassword'])){
		$passwordChangeReport = $user->changePassword($_POST['old_password'],$_POST['new_password01'],$_POST['new_password02']);
		if($passwordChangeReport == 111){//changing of password was successfull
			$user->logout();
			setcookie('psw',1,0,'/'); //set cookie to notify the login page that is been redirected to that the redirection was because of passeord change
			$tool->redirect_to('../login');
		}
	}
//fetching KYC by default
$_KYC = new KYC($user->id);
if($_KYC->isKYCI()){
	$myKYC = new myKYCI($user->id);
	$myKYC->getKYCI();
	$activeKYC = 'individual';
}
else if($_KYC->isKYCL()){
	$myKYC = new myKYCL($user->id);
	$myKYC->getKYCL();
	$activeKYC = 'legal-entity';
}
else{
	$activeKYC = 'none';
	$myKYC = new emptyKYC();
}
?>

<html lang="zxx" class="js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="ZenithCard">
	<meta name="theme-color" content="#003300">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Cryptocurrency Backed Debit Card">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="../images/favicon.png">
	<!-- Site Title  -->
	<title>ZenithCard &#8226; DashBoard(<?php echo $user->fullName ?>)</title>
	<!-- Vendor Bundle CSS -->
	<link rel="stylesheet" href="../assets/css/vendor.bundle.css">
	
	<!--Boostrap added by Matthew
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">-->
	
	<!-- Custom styles for this templae -->
	<link rel="stylesheet" href="../assets/css/style.css?ver=1.1">
	<link rel="stylesheet" href="../assets/css/theme-mint.css?ver=1.1">
	
	
	<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ddeabd6520c7f855e7ea0c0b4/96742410b1c65912559289283.js");</script>

	<script  type="text/javascript" language="javascript" src="../resources/mato/lib/JMatt/global.js"></script>
	
</head>
<body class="theme-dark io-azure" data-spy="scroll" data-target="#mainnav" data-offset="80">
<!--This part is to control which section should be visible-->	
		<style>
	.RHS-section{  
		display: none;
	}
	<?php
	if(isset($_POST['submit_KYC_individual'])){ // If the script is returning from KYC individual form submission, show the KYC individual by default
		?>
			.RHS-section#KYC-individual{
				display: block;
			}	
		<?php
		$KYCI = true;
	}
	else if(isset($_POST['submit_KYC_legal'])){ // If the script is returning from KYC individual form submission, show the KYC legal by default
			?>
			.RHS-section#KYC-legal{
				display: block;
			}	
			<?php
			$KYCL = true;
	}
	else if(isset($_POST['changePassword'])){ // If the script is returning from password setting, show the settings by default
			?>
			.RHS-section#settings{
				display: block;
			}	
			<?php
			$STT = true;
	}
	else if(isset($_GET['target'])){// If it is not returning from form submission
		$_t = $_GET['target'];
		switch($_GET['target']){
			case 'token':
			?>
			.RHS-section#token{
				display: block;
				}
			<?php
			$TKN = true;
			break;
			case 'KYC-individual':
					?>
			.RHS-section#KYC-individual{
				display: block;
			}	
			<?php
			$KYCI = true;
			break;
			case 'KYC-legal':
			?>
			.RHS-section#KYC-legal{
				display: block;
			}	
			<?php
			$KYCL = true;
			break;
			case 'settings':
			?>
			.RHS-section#settings{
				display: block;
			}
			<?php
			$STT = true;
			break;
			case 'referal':
			?>
			.RHS-section#referal-program{
				display: block;
			}	
			<?php
			$REF = true;
			break;
			case 'contribute':
			?>
			.RHS-section#contribute{
				display: block;
			}	
			<?php
			$CTB = true;
			break;
			
			default:
		?>
		.RHS-section#token{
			display: block;
		}	
		<?php
		$TKN = true;
			break;
			}
	}
	else{
		?>
	.RHS-section#token{
		display: block;
	}
		<?php
		$TKN = true;
	}
	?>
	</style>


	<style>
	.container-fluid{
		margin-top:80px;
		color: #000 !important;
		background-color: #fff;
	}
	.countdown-box-alt{
		background-color:#003300;
		color:#fff;
		padding:5px;
		border-radius:5px;
		margin: 5px 0px;
	}
	#LHS{
		position: fixed;
	}
	#LHS-inner{
		background-color: #fff;
		border-radius: 5px;
		height: 80vh;
		overflow: hidden;
		box-shadow: 0px 10px 10px rgba(0,200,0,0.1);
	}
	#LHS-inner:hover{
		overflow-y: auto;
	}

	#RHS{
		left:33.333333%;
	}
	.RHS-section{
		padding-top: 100px;
		min-height:100vh;
	}
	#avatar-n-name,.side-menu{
		padding:10px;
	}
	a.side-menu{
		display: block;
		padding: 7px 10px;
	}
	
	a.side-menu[data-menu-active="false"]{
		color : #003300;
		padding-right: 0px;
		box-shadow: 0px 10px 10px rgba(0,200,0,0.2) inset;
	}
	a.side-menu[data-menu-active="true"]{
		background-color: #003300;
		color: #fff;
		box-shadow: 0px 10px 10px rgba(255,255,255,0.2) inset;
	}
	
	a.side-menu>.caret-left{
		font-size: 20px;
		float:right;
	}
	#user-avatar{
		width: 100px;
		height: 100px;
		border-radius: 50%;
		vertical-align: text-bottom;
	}

	hr{
		color: green;
		margin: 0px;
	}
	#upload-avatar-btn{
		margin-left: 20px;
		cursor: pointer;
		font-size: 30px !important;
		opacity: 0.5;
	}
	#upload-avatar-btn:hover{
		opacity: 1;
	}
	[data-toggle-role="main-toggle"]{
		display: none;
		box-shadow: 0px 10px 10px rgba(0,0,0,0.5);
		padding: 10px;
	}
	.mini-text{
		color: grey;
	}
	
	@media all and (max-width: 768px){
		#LHS{
			position: relative;
			margin-bottom: 20px;
		}
		#LHS-inner{
			height: auto;
		}
		#LHS-inner:hover{
			overflow-y:hidden;
		}
		#RHS{
			left: 0px;
			padding-right:0px !important;
			padding-left:0px !important;
			
		}
			.RHS-section{
		padding-top: 20px;
	}
	}
	</style>
	
	

	<!-- Header --> 
	<header class="site-header is-sticky">
				
		<?php
	$ref = 'dashboard page';
	require('../resources/global/header.php');
	?>
	</header>
	<!-- End Header -->
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="LHS">
				<div id="LHS-inner">
				
					<div class="countdown-box-alt text-center animated" data-animate="fadeInUp" data-delay=".3">
						<h6><i class="fas fa-stopwatch"></i>   ICO will start in</h6>
						<div class="token-countdown d-flex align-content-stretch" data-date="2018/04/23"></div>
					</div>

				
					<div data-action="toggle" class="text-center" id="avatar-n-name">
					<?php
					if(isset($photoUploadReport)){
						?>
						<div class="black" style="padding: 10px; background-color: rgba(0,100,0,0.3)"><?php echo $photoUploadReport ?></div>
						<?php
					}
					else if(isset($kycIndividualReport)){//Displaying the KYC Individual submission report
								switch($kycIndividualReport){
									case 000:
								?>
										<div class="black text-center" class="black" style="padding: 10px; margin: 10px 0px; background-color: rgba(0,100,0,0.3)">
											<p class="">KYC Individual updated successfully</p>
										</div>
										<?php
										break;
										case 111:
										?>
										<div class="black text-center" style="padding: 10px; margin: 10px 0px; background-color: rgba(100,0,0,0.3)">
											<p class="">KYC Individual update failed, you did not confirm your information. Confirm that you have provided correct information at the bottom of the KYC form and try again</p>
										</div>
										<?php
										break;
										case 999:
										?>
										<div class="black text-center" style="padding: 10px; margin: 10px 0px; background-color: rgba(100,0,0,0.3)">
											<p class="">KYC Individual update failed</p>
										</div>
										<?php
										break;
										}
									}
								else if(isset($kycLegalReport)){//Displaying the KYC Individual submission report
								switch($kycLegalReport){
									case 000:
								?>
										<div class="black text-center" class="black" style="padding: 10px; margin: 10px 0px; background-color: rgba(0,100,0,0.3)">
											<p class="">KYC Legal Entity updated successfully</p>
										</div>
										<?php
										break;
										case 111:
										?>
										<div class="black text-center" style="padding: 10px; margin: 10px 0px; background-color: rgba(100,0,0,0.3)">
											<p class="">KYC Legal Entity update failed, you did not confirm your information. Confirm that you have provided correct information at the bottom of the KYC form and try again</p>
										</div>
										<?php
										break;
										case 999:
										?>
										<div class="black text-center" style="padding: 10px; margin: 10px 0px; background-color: rgba(100,0,0,0.3)">
											<p class="">KYC Legal Entity update failed</p>
										</div>
										<?php
										break;
										}
									}
								?>
												
						<img src="../images/avatar/<?php  echo $user->avatar ?>" id="user-avatar"> 
						<span data-toggle-role="toggle-trigger" id="upload-avatar-btn" title="change profile picture" ><i class="fas fa-pen-square"></i></span>
						<div data-toggle-role="main-toggle">
						<p class="mini-text">Change Avatar</p>
							<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
								<div class="form-group">
									<input type="file" name="avatar" size="" class="form-control" style="display: inline; width: 70%"/>
									<input type="submit" name="upload_avatar" value="upload" class="custom-btn" style="display: inline" >
								</div>
							</form>
						</div>
						<h5 class="black"><?php echo $user->fullName ?></h5>
						<p style="font-size: 12px;" class="mini-text">(Joined <?php echo $tool->since($user->timestamp)?>)</p>
					</div>
					
					<hr>
					<a href="?target=token#token" class="side-menu get-content-with-js" id="menu-token-details" data-menu-active="<?php echo (isset($TKN) && $TKN == true ? 'true' : 'false') ?>">
						<i class="fas fa-info-circle"></i>  Token Details <span class="caret-left"><i class="fas fa-caret-left white"></i></span>
					</a>
					
					<a href="?target=KYC-individual#KYC-individual" class="side-menu get-content-with-js" id="menu-kyc-individual" data-menu-active="<?php echo (isset($KYCI) && $KYCI == true ? 'true' : 'false') ?>">
						<i class="fas fa-users"></i>  Complete KYC (Individual) <span class="caret-left"><i class="fas fa-caret-left white"></i></span>
					</a>
										
					<a href="?target=KYC-legal#KYC-legal" class="side-menu get-content-with-js" id="menu-kyc-legal" data-menu-active="<?php echo (isset($KYCL) && $KYCL == true ? 'true' : 'false') ?>">
						<i class="fas fa-briefcase"></i>  Complete KYC (Legal Entity)<span class="caret-left"><i class="fas fa-caret-left white"></i></span>
					</a>
							
					<a  href="?target=contribute#contribute" class="side-menu get-content-with-js" id="menu-contribute" data-menu-active="<?php echo (isset($CTB) && $CTB == true ? 'true' : 'false') ?>">
					<i class="fas fa-hand-holding-usd"></i>  Contribute <span class="caret-left"><i class="fas fa-caret-left white"></i></span>
					</a>
					
					<a href="?target=referal#referal-program" class="side-menu get-content-with-js" id="menu-referal-program" data-menu-active="<?php echo (isset($REF) && $REF == true ? 'true' : 'false') ?>" >
						<i class="fas fa-sync"></i>  Referal Program <span class="caret-left"><i class="fas fa-caret-left white"></i></span>
					</a>

					<a href="../account" class="side-menu" id="account" data-menu-active="false">
						<i class="fas fa-user-circle primary-color"></i>  My Zenith Account
					</a>
					
					<a  href="?target=settings#rsettings" class="side-menu get-content-with-js" id="menu-settings" data-menu-active="<?php echo (isset($STT) && $STT == true ? 'true' : 'false') ?>">
					<i class="fas fa-cog"></i>  Settings <span class="caret-left"><i class="fas fa-caret-left white"></i></span>
					</a>
					
					<a href="../logout" class="side-menu" id="logout" data-menu-active="false">
						<i class="fas fa-sign-out-alt primary-color"></i>  Sign out
					</a>
					
					<div class="text-center" style="background-color: green; margin: 5px; padding: 10px;">
						<h3 class="white">TOKEN BALANCE</h3>
						<h1 class="white"><?php echo $user->zentToken ?> <span style="font-size: 50%">ZENT</span></h1>
					</div>
				</div>

			</div>
													<script>
													function copyToClipboard(content){
													content.select();
													 document.execCommand('Copy');
													 alert('Copied to clipboard');
													}
													</script>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="RHS">
				<div id="RHS-inner" class="white">
					<!-- Start Section -->
						<div class="" style="padding-top: 0px">
							<div class="container">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="RHS-container">
							
									<!--Token Details-->
										<div class="RHS-section black" id="token">
											<div class="text-center">
													<div style="padding: 0px 20px">
														<h6 class="primary-color animated" data-animate="fadeInUp" data-delay=".0">ZENT Tokens</h6>
														<h2 class="primary-color animated" data-animate="fadeInUp" data-delay=".1">Pre-Sale &amp; Values</h2>
														<p class="black animated" data-animate="fadeInUp" data-delay=".2">The ZENT Tokens provides a ZenithCard holder with the right to use the ZenithCard for transaction using ZENT without having to pay additional licensing fees (transaction fees charged by third party card issuers and payment system providers remain applicable). Payments made with ZenithCard using tokens other than ZENT is, however- in addition half of the transaction fee charged by the card issuing partner – subject to the payment of a license fee as remuneration for the use of the software protocol developed as part of the ZenithCard project.</p>
													</div>
											</div><!-- .row  -->
											
											<div class="gaps size-3x"></div>
											<div class="gaps size-3x d-none d-md-block"></div><!-- .gaps  -->

											<div class="row align-items-center">
												<div class="col-lg-12">
													<div class="row event-info">
														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay="0">
																<h6 class="primary-color">Start</h6>
																<p>April 23rd, 2018 (12:00AM UTC)</p>
															</div>
														</div><!-- .col  -->
														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".1">
																<h6 class="primary-color">Number of tokens for sale</h6>
																<p>500,000,000 ZENT (50%)</p>
															</div>
														</div><!-- .col  -->
														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".2">
																<h6 class="primary-color">End</h6>
																<p>May 4th, 2018 (11:00AM GMT)</p>
															</div>
														</div><!-- .col  -->
														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".3">
																<h6 class="primary-color">Tokens exchange rate</h6>
																<p>1 ETH = 10,000 ZENT<br/>10 ETH = 100,000 ZENT</p>
															</div>
														</div><!-- .col  -->
														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".4">
																<h6 class="primary-color">Acceptable currencies</h6>
																<p>ETH, BTC</p>
															</div>
														</div><!-- .col  -->

														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".4">
																<h6 class="primary-color">Soft Cap</h6>
																<p><b>25,000,000 USD</b><br/>50,000 ETH / 3,100 BTC</p>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".5">
																<h6 class="primary-color">Minimal transaction amount</h6>
																<p><b>Pre-Sale:</b> 1 ETH <br/><b>Public Sale:</b>0.5 ETH</p>
															</div>
														</div><!-- .col  -->


															<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".4">
																<h6 class="primary-color">Hard Cap</h6>
																<p><b>40,000,000 USD</b><br/>81,200 ETH / 5,100 BTC</p>
															</div>
													</div><!-- .row  -->
												</div><!-- .col  -->
											</div><!-- .row  -->



											<div class="gaps size-3x"></div>
											<div class="gaps size-3x d-none d-md-block"></div><!-- .gaps  -->

											<div class="row text-center">
												<div class="col-md-6">
													<div class="single-chart light res-m-btm">
														<h3 class="primary-color">Initial Token Distribution</h3>
														<div class="animated" data-animate="fadeInUp" data-delay=".0">
															<img src="../images/chart-blue-a.jpeg" alt="chart">
														</div>
													</div>
												</div><!-- .col  -->

												<div class="col-md-6">
													<div class="single-chart light">
														<h3 class="primary-color">Sale Proceed Allocation</h3>
														<div class="animated" data-animate="fadeInUp" data-delay=".1">
															<img src="../images/chart-blue-b.jpeg" alt="chart">
														</div>
													</div>
												</div><!-- .col  -->
											</div><!-- .row  -->
										</div><!--#token-->
										
										<!--KYC Individual-->
										<div class="RHS-section" id="KYC-individual">
										<?php
										if($activeKYC == 'legal-entity'){//If the user already completed KYC Legal entity
											?>
											<div class="text-center">
													<i class="fas fa-exclamation-circle" style="font-size: 50px;color:red"></i>
												<h2 class="grey">You do not have access to complete KYC Individual, you already completed a KYC for Legal Entity</h2>
											</div>
											<?php
										}else{
										require('kyc-individual.php');
										}
										?>
										</div><!--#KYC-individual-->
										
										<!--KYC Legal-->
										<div  class="RHS-section" id="KYC-legal">
											<?php
											if($activeKYC == 'individual'){//If the user already completed KYC individual
												?>
												<div class="text-center">
													<i class="fas fa-exclamation-circle" style="font-size: 50px;color:red"></i>
													<h2 class="grey">You do not have access to complete KYC Legal Entity, you already completed a KYC for Individual</h2>
												</div>
												<?php
											}else{
											require('kyc-legal.php');
											}
											?>
										</div>	<!-- #KYC-legal-->											
								
										<!--Referal Program-->
										<div class="RHS-section" id="referal-program">
											<style>
												#referal-program-container{
													padding: 0px 20px;
												}
												#ref-code-container{
													width: 100%;
													margin: 10px 0px;
													text-align: center;
													background-color: rgba(128,128,128,0.2);
													padding: 10px;
													font-weight: bold;
													border: 2px dotted #003300;
												}
											</style>
											
											<div class="text-center primary-color" id="referal-container">
												<img src="../images/logo2x.png" width="200px" height="auto">
												<h2 class="primary-color text-center"><i class="fas fa-sync"></i> Referal Program</h2>
												<p>Earn $10 worth of ZENT tokens (100 ZENT) by refering a friend to participate in our ICO</p>
												<br/>
												<h3 class="text-center primary-color">YOUR REFERAL LINK</h3>
												<input class="black" id="ref-code-container" value="<?php  echo $root.'/register/?ref='.$user->refCode ?>" readonly>
												<button class="copy-to-clipboard-btn" onclick="javascript: copyToClipboard(document.querySelector('input#ref-code-container'))" title="Copy referal link to clipboard"><i class="fas fa-copy"></i>  Copy Link</button><br/><br/>
												<div style="text-align:center">
													<p class="grey">Share link</p>
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
													<a href="<?php echo $user->whatsappShareLink ?>" class="ref-share-link whatsapp" title="share on whatsapp"> <i class="fab fa-whatsapp-square"></i>&nbspWhatsApp</a>
													<a href="<?php echo $user->facebookShareLink ?>" class="ref-share-link facebook" title="share on facebook"> <i class="fab fa-facebook-square"></i>&nbspFacebook</a>
													<a href="<?php echo $user->twitterShareLink ?>" class="ref-share-link twitter" title="share on twitter"> <i class="fab fa-twitter-square"></i>&nbspTwitter</a>
													<a href="<?php echo $user->linkedinShareLink ?>" class="ref-share-link linkedin" title="share on linkedin"> <i class="fab fa-linkedin"></i>&nbspLinkedIn</a>
													<a href="<?php echo $user->googlePlusShareLink ?>" class="ref-share-link google-plus" title="share on google plus"> <i class="fab fa-google-plus-square"></i>&nbspGoogle Plus</a>
												</div>
											</div>
											
											<script>
											/*document.querySelector('button#copy-link-btn').addEventListener('click',function(){
													document.querySelector('#ref-code-container').select();
													 document.execCommand('Copy');
													 alert('Address copied to clipboard');
													});*/
											</script>
										</div>	<!-- #referal-program-->											
								
										<!--contribute-->
										<div class="RHS-section" id="contribute">
										<style>
											#make-contribution-container{
												margin-bottom:20px;
											}
												img.currency{
													width: 200px;
													height: 200px;
												}
												input#eth-address,input#btc-address{
													font-size: 12px;
													text-align: center;
												}
										
												@media all and (max-width: 768px){
												
												}
											</style>
											
												<!------------------------------------------------->
											<div style="padding: 10px; background-color: rgba(0,50,0,0.5); border-radius: 5px; box-shadow: 0px 10px 10px #003300; margin-bottom: 20px;">
												<div class="row align-items-center">
													<div class="col-lg-12">
														<div class="row event-info">
															<div class="col-sm-6">
																<div>
																	<h6 class="primary-color">Start</h6>
																	<p class="black">April 23rd, 2018 (12:00AM GMT)</p>
																</div>
															</div><!-- .col  -->
															<div class="col-sm-6">
																<div>
																	<h6 class="primary-color">Number of tokens for sale</h6>
																	<p class="black">500,000,000 ZENT (50%)</p>
																</div>
															</div><!-- .col  -->
															<div class="col-sm-6">
																<div class="event-single-info">
																	<h6 class="primary-color">End</h6>
																	<p class="primary-color">May 4th, 2018 (11:00AM GMT)</p>
																</div>
															</div><!-- .col  -->
															<div class="col-sm-6">
																<div class="event-single-info">
																	<h6 class="primary-color">Tokens exchange rate</h6>
																	<p class="primary-color">1 ETH = 10,000 ZENT, 1 BTC = 1000 ZENT</p>
																</div>
															</div><!-- .col  -->
															<div class="col-sm-6">
																<div class="event-single-info">
																	<h6 class="primary-color">Acceptable currencies</h6>
																	<p class="primary-color">ETH, BTC</p>
																</div>
															</div><!-- .col  -->
															<div class="col-sm-6">
																<div class="event-single-info">
																	<h6 class="primary-color">Minimal transaction amount</h6>
																	<p class="primary-color">0.2 ETH/ 0.02 BTC/</p>
																</div>
															</div><!-- .col  -->
														</div><!-- .row  -->
													</div><!-- .col  -->

												</div><!-- .row  -->
											</div>
											<!-------------------------------------------------->
																						
											<h2 class="primary-color text-center"><i class="fas fa-hand-holding-usd"></i>  Contribute Now! </h2>
											<div id="make-contribution-container">
													<div class="row">
														<div class="col-lg-6 col-md-6 col-sm-6 coloxs-12">
															<div class="text-center" data-action="toggle">
																<img src="../images/currency/ethereum.png" class="currency">
																<h3 class="black">Ethereum</h3>
																<button data-toggle-role="toggle-trigger" class="btn">CLICK TO CONTRIBUTE</button>
																
																<div data-toggle-role="main-toggle">
																	<!--<p class="grey text-center">We are sorry, this payment channel is temporary unavailable</p>-->
																
																	<input type="text" class="form-control" id="eth-address" value="0x7838A4A5B355BC27971dF2539e119e4B00104E6D" readonly><br/>
																	<button class="copy-to-clipboard-btn" onclick="javascript: copyToClipboard(document.querySelector('input#eth-address'))"><i class="fas fa-copy"></i>  copy ETH address</button>
																	<h4 class="primary-color">Scan the Bar Code For ETH Address</h4>
																	<a href="http://qrcoder.ru" target="_blank">
																		<img src="http://qrcoder.ru/code/?0x7838A4A5B355BC27971dF2539e119e4B00104E6D&4&0" width="148" height="148" border="0" title="ZenithCard ETH QR Code">
																	</a>
																</div>
															</div>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 coloxs-12">
															<div class="text-center" data-action="toggle">
																<img src="../images/currency/bitcoin.png" class="currency">
																<h3 class="black">Bitcoin</h3>
																<button data-toggle-role="toggle-trigger" class="btn">CLICK TO CONTRIBUTE</button>
																
																<div data-toggle-role="main-toggle" class="text-center">
																	<!--<p class="grey text-center">We are sorry, this payment channel is temporary unavailable</p>-->
																	
																	<input type="text" class="form-control" id="btc-address" value="1CJSUYt3aZzvypZ5Q7V3RzmNKrouD1L82b" readonly><br/>
																	<button class="copy-to-clipboard-btn" onclick="javascript: copyToClipboard(document.querySelector('input#btc-address'))"><i class="fas fa-copy"></i>  copy BTC address</button>
																	<h4 class="primary-color">Scan the Bar Code For BTC Address</h4>
																	<a href="http://qrcoder.ru" target="_blank">
																		<img src="http://qrcoder.ru/code/?1CJSUYt3aZzvypZ5Q7V3RzmNKrouD1L82b&4&0" width="148" height="148" border="0" title="ZenithCard BTC QR Code">
																	</a>
																</div>
															</div>
														</div>
														
														
													</div>
													</div>
												</div>	<!-- #contribute-->										
								
										<!--Settings-->
										<div  class="RHS-section" id="settings">
											<style>
												#change-password-form-container{
													width: 50%;
													margin: 0px 25%;
												}
												.password-change-report-container{
													text-align: center;
													color:red;
													background-color: rgba(20,0,0,0.1);
													border-radius: 5px;
													padding: 10px;
													margin-bottom: 20px;
												}
												@media all and (max-width: 768px){
													#change-password-form-container{
													width: 90%;
													margin: 0px 5%;
													}
												}
											</style>
											<h2 class="primary-color text-center"><i class="fas fa-key"></i> Change Password</h2>
											<div id="change-password-form-container">
											<?php
											if(isset($passwordChangeReport)){
												switch ($passwordChangeReport){
													case 000:
													?>
													<div class="password-change-report-container">
														<p>Changing of password failed, please try again later</p>
													</div>
													<?php
													break;
													case 999:
													?>
													<div class="password-change-report-container">
														<p>New passwords do not match</p>
													</div>
													<?php
													break;
													case 888:
													?>
													<div class="password-change-report-container">
														<p>Incorrect old password</p>
													</div>
													<?php
													break;
												}
											}
											?>
												<form action="<?php $_PHP_SELF ?>" method="POST">
													<div class="form-group">
														<input type="password" name="old_password" class="form-control" placeholder="Enter old password" required>
													</div>
													
													<div class="form-group">
														<input type="password" name="new_password01" class="form-control" placeholder="Enter new password" required>
													</div>
													
													<div class="form-group">
														<input type="password" name="new_password02" class="form-control" placeholder="Repeat new password" required>
													</div>

													<div class="text-right">
														<input type="submit" name="changePassword" value="Change Password" class="btn">
													</div>
												</form>
											</div>
										</div>	<!-- #Settings-->											
								
								
									</div><!-- .col -->
								</div><!-- .row -->
							</div><!-- .container  -->
						</div>
				<!-- Start Section -->

				</div>
				
				
	<?php
	require('../resources/global/footer.php');
	?>
			</div><!--#RHS-->

		</div>
	</div> <!--.container-fluid -->
	
	
	
		<!-- Preloader !remove please if you do not want -->
	<div id="preloader">
		<div id="loader"></div>
		<div class="loader-section loader-top"></div>
   		<div class="loader-section loader-bottom"></div>
	</div>
	<!-- Preloader End -->

	<!--JavaScript from Mato library
	<script  type="text/javascript" language="javascript" src="../resources/mato/lib/JMatt/toggle.js"></script>-->

	<script type="text/javascript">
	
/**********************************Element Toggling ***************************************************/	

 var toggleElements = document.querySelectorAll("[data-action = 'toggle']");
 //alert(toggleElements.length);
 
 for(var t=0;t<toggleElements.length;t++){
	 var mainToggle = toggleElements[t].querySelector("[data-toggle-role = 'main-toggle']");
	 var toggleTrigger = toggleElements[t].querySelector("[data-toggle-role = 'toggle-trigger']");

	 var showMsg_ = toggleTrigger.getAttribute("data-toggle-off") ;
	 var showMsg = (showMsg_ == null || showMsg_ == "" ? toggleTrigger.innerHTML : showMsg_);
	 var hideMsg_ = toggleTrigger.getAttribute("data-toggle-on");
	 var hideMsg = (hideMsg_ == null || hideMsg_ == "" ? toggleTrigger.innerHTML : hideMsg_);

	 var arrow = toggleTrigger.getAttribute("data-toggle-arrow");
	 toggleTrigger.style.cursor = "pointer";
	 
	 toggleTrigger.innerHTML = showMsg+(arrow == "false" ? "" : "  <span class=\"glyphicon glyphicon-chevron-down\"></span>");
	 toggle(toggleTrigger,mainToggle,showMsg,hideMsg,arrow);
 }
 
 function toggle(trigger,toggleElement,sm,hm,arrow){
	 trigger.onclick = function(event){
		// event.preventDefault();
		 if(toggleElement.style.display == 'block'){
//NOTE: The function fader() is in masterjs.js. It must have been included prior to this script
//A fall back has been provided in the catch block
	try{ 
	fader(toggleElement,'fadeOut','normal');
	}
catch(err){
		console.log('function fader() did not execute well, probably because masterjs.js is not available or something went wrong there. Technical Detail:'+err);
	toggleElement.style.display = 'none';	
	}
trigger.innerHTML = sm+(arrow == "false" ? "" : "  <span class=\"glyphicon glyphicon-chevron-down\"></span>");
	 }else{
		 try{
			fader(toggleElement,'fadeIn','normal');
		 }
	catch(err){
	 console.log('function fader() did not execute well, probably because masterjs.js is not available or something went wrong there. Technical Detail: '+err);
	toggleElement.style.display = 'block';	
	}
trigger.innerHTML =  hm+(arrow == "false" ? "" : "  <span class=\"glyphicon glyphicon-chevron-up\"></span>");
		}
	 
	 }
	 
 }
 /***************************************************************************************************/
 
 
 /*************************************Side Menu Engine********************************************/
 
var sideMenus = document.querySelectorAll('.side-menu.get-content-with-js');
for(var sm = 0; sm < sideMenus.length; sm++){
	activateMenu(sideMenus[sm]);
}

function activateMenu(menu){
	var id = menu.getAttribute('id');
	var content = "";
	switch(id){
		case 'menu-token-details':
		content = ".RHS-section#token";
		break;
		case 'menu-kyc-individual':
		content = ".RHS-section#KYC-individual";
		break;
		case 'menu-kyc-legal':
		content = ".RHS-section#KYC-legal";
		break;
		case 'menu-contribute':
		content = ".RHS-section#contribute";
		break;
		case 'menu-referal-program':
		content = ".RHS-section#referal-program";
		break;
		case 'menu-settings':
		content = ".RHS-section#settings";
		break;
	}
	menu.addEventListener('click',function(event){
		event.preventDefault();
		
		if(window.innerWidth <= 768){//scroll down automatically if it was a smaill screen
			var scrollTo = document.querySelector('#LHS').clientHeight + 80;
			var scroll = 0;
			setInterval(function(){
				if(scroll > scrollTo){
					clearInterval(this);
				}
				else{
					scroll += 20;
			window.scrollTo(0,scroll);}},1);
				}
			
		openPreLoader();
		setTimeout(function(){
		switchSectionContent(id,content);
		closePreloader()
		},2000);
	});
}

	function switchSectionContent(menuId,content){
		var allRHS = document.querySelectorAll('.RHS-section');
		for(var r = 0; r < allRHS.length; r++){//First hide all the RHS section
			allRHS[r].style.display = 'none';
		}
		document.querySelector(content).style.display = 'block';
		//Then show only the target one
			setActiveMenu(menuId);	//Indicate the current sectio in the side menu
	}
	
	function setActiveMenu(id){
		for(var sm_ = 0; sm_ < sideMenus.length; sm_++){
			if(sideMenus[sm_].getAttribute('id') == id){
				sideMenus[sm_].setAttribute('data-menu-active','true');
			}
			else{
				sideMenus[sm_].setAttribute('data-menu-active','false');
			}
		}
	}
 /***************************************************************************************************/
 
 
 /*************************************RHS Preloader********************************************/
	RHS = document.querySelector('#RHS');
	RHSContainer = document.querySelector('#RHS-container');

					function openPreLoader(){
					 var preloaderParent = document.createElement("div");
						preloaderParent.setAttribute('id','RHS-content-preloader');
						preloaderParent.setAttribute("style","position:absolute;z-index: 1000;width:100%;height:100%;text-align:center;");

					var preloaderGif = document.createElement("img");
						preloaderGif.setAttribute("src","../resources/mato/lib/gifs/loading.gif");
						preloaderGif.setAttribute("width","100px");
						preloaderGif.setAttribute("height","100px");
						preloaderGif.setAttribute("style","margin: 20%");
						
					
					/*var closer = document.createElement("span");
						closer.setAttribute('class','close');
						closer.setAttribute('style','float:right; font-size: 50px; color: red');
						closer.innerHTML = " &times ";
						closer.addEventListener('click',function(){
							closePreloader();
						});
						
					preloaderParent.appendChild(closer);*/
					
					preloaderParent.appendChild(preloaderGif);
					
					RHSContainer.setAttribute('style','opacity: 0.1');
					RHS.insertBefore(preloaderParent,RHS.firstChild);
					}

					function closePreloader(){
						var preLoader = document.querySelector('#RHS-content-preloader');
						if(preLoader != null || preLoader != ''){
							RHSContainer.setAttribute('style','opacity: 1');
							RHS.removeChild(preLoader);
						}
				}	

			//Open preloader on first load, just for paparazzi;
			openPreLoader();
			setTimeout(function(){closePreloader()},5000); /***************************************************************************************************/
	</script>
	
	<!-- JavaScript (include all script here) -->
	<script src="../assets/js/jquery.bundle.js"></script>
	<script src="../assets/js/script.js"></script>
	
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