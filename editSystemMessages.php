<?php
require_once "dbconfig.php";
// Check userlogin
if (!isset($_SESSION['loggedin'])) {
	header("Location:index.php");
}
ob_start();
// Get Lang Name
$sqlGetLang = mysqli_query($con, "SELECT * FROM " . $lang_Table . " WHERE id  = '" . $_GET['lang'] . "'");
if (mysqli_num_rows($sqlGetLang) == 1) {
	$language = mysqli_fetch_assoc($sqlGetLang);
} else {
	header("Location:index.php");
}

// Get All System Messages
if (isset($_GET['module']) && $_GET['module'] > 0) {
	$sql = "SELECT $SystemMessage_Table.*,$Translation_Table.*,$SystemMessage_Table.id as sysid FROM " . $SystemMessage_Table . " LEFT JOIN " . $Translation_Table . " ON $Translation_Table.sys_message_id = $SystemMessage_Table.id WHERE application_id = '" . $_GET['application'] . "' AND module_id = '" . $_GET['module'] . "'";
} else {
	$sql = "SELECT $SystemMessage_Table.*,$Translation_Table.*,$SystemMessage_Table.id as sysid FROM " . $SystemMessage_Table . " LEFT JOIN " . $Translation_Table . " ON $Translation_Table.sys_message_id = $SystemMessage_Table.id WHERE application_id = '" . $_GET['application'] . "'";
}

$systemMessages = mysqli_query($con, $sql);


// Get Modules
$Modules = "SELECT * FROM $Modules_Table WHERE application_id = " . $_GET['application'];
$systemModules = mysqli_query($con, $Modules);

$systemModules1 = mysqli_query($con, $Modules);

?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit System Messages</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<style>
		i.far {
			display: none;
		}

		tr:hover i.far {
			display: inline-block;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#dtBasicExample').DataTable({
				"pagingType": "numbers",
				"searching": false,
				//"dom": '<"top"i>rt<"bottom"flp><"clear">'
			});
			$('.dataTables_length').addClass('bs-select');
		});
	</script>
</head>

<body>
	<div class="container edit-sys-msg">
		<div class="row">
			<div class="col-sm-9 col-md-9 col-lg-8 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col text-left">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
					<div class="col text-right">
						<a href="<?= $base_url . "selectApplication.php" ?>" class="btn btn-secondary">Dashboard</a>
						<a href="<?= $base_url . "logout.php" ?>" class="btn btn-outline-secondary">Logout</a>
					</div>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 mx-auto">
				<section class="pt-4 page-content">
					<div class="row justify-content-center">
						<h2 class="font-weight-bold title-underline">System Messages</h2>
					</div>
				</section>
				<section>

					<div class="row justify-content-center" style="margin-top: 25px;">
						<?php if ($_SESSION['isAdmin'] == 1){ ?>
						<div class="col-4 text-center ">
							<form action="" method="post" enctype="multipart/form-data">
								<div class="mb-3">
									<input class="form-control" type="file" name="file" id="formFile" required>
								</div>
								<div class="mb-3">
									<input type="submit" name="importSubmit" class="btn btn-secondary import-btn" value="Import System Messages">
								</div>
							</form>
							<div class="mt-5 mb-3">
								<a href="#" data-toggle="modal" data-target="#myModal" style="color:#020202;"><i class="fa fa-plus" style="color: #783daf;"></i> Add System Messages</a>
							</div>
						</div>
						<?php } ?>


						<div id="myModal" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Add System Messages</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<form>
											<table width="100%">
												<tr>
													<td><label>Title:</label></td>
													<td><textarea rows="2" name="Title" id="Title" cols="42"></textarea></td>
												</tr>
												<tr>
													<td><label>Message:</label></td>
													<td><textarea rows="4" name="Message" id="Message" cols="42"></textarea></td>
												</tr>
												<tr>
													<td><label>Module:</label></td>
													<td><select class="form-select font-weight-bold" name="module_id" id="module_id" aria-label="Default select example">
															<option value="">Select Module</option>
															<?php while ($row = mysqli_fetch_assoc($systemModules1)) : ?>
																<option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
															<?php endwhile; ?>
														</select></td>
												</tr>
											</table>
											<button type="button" style="margin-left:75px;" class="save">Save</button>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>

						<div id="addModule" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Add Module</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<form>
											<table width="100%">
												<tr>
													<td><label>Module:</label></td>
													<td><input type="text" name="moduleName" id="moduleName"/></td>
												</tr>
											</table>
											<button type="button" style="margin-left:75px;" class="addModule">Save</button>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-6 justify-content-left pt-4">
							<select class="form-select font-weight-bold" id="modelChnage" aria-label="Default select example">
								
								<option value="0" <?= (isset($_GET['module']) && $_GET['module'] == 0) ? "Selected" : ""; ?>>All Messages</option>
								<?php while ($row = mysqli_fetch_assoc($systemModules)) : ?>
									<option value="<?= $row['id']; ?>" <?= (isset($_GET['module']) && $_GET['module'] == $row['id']) ? "Selected" : ""; ?>><?= $row['name']; ?></option>
								<?php endwhile; ?>
							</select>

							<?php if ($_SESSION['isAdmin'] == 1){ ?>
								<a href="#" data-toggle="modal" data-target="#addModule" style="color:#020202;"><i class="fa fa-plus" style="color: #783daf;"></i> Add Module</a>
							<?php } ?>
						</div>
						<div class="col-6 text-right pt-4 text-uppercase">
							<!-- <lf<t>ip> -->
							<span class="font-weight-bold count"><?php echo mysqli_num_rows($systemMessages); ?></span> Records
						</div>
						<div class="col-12 text-center pt-4">
							<h3 class="font-weight-bold">| English(EN) - <?php echo $language['name']; ?>(<?= strtoupper($language['shortname']) ?>)|</h3>
							<div id="Msg" class="mt-5"></div>
						</div>
						<div class="col-12 pt-4">
							<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead>
									<tr>
										<?php if ($_SESSION['isAdmin'] == 1) : ?>
											<th class="th-sm"></th>
										<?php endif; ?>
										<th class="th-sm">Title</th>
										<th class="th-sm">Messages</th>
										<th class="th-sm"><?php echo $language['name']; ?></th>

									</tr>
								</thead>
								<tbody>
									<?php if (mysqli_num_rows($systemMessages) > 0) : ?>
										<?php while ($row = mysqli_fetch_assoc($systemMessages)) : ?>
											<?php if ($row['language_id'] == $_GET['lang']) : $lantrans = $row['translation_msg'];
											else : $lantrans = null;
											endif;  ?>
											<tr>
												<?php if ($_SESSION['isAdmin'] == 1) : ?>
													<td class="del-icon"><i class="far fa-trash-alt delSys" id="<?= $row['sysid']; ?>"></i></td>

												<?php endif; ?>

												<td id="<?= $row['sysid']; ?>" class="update"><?= $row['Title']; ?></td>
												<td id="<?= $row['sysid']; ?>" class="update"><?= $row['Message']; ?></td>
												<td id="<?= $row['sysid']; ?>" class="update"><?= $lantrans; ?></td>
											</tr>
										<?php endwhile; ?>
									<?php else : ?>
										<tr>
											<td colspan="3">No Records Found</td>

										</tr>
									<?php endif; ?>

								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</body>

