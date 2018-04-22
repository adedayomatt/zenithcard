<?php
require('../resources/master.php');

 function cleanInput($input){
	//return $this->connection->real_escape_string(trim(htmlentities($input)));
	return trim(htmlentities($input));
	}
	
	if(isset($_POST['register'])){
		$scannedInput = array_map('cleanInput',array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'refree_id'=>$_POST['refree_id'],'refree_code'=>$_POST['refree_code'])); //I could have used the whole array $_POST, but i don't want to tamper with the password userv set, so i'm not screenning the password
		$scannedInput['password01'] = $_POST['password01'];
		$scannedInput['password02'] = $_POST['password02'];
		$reg = new Register($scannedInput);
		$register = $reg->addNewUser();
	}
?>

<!DOCTYPE html>
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
	<title>ZenithCard &#8226; Register</title>
	<!-- Vendor Bundle CSS -->
	<link rel="stylesheet" href="../assets/css/vendor.bundle.css">
	
	<!--Boostrap added by Matthew
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">-->
	
	<!-- Custom styles for this templae -->
	<link rel="stylesheet" href="../assets/css/style.css?ver=1.1">
	<link rel="stylesheet" href="../assets/css/theme-mint.css?ver=1.1">
	
	<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ddeabd6520c7f855e7ea0c0b4/96742410b1c65912559289283.js");</script>
