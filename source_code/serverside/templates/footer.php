<?php
if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}
?>
<footer class="footer-area section_gap">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="single-footer-widget">
					<h6>About Us</h6>
					<p>
						FastTrade, a one-stop solution to buying and selling pre-loved items to the community.
					</p>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="single-footer-widget">
					<h6>Site Navigation</h6>
					<ul>
						<li><a class="a-darkgrey" href="index.php">Home</a></li>
						<li><a class="a-darkgrey" href="shop.php">Shop</a></li>
						<li><a class="a-darkgrey" href="login.php">Account</a></li>
						<li><a class="a-darkgrey" href="contact.php">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="single-footer-widget">
					<h6>Follow Us</h6>
					<p>Get in touch on our social platforms</p>
					<div class="footer-social d-flex align-items-center">
						<a class="no-click-pointer"><i class="fab fa-facebook-square"></i></a>
						<a class="no-click-pointer"><i class="fab fa-twitter-square"></i></a>
						<a class="no-click-pointer"><i class="fab fa-instagram"></i></a>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
			<p class="footer-text m-0 text-center">
				Copyright &copy; <?php safe_echo(date("Y")); ?> All rights reserved.
				<br />
				<!--
					Template Author:	Colorlib
					Template License:	CC BY 3.0.
				-->
				Template by <a href="https://colorlib.com" target="_blank">Colorlib</a>
			</p>
		</div>
	</div>
</footer>