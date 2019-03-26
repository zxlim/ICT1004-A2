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
						<li class="<?php safe_echo(active_nav(['login.php', 'register.php'])); ?> submenu dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							   Account
							</a>
							<ul class="dropdown-menu">
								<li class="<?php safe_echo(active_nav(['login.php'])); ?>">
									<a class="nav-link" href="login.php">Login</a>
								</li>
								<li class="<?php safe_echo(active_nav(['register.php'])); ?>">
									<a class="nav-link" href="register.php">Register</a>
								</li>
							</ul>
						</li>
						<li class="<?php safe_echo(active_nav(['contact.php'])); ?>">
							<a class="nav-link" href="contact.php">Contact Us</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<button class="notification">
								<span class="lnr lnr-bubble" id="notification"></span>
							</button>
						</li>
						<li class="nav-item">
							<button class="search">
								<span class="lnr lnr-magnifier" id="search"></span>
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
            <form class="d-flex justify-content-between" name="form-search" id="form-search">	
                <input type="text" class="form-control" id="search_query" name="search_query" placeholder="Search items or keywords">	
                <button type="submit" class="btn"></button>	
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>	
            </form>	
        </div>	
    </div>
</header>