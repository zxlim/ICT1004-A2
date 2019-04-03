<?php define("CLIENT", TRUE);
define("REQUIRE_AUTH", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/admin.php");
define("WEBPAGE_TITLE", "Admin");
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<?php require_once("serverside/templates/html.head.php"); ?>
</head>
<body>
	<!-- Header -->
	<?php require_once("serverside/templates/header.php"); ?>
	<!-- End Header -->

	<!-- Banner Section -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1><?php safe_echo(APP_TITLE); ?> Admin</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">
							Home<span class="lnr lnr-arrow-right"></span>
						</a>
						<a href="">
							Admin Dashboard
						</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Admin Dashboard -->
	<section class="section_gap product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="admin-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true">
						Users
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="cat-tab" data-toggle="tab" href="#cat" role="tab" aria-controls="cat" aria-selected="false">
						Categories
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="loc-tab" data-toggle="tab" href="#loc" role="tab" aria-controls="loc" aria-selected="false">
						Locations
					</a>
				</li>
			</ul>
			<div class="tab-content" id="admin-tabs-content">
				<div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
					<div class="row">
						<div class="col-12 text-center">
							<h3>User Management</h3>
						</div>
					</div>
					<br />
					<div class="progress-table-wrap">
						<div class="progress-table user">
							<div class="table-head">
								<div class="id text-center">
								</div>
								<div class="name">
									Create new user
								</div>
								<div class="actions text-center">
								</div>
							</div>
							<div class="table-row insert-new">
								<div class="id text-center">
									<form name="insert_user" id="insert_user" action="admin.php" method="post">
										<input type="hidden" name="action" value="insert_user" required readonly>
									</form>
								</div>
								<div class="name">
									<input type="text" class="single-input" name="name" placeholder="Name" form="insert_user">
								</div>
								<div class="email">
									<input type="email" class="single-input" name="email" placeholder="Email address" form="insert_user">
								</div>
								<div class="suspended">
									<select class="nice-select" name="suspended" form="insert_user">
										<option value="0" data-display="Suspended: False" selected>False</option>
										<option value="1" data-display="Suspended: True">True</option>
									</select>
								</div>
								<div class="actions text-center">
									<input type="submit" class="genric-btn success" form="insert_user" value="Create">
								</div>
							</div>
							<div class="table-row insert-new">
								<div class="id text-center"></div>
								<div class="loginid">
									<input type="text" class="single-input" name="loginid" placeholder="Login ID" form="insert_user">
								</div>
								<div class="pw">
									<input type="password" class="single-input" name="password" placeholder="Password" form="insert_user">
								</div>
								<div class="admin">
									<select class="nice-select" name="admin" form="insert_user">
										<option value="0" data-display="Admin: False" selected>False</option>
										<option value="1" data-display="Admin: True">True</option>
									</select>
								</div>
							</div>
							<div class="table-row"></div>
							<div class="table-head">
								<div class="id text-center">
									ID
								</div>
								<div class="name">
									Name
								</div>
								<div class="email">
									Email Address
								</div>
								<div class="suspended text-center">
									Suspended
								</div>
								<div class="admin text-center">
									Admin
								</div>
								<div class="actions text-center">
									Actions
								</div>
							</div>
							<?php foreach ($rows_users as $row) { ?>
							<div class="table-row">
								<div class="id text-center">
									<?php safe_echo($row["id"]); ?>
								</div>
								<div class="name">
									<?php safe_echo($row["name"]); ?>
								</div>
								<div class="email">
									<?php safe_echo($row["email"]); ?>
								</div>
								<div class="suspended text-center">
									<?php if ($row["suspended"] === TRUE) { safe_echo("True"); } else { safe_echo("False"); } ?>
								</div>
								<div class="admin text-center">
									<?php if ($row["admin"] === TRUE) { safe_echo("True"); } else { safe_echo("False"); } ?>
								</div>
								<div class="actions text-center">
									<button type="button" class="genric-btn small info mr-1" data-toggle="modal" data-target="#update_user_modal_<?php safe_echo($row["id"]); ?>">
										Edit
									</button>

									<form class="delete" action="admin.php" method="post">
										<input type="hidden" name="action" value="delete_user" required readonly>
										<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
										<button type="submit" class="genric-btn small danger ml-1">
											Delete
										</button>
									</form>
								</div>
							</div>

							<!-- Edit Record Modal -->
							<div id="update_user_modal_<?php safe_echo($row["id"]); ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Edit User</h3>
										</div>
										<div class="modal-body">
											<form name="update_user_<?php safe_echo($row["id"]); ?>" id="update_user_<?php safe_echo($row["id"]); ?>" action="admin.php" method="post">
												<input type="hidden" name="action" value="update_user" required readonly>
												<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
											</form>

											<div class="row">
												<div class="col-12 form-group">
													<label for="name">Name</label>
													<input type="text" class="form-control" name="name"  value="<?php safe_echo($row["name"]); ?>" form="update_user_<?php safe_echo($row["id"]); ?>" required>
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label for="loginid">Login ID</label>
													<input type="text" class="form-control" name="loginid" value="<?php safe_echo($row["loginid"]); ?>" form="update_user_<?php safe_echo($row["id"]); ?>" required>
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label for="email">Email</label>
													<input type="email" class="form-control" name="email" value="<?php safe_echo($row["email"]); ?>" form="update_user_<?php safe_echo($row["id"]); ?>" required>
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label for="loginid">Mobile </label>
													<input type="text" class="form-control" name="mobile" value="<?php safe_echo($row["mobile"]); ?>" form="update_user_<?php safe_echo($row["id"]); ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label for="bio">User Bio</label>
													<textarea class="form-control" rows="3" name="bio" form="update_user_<?php safe_echo($row["id"]); ?>"><?php safe_echo($row["bio"]); ?></textarea>
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label>Gender</label>
													<select class="default-select wide" name="gender" form="update_user_<?php safe_echo($row["id"]); ?>" required>
														<option value="N" <?php if ($row["gender"] === "N") { safe_echo("selected"); } ?>>
															Not Specified
														</option>
														<option value="M" <?php if ($row["gender"] === "M") { safe_echo("selected"); } ?>>
															Male
														</option>
														<option value="F" <?php if ($row["gender"] === "F") { safe_echo("selected"); } ?>>
															Female
														</option>
														<option value="O" <?php if ($row["gender"] === "O") { safe_echo("selected"); } ?>>
															Others
														</option>
													</select>
												</div>
											</div>
											<div class="row">
												<div class="col-6 form-group">
													<label>Suspended</label>
													<select class="default-select wide" name="suspended" form="update_user_<?php safe_echo($row["id"]); ?>" required>
														<option value="0" <?php if ($row["suspended"] === FALSE) { safe_echo("selected"); } ?>>
															False
														</option>
														<option value="1" <?php if ($row["suspended"] === TRUE) { safe_echo("selected"); } ?>>
															True
														</option>
													</select>
												</div>
												<div class="col-6 form-group">
													<label>Admin</label>
													<select class="default-select wide" name="admin" form="update_user_<?php safe_echo($row["id"]); ?>" required>
														<option value="0" <?php if ($row["admin"] === FALSE) { safe_echo("selected"); } ?>>
															False
														</option>
														<option value="1" <?php if ($row["admin"] === TRUE) { safe_echo("selected"); } ?>>
															True
														</option>
													</select>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="genric-btn success" form="update_user_<?php safe_echo($row["id"]); ?>">
												Save
											</button>
											<button type="button" class="genric-btn danger" data-dismiss="modal">
												Close
											</button>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Edit Record Modal -->
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="cat" role="tabpanel" aria-labelledby="cat-tab">
					<div class="row">
						<div class="col-12 text-center">
							<h3>Category Management</h3>
						</div>
					</div>
					<br />
					<div class="progress-table-wrap">
						<div class="progress-table cat">
							<div class="table-head">
								<div class="id text-center">
								</div>
								<div class="name">
									Create new category
								</div>
								<div class="actions text-center">
								</div>
							</div>
							<div class="table-row insert-new">
								<div class="id text-center">
									<form name="insert_category" id="insert_category" action="admin.php" method="post">
										<input type="hidden" name="action" value="insert_category" required readonly>
									</form>
								</div>
								<div class="name">
									<input type="text" class="single-input" name="name" placeholder="Category Name" form="insert_category">
								</div>
								<div class="actions text-center">
									<input type="submit" class="genric-btn success" form="insert_category" value="Create">
								</div>
							</div>
							<div class="table-row"></div>
							<div class="table-head">
								<div class="id text-center">
									ID
								</div>
								<div class="name">
									Category Name
								</div>
								<div class="actions text-center">
									Actions
								</div>
							</div>
							<?php foreach ($rows_categories as $row) { ?>
							<div class="table-row">
								<div class="id text-center">
									<?php safe_echo($row["id"]); ?>
								</div>
								<div class="name">
									<?php safe_echo($row["name"]); ?>
								</div>
								<div class="actions text-center">
									<button type="submit" class="genric-btn info mr-1" data-toggle="modal" data-target="#update_cat_modal_<?php safe_echo($row["id"]); ?>">
										Edit
									</button>

									<form class="delete" action="admin.php" method="post">
										<input type="hidden" name="action" value="delete_category" required readonly>
										<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
										<button type="submit" class="genric-btn danger ml-1">
											Delete
										</button>
									</form>
								</div>
							</div>

							<!-- Edit Record Modal -->
							<div id="update_cat_modal_<?php safe_echo($row["id"]); ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Edit Category</h3>
										</div>
										<div class="modal-body">
											<form name="update_cat_<?php safe_echo($row["id"]); ?>" id="update_cat_<?php safe_echo($row["id"]); ?>" action="admin.php" method="post">
												<input type="hidden" name="action" value="update_category" required readonly>
												<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
											</form>

											<div class="row">
												<div class="col-12 form-group">
													<label for="name">Name</label>
													<input type="text" class="form-control" name="name" value="<?php safe_echo($row["name"]); ?>" form="update_cat_<?php safe_echo($row["id"]); ?>" required>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="genric-btn success" form="update_cat_<?php safe_echo($row["id"]); ?>">
												Save
											</button>
											<button type="button" class="genric-btn danger" data-dismiss="modal">
												Close
											</button>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Edit Record Modal -->
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="loc" role="tabpanel" aria-labelledby="loc-tab">
					<div class="row">
						<div class="col-12 text-center">
							<h3>Location Management</h3>
						</div>
					</div>
					<br />
					<div class="progress-table-wrap">
						<div class="progress-table loc">
							<div class="table-head">
								<div class="id text-center">
								</div>
								<div class="name">
									Create new location
								</div>
								<div class="actions text-center">
								</div>
							</div>
							<div class="table-row insert-new">
								<div class="id text-center">
									<form name="insert_loc" id="insert_loc" action="admin.php" method="post">
										<input type="hidden" name="action" value="insert_location" required readonly>
									</form>
								</div>
								<div class="code">
									<input type="text" class="single-input" name="stn_code" placeholder="Code" form="insert_loc">
								</div>
								<div class="line">
									<input type="text" class="single-input" name="stn_line" placeholder="MRT Line" form="insert_loc">
								</div>
								<div class="name">
									<input type="text" class="single-input" name="stn_name" placeholder="Name" form="insert_loc" required>
								</div>
								<div class="actions text-center">
									<input type="submit" class="genric-btn success" form="insert_loc" value="Create">
								</div>
							</div>
							<div class="table-row"></div>
							<div class="table-head">
								<div class="id text-center">
									ID
								</div>
								<div class="code text-center">
									MRT Code
								</div>
								<div class="line">
									MRT Line
								</div>
								<div class="name">
									Location Name
								</div>
								<div class="actions text-center">
									Actions
								</div>
							</div>
							<?php foreach ($rows_locations as $row) { ?>
							<div class="table-row">
								<div class="id text-center">
									<?php safe_echo($row["id"]); ?>
								</div>
								<div class="code text-center">
									<?php safe_echo($row["code"]); ?>
								</div>
								<div class="line">
									<?php safe_echo($row["line"]); ?>
								</div>
								<div class="name">
									<?php safe_echo($row["name"]); ?>
								</div>
								<div class="actions text-center">
									<button type="submit" class="genric-btn info mr-1" data-toggle="modal" data-target="#update_loc_modal_<?php safe_echo($row["id"]); ?>">
										Edit
									</button>

									<form class="delete" action="admin.php" method="post">
										<input type="hidden" name="action" value="delete_location" required readonly>
										<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
										<button type="submit" class="genric-btn danger ml-1">
											Delete
										</button>
									</form>
								</div>
							</div>

							<!-- Edit Record Modal -->
							<div id="update_loc_modal_<?php safe_echo($row["id"]); ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Edit Location</h3>
										</div>
										<div class="modal-body">
											<form name="update_cat_<?php safe_echo($row["id"]); ?>" id="update_loc_<?php safe_echo($row["id"]); ?>" action="admin.php" method="post">
												<input type="hidden" name="action" value="update_location" required readonly>
												<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
											</form>

											<div class="row">
												<div class="col-12 form-group">
													<label for="name">MRT Code (Optional)</label>
													<input type="text" class="form-control" name="stn_code" value="<?php safe_echo($row["code"]); ?>" form="update_loc_<?php safe_echo($row["id"]); ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label for="name">MRT Line (Optional)</label>
													<input type="text" class="form-control" name="stn_line" value="<?php safe_echo($row["line"]); ?>" form="update_loc_<?php safe_echo($row["id"]); ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-12 form-group">
													<label for="name">Name</label>
													<input type="text" class="form-control" name="stn_name" value="<?php safe_echo($row["name"]); ?>" form="update_loc_<?php safe_echo($row["id"]); ?>">
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="genric-btn success" form="update_loc_<?php safe_echo($row["id"]); ?>">
												Save
											</button>
											<button type="button" class="genric-btn danger" data-dismiss="modal">
												Close
											</button>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Edit Record Modal -->
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End of Admin Dashboard -->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>

	<script>
		$(document).ready(function() {
			$(".delete").on("submit", function(e) {
				const result = confirm("Are you sure you want to delete this record?");
				
				if (result === true) {
					return true;
				} else {
					e.preventDefault();
					return false;
				}
			});

			<?php if ($response_message !== NULL) { ?>
			const resp = "<?php safe_echo($response_message); ?>";
			<?php if ($valid_response === TRUE) { ?>
			notify(resp, "info");
			<?php } else { ?>
			notify(resp, "danger");
			<?php }} ?>
		});
	</script>
	
</body>
</html>