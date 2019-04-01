<?php

if (defined("CLIENT") === FALSE) {
	/**
	 * Ghetto way to prevent direct access to "include" files.
	 */
	http_response_code(404);
	die();
}

?>
<header class="header_area sticky-header">
	<div class="main_menu">
		<nav class="navbar navbar-expand-lg navbar-light main_box">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<a class="navbar-brand logo_h" href="index.php">
					<img class="nav-logo" src="static/img/fasttrade_logo.png" alt=""></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
						data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
						aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
					<ul class="nav navbar-nav menu_nav ml-auto">
						<li class="<?php safe_echo(active_nav(['index.php'])); ?>">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="<?php safe_echo(active_nav(['listing.php', 'item.php'])); ?>">
							<a class="nav-link" href="listing.php?cat=1">Shop</a>
						</li>
						<li class="<?php safe_echo(active_nav(['contact.php'])); ?>">
							<a class="nav-link" href="contact.php">Contact Us</a>
						</li>

						<li class="<?php safe_echo(active_nav(['login.php', 'register.php'])); ?> submenu dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								Account
							</a>
							<ul class="dropdown-menu">
								<?php if (session_isauth() === true) { ?>
								<li class="<?php safe_echo(active_nav(['profile.php'])); ?>">
									<a href="profile.php?id=<?php safe_echo($item["user_id"]); ?>">
									<a class="nav-link" href="profile.php?id=<?php echo $_SESSION["user_id"]?>">Profile</a>
								</li>

								<li class="<?php safe_echo(active_nav(['login.php'])); ?>">
									<a class="nav-link" href="logout.php">Logout</a>
								</li>
								<?php } else { ?>
								<li class="<?php safe_echo(active_nav(['login.php'])); ?>">
									<a class="nav-link" href="login.php">Login</a>
								</li>

								<li class="<?php safe_echo(active_nav(['register.php'])); ?>">
									<a class="nav-link" href="register.php">Register</a>
								</li>
								<?php } ?>
							</ul>
						</li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<?php if (session_isauth() === true) { ?>
						<li class="nav-item">
							<button class="notification" id="nav_notification">
								<span class="lnr lnr-bubble"></span>
							</button>
						</li>
						<li class="nav-item">
							<button class="store" id="nav_store">
								<span class="lnr lnr-store"></span>
							</button>
						</li>
						 <?php if ($admin === true) { ?>
						<li class="nav-item">
							<button class="store" id="nav_store">
								<a href="admin_page.php"><span class="lnr lnr-user"></span></a>
							</button>
						</li>
						 <?php }} ?>
						<li class="nav-item">
							<button class="search" id="search">
								<span class="lnr lnr-magnifier"></span>
							</button>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>

	<!-- Search Input -->
	<div class="search_input" id="search_input_box">
		<div class="container">
			<form class="d-flex justify-content-between" name="form-search" id="form-search" method="post"
				  action="search.php">
				<input type="text" class="form-control" name="search_query" placeholder="Search items or keywords">
				<button type="submit" class="btn"></button>
				<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
			</form>
		</div>
	</div>

	<div class="ftnotification" id="ftnotification">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 d-md-none d-lg-block"></div>
				<div class="col-lg-4 col-md-12">
					<ul class="shadow" id="ftnotification-list">
						<li>
							<a class="no-click-event" href="#">No new notifications.</a>
						</li>
						<li>
							<a href="message_list.php">See all messages</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>
