<?php
require('../resources/master.php');
if($status == 0){
	$tool->redirect_to('../login');//Visitors are not allowed here
}
?>
<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="ZenithCard">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Cryptocurrency Backed Debit Card">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="../images/favicon.png">
	<!-- Site Title  -->
	<title>ZenithCard Account</title>
	<!-- Vendor Bundle CSS -->
	<link rel="stylesheet" href="../assets/css/vendor.bundle.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="../assets/css/style.css?ver=1.1">
	<link rel="stylesheet" href="../assets/css/theme-mint.css?ver=1.1">
	
	<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ddeabd6520c7f855e7ea0c0b4/96742410b1c65912559289283.js");</script>
</head>
<body class="theme-dark io-azure" data-offset="80">
	<style>
		#status-container{
			width: 50%;
			margin: 10% 25%;
		}
		#status{
			padding: 10px;
		}
		li.account-status{
			list-style-type: none;
			background-color: #fff;
			padding: 10px 5px;
			color : #003300;
			box-shadow: 0px 10px 10px rgba(0,200,0,0.2) inset;
		}
		@media all and (max-width: 768px){
			#status-container{
				width: 90%;
				margin: 5%;
			}
		}
	</style>
	<!-- Header --> 
	<header class="site-header is-sticky">
				
	<?php
	$ref = 'accounts page';
	require('../resources/global/header.php');
	?>
		<!-- Banner/Slider -->
		<div id="header" class="banner banner-full d-flex align-items-center">
			<div class="container">
				<div class="banner-content">
				</div><!-- .banner-content  -->
			</div><!-- .container  -->
		</div>
		<!-- End Banner/Slider -->
		
	</header>
	<!-- End Header -->
	
						<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="animated" data-animate="fadeInRight" data-delay="1.25">
								<div id="status-container">
									<div id="status">
									<h2>ACCOUNT STATUS</h2>
										<ul>
											<?php
											if($user->verification == 1){
												?>
												<li class="account-status"><span class="verified"><i class="fas fa-check-circle"></i> Verified</span></li>
												<?php
											}
											else{
												?>
												<li class="account-status"><span class="verified"><i class="fas fa-times-circle"></i> Not Verified</span>
													<p class="help-block">check your mail we sent you via <strong>(<?php echo $user->email?>) for verification procedure </strong></p>
												</li>
											<?php
											}
											?>
											<li class="account-status">Token Balance: <?php echo $user->zentToken ?> ZENT</li>
											<li class="account-status">
												<span>Referal Link: <?php echo $user->referalLink ?></span>
												<p class="help-block">Share the your referal link and get 100 ZENT token bonus everytime a your referal link is used to register</p>
												<style>
												a.ref-share-link{
													margin: 5px;
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
													color: rgb(21, 75, 57);
												}
												
												a.ref-share-link:hover{
													text-decoration: none;
												}
												</style>
											</li>
												<div>Share link on: 
												<a href="<?php echo $user->facebookShareLink ?>" class="ref-share-link facebook"> <i class="fab fa-facebook-square"></i> Facebook</a>
												<a href="<?php echo $user->twitterShareLink ?>" class="ref-share-link twitter"> <i class="fab fa-twitter-square"></i> Twitter</a>
												<a href="<?php echo $user->linkedinShareLink ?>" class="ref-share-link linkedin"> <i class="fab fa-linkedin"></i> LinkedIn</a>
												<a href="<?php echo $user->googlePlusShareLink ?>" class="ref-share-link google-plus"> <i class="fab fa-google-plus-square"></i> Google Plus</a>
												</div>
											<li class="account-status"><span>My Refers: <?php echo $user->referred ?> </span>
											<p class="help-block">Number of people that have used your referal link to register</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div><!-- .col  -->
						
					</div><!-- .row  -->

	
	
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