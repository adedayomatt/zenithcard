<?php
require('../resources/master.php');
if($status != 0){
	$user->logout();
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
	<title>ZenithCard &#8226; Logout</title>
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
	<!-- Header --> 
	<header class="site-header is-sticky">
	
	<?php
	$ref = 'logout page';
	require('../resources/global/header.php');
	?>
		<!-- Banner/Slider -->
		<div id="header" class="banner banner-full d-flex align-items-center">
			<div class="container">
				<div class="banner-content">
					<div class="row align-items-center mobile-center">
					
					<?php
					if($status == 0){ // If user is not logged in
					?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="text-center">
								<h3>You were not logged in!</h3>
								<a href="../login" class="btn">Login Now</a>
							</div>
						</div>
						
						<?php
					}
					else{
						?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="text-center">
								<h3>You are now logged out!</h3>
								<a href="../login" class="btn">Login Back</a><br/><br/>
								<a href="../register" class="btn">Register New Account</a>
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