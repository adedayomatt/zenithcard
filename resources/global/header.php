	<link rel="stylesheet" href="<?php echo $root.'/resources/css/global.css'?>">
	<script  type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/tools/fontawesome-free-5.0.9/svg-with-js/js/fontawesome-all.min.js' ?>"></script>
		<!-- Place Particle Js -->
		<div id="particles-js" class="particles-container particles-js"></div>

		<!-- Navbar -->
		<div class="navbar navbar-expand-lg is-transparent" id="mainnav">
			<nav class="container">
				<a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="<?php echo $root ?>">
					<img class="logo logo-dark" alt="logo" src="<?php echo $root.'/images/logo.png'?>" srcset="<?php echo $root.'/images/logo2x.png 2x'?>">
					<img class="logo logo-light" alt="logo" src="<?php echo $root.'/images/logo-white.png' ?>" srcset="<?php echo $root.'/images/logo-white2x.png 2x' ?>">
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle">
					<span class="navbar-toggler-icon">
						<span class="ti ti-align-justify"></span>
					</span>
				</button>

				<div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
					<ul class="navbar-nav animated remove-animation" data-animate="fadeInDown" data-delay=".9">
						<li class="nav-item"><a class="nav-link menu-link" href="<?php echo ($ref == 'home page' ? 'index.php#intro' : $root.'/#intro') ?>">What is ZenithCard<span class="sr-only">(current)</span></a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="<?php echo ($ref == 'home page' ? '#tokenSale' : $root.'/#tokenSale') ?>">Token Sale</a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="<?php echo ($ref == 'home page' ? '#roadmap' : $root.'/#roadmap') ?>">Roadmap</a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="<?php echo ($ref == 'home page' ? '#apps' : $root.'/#apps' ) ?>">Apps</a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="<?php echo ($ref == 'home page' ? '#team' : $root.'/#team' ) ?>">Team</a></li>
						<!--<li class="nav-item"><a class="nav-link menu-link" href="#faq">Faq</a></li>-->
						<li class="nav-item"><a class="nav-link menu-link" href="<?php echo ($ref == 'home page' ? '#contact' : $root.'/#contact' ) ?>">Contact</a></li>
					</ul>
					<ul class="navbar-nav navbar-btns animated remove-animation" data-animate="fadeInDown" data-delay="1.15">
						<?php
						if($status == 0){
							if($ref == 'home page' || $ref == 'register page' ){
								?>
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="<?php echo $root.'/login' ?>">Login</a></li>
							<?php
							}
						if($ref == 'home page' || $ref == 'login page'){
								?>
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="<?php echo $root.'/register' ?>">Register</a></li>
								<?php
							}
							
						if($ref == 'logout page'){
							?>
						<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="<?php echo $root.'/login' ?>">Login</a></li>
							<?php
							}
						}
						else{
								?>
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="<?php echo $root.'/logout' ?>">Log out</a></li>
							<?php
							if($ref != 'dashboard page'){
								?>
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="<?php echo $root.'/dashboard' ?>">Dashboard</a></li>
								<?php
								}
							}
							?>
					</ul>
				</div>
			</nav>
		</div>
		<!-- End Navbar -->