</head>
<body class="theme-dark io-azure" data-spy="scroll" data-target="#mainnav" data-offset="80">
	<style>

		#form-container{
			background-color: rgba(255,255,255,0.7);
			border-radius: 5px;
			margin-top: 30px;
			margin-bottom:20px;
		}
		form{
			padding:20px;
		}
		.register-report-container{
			text-align: center;
			padding: 10px;
			background-color: rgba(128,128,128,0.1);
			padding: 5px;
			border-radius 5px;
		}
		.register-report-container.successfull{
			color: #003300;
		}
		.register-report-container.failed{
			color: red;
		}
		
	</style>
	<!-- Header --> 
	<header class="site-header is-sticky">
				
	<?php
	$ref = 'register page';
	require('../resources/global/header.php');
	?>

		<!-- Banner/Slider -->
		<div id="header" class="banner banner-full d-flex align-items-center">
			<div class="container">
				<div class="banner-content">
					<div class="row align-items-center mobile-center">
					
					<?php
					if($status == 0){
					?>
					
						<div class="col-lg-6 col-md-12 order-lg-first">
							<div class="header-txt">
								<h1 class="animated" data-animate="fadeInUp" data-delay="1.55">ZenithCard <br class="d-none d-xl-block"> Crypto Based Card <br class="d-none d-xl-block"> and Application</h1>
								<p class="lead animated" data-animate="fadeInUp" data-delay="1.65">Debit card usuable at payment terminals<br class="d-none d-xl-block"> around the world including ATM and Online </p>
								<ul class="btns animated" data-animate="fadeInUp" data-delay="1.75">
									<!--<li><a href="https://goo.gl/forms/a0CZaF5k8MSNryQk2" class="btn">Register to Contribute</a></li>
									<li><a href="#tokenSale" class="btn btn-alt">TOKEN DISTRIBUTION</a></li>-->
								</ul>
							</div>
						</div><!-- .col  -->
						
						<div class="col-lg-6 col-md-12 order-first res-m-bttm-lg" style="padding-right:0px !important;padding-left:0px !important;">
							<div class="animated" data-animate="fadeInRight" data-delay="1.25">
								<div id="form-container" class="primary-color">
									<div style="background-color: #003300; color:#fff">
										<h3 class="text-center" style="padding: 10px 0px; ">Register</h3>
										<p class="text-right" style="padding-right:10px">Already have an account?  <a href="../login">Login instead</a>
									</div>
										<?php //confirm refree if there is
												$_ref_id_ = "";
												$_ref_code_ = "";
										if(isset($_GET['ref']) && $_GET['ref'] != ''){
											?>
												<style>
													.referal-confirmation-container{
														background-color: rgba(128,128,128,0.3);
														padding: 10px; 
														margin: 10px 0px;
														text-align:center;
													}
												</style>									
												<?php
											$refree = trim(htmlentities($_GET['ref']));
											$db = new database();
											$getRefree = $db->query_object("SELECT user_id,referal_code FROM users WHERE referal_code = '$refree' ");
											if($getRefree->rowCount() == 1){
												$_ref = $getRefree->fetch(PDO::FETCH_ASSOC);
												$_ref_id_ = $_ref['user_id'];
												$_ref_code_ = $_ref['referal_code'];
												?>
												<div class="referal-confirmation-container">
													<p><i class="fas fa-exclamation-circle"></i>  You are using this referal code <strong style="text-decoration: underline"><?php echo $refree ?></strong></p>
												</div>
												<?php
											}
											else{
												?>
												<div class="referal-confirmation-container" style="color:red">
													<p><i class="fas fa-exclamation-circle"></i>  The referal code <strong style="text-decoration: underline"><?php echo $refree ?></strong> is invalid, you can continue with registration anyway but no one will be credited with Zent token</p>
												</div>
												<?php
											}
										}
										?>

										<hr class="primary-color" style="margin:0px; padding: 0px">
									
										<?php
										if(isset($register)){
											switch($register){
												case 000:
												?>
												<div class="register-report-container successfull">
													<h2 class="primary-color">Thank you for joining us!</h2>
													<p>An email has been sent to <strong><?php echo $_POST['email'] ?></strong> , please check your mail and verify that you own it to complete your registration</p>
												</div>
												<?php
												break;
												case 102:
												?>
												<div class="register-report-container failed">
													<p>The email <strong><?php echo $_POST['email']?></strong> is already registered. If you own the account and forgot the password, you can reset your password<br/><a href="../account/resetpswd" class="btn">Reset Password Now</a></p>
													<!--<p>The email <strong><?php echo $_POST['email']?></strong> is already registered</p>-->
												</div>
												<?php
												break;
												case 103:
												?>
												<div class="register-report-container failed">
													<p>Passwords do not match, please repeat password</p>
												</div>
												<?php
												break;
											}
										}
										if(!isset($register) || $register > 001){
										?>
									<form action="<?php $_PHP_SELF ?>" method="POST">
										<input type="hidden" name="refree_id" value="<?php echo $_ref_id_ ?>">
										<input type="hidden" name="refree_code" value="<?php echo $_ref_code_ ?>">
												
										<div class="form-group">
											<label for="" class="text-left">Your Name</label>
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<div style="padding: 10px">
														<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo (isset($_POST['first_name']) ? $_POST['first_name'] : "") ?>" required>
													</div>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<div style="padding: 10px">
														<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo (isset($_POST['last_name']) ? $_POST['last_name'] : "") ?>" required>
													</div>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label for="email" class="text-left">Email Address</label>
											<input type="email" name="email" class="form-control" placeholder="you@example.com" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : (isset($_GET['m']) ? $_GET['m'] : '')) ?>" required>
										</div>
										
										<div class="form-group">
											<label for="password" class="text-left">Create Password</label>
											<input type="password" name="password01" class="form-control" placeholder="Create a secure Password" required>
										</div>
										
										<div class="form-group">
											<input type="password" name="password02" class="form-control" placeholder="Repeat Password" required>
										</div>
										<input type="submit" name="register" value="Register" class="btn">
									</form>
									<?php
										}
									?>
								</div>
							</div>
						</div><!-- .col  -->
						
						<?php
					}else{
						?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="text-center">
								<h3>You are currently logged in as <?php echo $user->fullName?></h3>
								<p>You need to log out first to register another ZenithCard account</p>
								<a href="../logout" class="btn">Log out now</a><br/><br/>
								<a href="../dashboard" class="btn">Continue to my Dashboard</a>
							</div>
						</div>
						<?php
					}
					?>
					</div><!-- .row  -->
				</div><!-- .banner-content  -->
			</div><!-- .container  -->
		</div>
		<!-- End Banner/Slider -->
		
	</header>
	<!-- End Header -->
	
	<?php
	require('../resources/global/footer.php');
	?>


	
		<!-- Preloader !remove please if you do not want -->
	<div id="preloader">
		<div id="loader"></div>
		<div class="loader-section loader-top"></div>
   		<div class="loader-section loader-bottom"></div>
	</div>
	<!-- Preloader End -->

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