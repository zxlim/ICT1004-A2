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
			<div class="col-lg-3  col-md-6 col-sm-6">
				<div class="single-footer-widget">
					<h6>About Us</h6>
					<p>
						FastTrade, a one-stop solution to buying and selling pre-loved items to the community.
						<br /><br />
						For the partial fulfillment of the module ICT1004: Web Systems and Technologies.
					</p>
				</div>
			</div>
			<div class="col-lg-4  col-md-6 col-sm-6">
				<!-- Filler -->
			</div>
			<div class="col-lg-3  col-md-6 col-sm-6">
				<div class="single-footer-widget mail-chimp">
					<h6 class="mb-20">Instragram Feed</h6>
					<ul class="instafeed d-flex flex-wrap">
						<li><img src="static/img/vendor/i1.jpg" alt=""></li>
						<li><img src="static/img/vendor/i2.jpg" alt=""></li>
						<li><img src="static/img/vendor/i3.jpg" alt=""></li>
						<li><img src="static/img/vendor/i4.jpg" alt=""></li>
						<li><img src="static/img/vendor/i5.jpg" alt=""></li>
						<li><img src="static/img/vendor/i6.jpg" alt=""></li>
						<li><img src="static/img/vendor/i7.jpg" alt=""></li>
						<li><img src="static/img/vendor/i8.jpg" alt=""></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="single-footer-widget">
					<h6>Follow Us</h6>
					<p>Let us be social</p>
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