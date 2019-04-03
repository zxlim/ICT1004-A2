<?php
if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}
?>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="description" content="FastTrade - Buy and Sell in a click!">

<title>
	<?php
	safe_echo(APP_TITLE);
	if (defined("WEBPAGE_TITLE") === TRUE) {
		safe_echo(sprintf(" | %s", WEBPAGE_TITLE), FALSE);
	}
	?>
</title>
<link rel="icon" type="image/png" href="static/img/fasttrade_logo.ico" sizes="32x32" />
<link rel="stylesheet" href="static/css/vendor/linearicons.css">
<link rel="stylesheet" href="static/css/vendor/font-awesome.min.css">
<link rel="stylesheet" href="static/css/vendor/themify-icons.css">
<link rel="stylesheet" href="static/css/vendor/bootstrap.css">
<link rel="stylesheet" href="static/css/vendor/animate.min.css">
<link rel="stylesheet" href="static/css/vendor/owl.carousel.css">
<link rel="stylesheet" href="static/css/vendor/nice-select.css">
<link rel="stylesheet" href="static/css/vendor/nouislider.min.css">
<link rel="stylesheet" href="static/css/vendor/ion.rangeSlider.css" />
<link rel="stylesheet" href="static/css/vendor/ion.rangeSlider.skinFlat.css" />
<link rel="stylesheet" href="static/css/vendor/magnific-popup.css">
<link rel="stylesheet" href="static/css/vendor/theme.css">
<link rel="stylesheet" href="static/css/vendor/dropzone.css">
<link rel="stylesheet" href="static/css/ict1004.css">