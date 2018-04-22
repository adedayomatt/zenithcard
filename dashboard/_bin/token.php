<?php
if(isset($_GET['js']) && $_GET['js'] == 'true'){
	require('../resources/master.php');
	?>
	
	<?php
}
if(isset($_POST['complete_KYC'])){
	print_r($_POST);
}

if(isset($_GET['tkn']) && $_GET['tkn'] == 'abc' && $status != 0){
?>	
<style>
.animated{
	visibility: visible !important;
}
</style>
			<div class="row text-center">
				<div class="col-lg-6 offset-lg-3">
					<div class="section-head-s2">
						<h6 class="heading-xs animated" data-animate="fadeInUp" data-delay=".0">ZENT Tokens</h6>
						<h2 class="section-title animated" data-animate="fadeInUp" data-delay=".1">Pre-Sale &amp; Values</h2>
						<p class="animated" data-animate="fadeInUp" data-delay=".2">The ZENT Tokens provides a ZenithCard holder with the right to use the ZenithCard for transaction using ZENT without having to pay additional licensing fees (transaction fees charged by third party card issuers and payment system providers remain applicable). Payments made with ZenithCard using tokens other than ZENT is, however- in addition half of the transaction fee charged by the card issuing partner – subject to the payment of a license fee as remuneration for the use of the software protocol developed as part of the ZenithCard project.</p>
					</div>
				</div><!-- .col  -->
			</div><!-- .row  -->
			<div class="row align-items-center">
				<div class="col-lg-12">
					<div class="row event-info">
						<div class="col-sm-6">
							<div class="event-single-info animated" data-animate="fadeInUp" data-delay="0">
								<h6>Start</h6>
								<p>April 1, 2018 (9:00AM GMT)</p>
							</div>
						</div><!-- .col  -->
						<div class="col-sm-6">
							<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".1">
								<h6>Number of tokens for sale</h6>
								<p>500,000,000 ZENT (50%)</p>
							</div>
						</div><!-- .col  -->
						<div class="col-sm-6">
							<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".2">
								<h6>End</h6>
								<p>April 7, 2018 (11:00AM GMT)</p>
							</div>
						</div><!-- .col  -->
						<div class="col-sm-6">
							<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".3">
								<h6>Tokens exchange rate</h6>
								<p>1 ETH = 10,000 ZENT, 1 BTC = 1000 ZENT</p>
							</div>
						</div><!-- .col  -->
						<div class="col-sm-6">
							<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".4">
								<h6>Acceptable currencies</h6>
								<p>ETH, BTC</p>
							</div>
						</div><!-- .col  -->
						<div class="col-sm-6">
							<div class="event-single-info animated" data-animate="fadeInUp" data-delay=".5">
								<h6>Minimal transaction amount</h6>
								<p>0.2 ETH/ 0.02 BTC/</p>
							</div>
						</div><!-- .col  -->
					</div><!-- .row  -->
				</div><!-- .col  -->

			</div><!-- .row  -->

			<div class="gaps size-3x"></div><div class="gaps size-3x d-none d-md-block"></div><!-- .gaps  -->

			<div class="row text-center">
				<div class="col-md-6">
					<div class="single-chart light res-m-btm">
						<h3 class="sub-heading">Initial Token Distribution</h3>
						<div class="animated" data-animate="fadeInUp" data-delay=".0">
							<img src="../images/chart-blue-a.jpeg" alt="chart">
						</div>
					</div>
				</div><!-- .col  -->

				<div class="col-md-6">
					<div class="single-chart light">
						<h3 class="sub-heading">Sale Proceed Allocation</h3>
						<div class="animated" data-animate="fadeInUp" data-delay=".1">
							<img src="../images/chart-blue-b.jpeg" alt="chart">
						</div>
					</div>
				</div><!-- .col  -->
			</div><!-- .row  -->

<?php
}
?>