</html>
<?php
if (isset($_POST['importSubmit'])) {

	// Allowed mime types
	$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

	// Validate whether selected file is a CSV file
	if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

		// If the file is uploaded
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {

			// Open uploaded CSV file with read-only mode
			$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

			// Skip the first line
			fgetcsv($csvFile);

			// Parse data from CSV file line by line
			while (($line = fgetcsv($csvFile)) !== FALSE) {
				// Get row data
				$title   = $line[0];
				$message  = $line[1];
				$application   = (isset($_GET['application']) && $_GET['application'] != 0) ? $_GET['application'] : 0;
				$module  = (isset($_GET['module']) && $_GET['module'] != 0) ? $_GET['module'] : 0;

				// Check whether member already exists in the database with the same email


				$sql = "INSERT INTO " . $SystemMessage_Table . " (  Title,Message,application_id,module_id) VALUES ('" . $title . "', '" . $message . "','" . $application . "','" . $module . "')";
				$result = mysqli_query($con, $sql);
			}
			// Close opened CSV file
			fclose($csvFile);
			//header("Refresh:0");
			
			//echo '<script> location.reload()</script>';
			//echo '<meta http-equiv="refresh" content="2;url='.$base_url . "editSystemMessages.php?application=".$_GET['application']."&lang=".$_GET['lang'].' />';
			header("location:".$base_url . "redirect.php?application=".$_GET['application']."&lang=".$_GET['lang']);
			exit;
		}
	}
}
?>
<script>
	var url = "<?php echo $base_url . "updateSystemMessages.php"; ?>";
	$(document).ready(function() {
		$(".update").on("click", function() {
			var id = $(this).attr('id');
			window.location.href = url + '?sid=' + id + "&lang=<?php echo  $_GET['lang']; ?>";
		});

		$("#modelChnage").on("change", function() {
			var id = $(this).val();
			if (id >= 0) {
				if (window.location.href.indexOf("module") > -1) {
					url = window.location.href.split('&module=')[0];
					window.location.href = url + '&module=' + id;

				} else {
					window.location.href = window.location.href + '&module=' + id;

				}
			}

		});

		$(".save").on("click", function() {
			$.ajax({
				type: "POST",
				url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
				data: {
					Title: $("#Title").val(),
					Message: $("#Message").val(),
					Application: <?php echo $_GET['application']; ?>,
					module_id: $("#module_id").val(),
					addSystemMessage: "TRUE"
				},
				dataType: "json",
				success: function(response) {
					if (response.status) {
						$("#Msg").html(response.response);
						setTimeout(function() {
							location.reload(true);
						}, 500);
					}
				}
			});
			return false;
		});

		$(".addModule").on("click", function() {
			$.ajax({
				type: "POST",
				url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
				data: {
					moduleName: $("#moduleName").val(),
					Application: <?php echo $_GET['application']; ?>,
					addModule: "TRUE"
				},
				dataType: "json",
				success: function(response) {
					if (response.status) {
						$("#Msg").html(response.response);
						setTimeout(function() {
							location.reload(true);
						}, 500);
					}
				}
			});
			return false;
		});

		

		$(".delSys").on("click", function() {

			var id = $(this).attr('id');
			if (confirm("Are you sure?")) {
				$.ajax({
					type: "POST",
					url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
					data: {
						SysId: id,
						deleteSystemMessage: "TRUE"
					},
					dataType: "json",
					success: function(response) {
						if (response.status) {
							$("#Msg").html(response.response);
							setTimeout(function() {
								location.reload(true);
							}, 500);
						}
					}
				});
			}
			return false;

		});
	});
</script>