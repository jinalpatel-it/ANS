<?php
require_once "dbconfig.php";
// Check userlogin
if (!isset($_SESSION['loggedin'])) {
	header("Location:index.php");
}
// Get System Message By Id
$sql = "SELECT * FROM " . $SystemMessage_Table . " LEFT JOIN " . $Translation_Table . " ON $Translation_Table.sys_message_id = $SystemMessage_Table.id WHERE $SystemMessage_Table.id = '" . $_GET['sid'] . "'";

$sqlGetTranslate = "SELECT * FROM " . $Translation_Table . " WHERE sys_message_id = ".$_GET['sid']." AND language_id = ".$_GET['lang'];
$systemMessages = mysqli_query($con, $sql);
$translation = mysqli_query($con, $sqlGetTranslate);
if (mysqli_num_rows($systemMessages) == 0) {
	header("Location:editSystemMessages.php");
} else {
	$getRecords = mysqli_fetch_all($systemMessages, MYSQLI_ASSOC);
	if(mysqli_num_rows($translation) == 0)
	{
		$sts = false;
	}
	else
	{
		$sts = true;
		$transalations = mysqli_fetch_all($translation, MYSQLI_ASSOC);
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update System Messages</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</head>

<body>
	<div class="container update-sys-msg">
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
						<h2 class="font-weight-bold title-underline">Translate System Messages</h2>
					</div>
					<div class="row justify-content-center py-5 mt-3">
						<div class="col-5">
							<p class="font-weight-bold text-center text-uppercase py-1 col-title">Original Base Message</p>
							<form class="updatemsg p-3 mt-5">
								
								<div class="form-group row">
									<label for="statictitle" class="col-sm-2 col-form-label">Title:</label>
									<div class="col-sm-10">
										<input type="text" readonly class="form-control-plaintext" id="statictitle" value="<?=  $getRecords[0]['Title']; ?>">
									</div>
								</div>
								<div class="form-group row">
									<label for="staticmsg" class="col-sm-2 col-form-label">Message:</label>
									<div class="col-sm-10">
										<textarea class="form-control" id="staticmsg" readonly rows="3"><?= $getRecords[0]['Message']; ?></textarea>
									</div>
								</div>
							</form>
						</div>
						
						<div class="col-5">
							<p class="font-weight-bold text-center text-uppercase py-1 col-title">Selected Edited Message</p>
							<div class="updatemsg p-3 mt-5">
								
								<div class="form-group row">
									<label for="statictitle1" class="col-sm-2 col-form-label">Title:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control-plaintext" readonly id="Title" value="<?= $getRecords[0]['Title']; ?>">
									</div>
								</div>
							
								<?php if($sts == true): ?>
								<div class="form-group row">
									<label for="staticmsg1" class="col-sm-2 col-form-label">Message:</label>
									<div class="col-sm-10">
										<textarea class="form-control" id="Message" rows="3"><?= $transalations[0]['translation_msg']; ?></textarea>
									</div>
								</div>
								<?php else: ?>
									<div class="form-group row">
									<label for="staticmsg1" class="col-sm-2 col-form-label">Message:</label>
									<div class="col-sm-10">
										<textarea class="form-control" id="Message" rows="3"></textarea>
									</div>
								</div>
								<?php endif; ?>
								<div class="form-group row justify-content-end px-3">
									<button class="btn btn-outline-secondary text-center" id="updateSys">Update</button>									
								</div>
								<div id="Msg" class="mt-5"></div>
							</div>
						</div>
					</div>
				</section>
				<section class="prev-nxt text-center pt-2">
					<div class="btn-group" role="group" aria-label="Prev Nxet">
						<?php if(isset($_GET['resource']) && $_GET['resource'] == "true") { ?>
							<a class="btn btn-secondary" href="<?= $base_url . "editresourceFiles.php?application=".$getRecords[0]['application_id']."&lang=". $_GET['lang']."&file=".$getRecords[0]['resource_id']; ?>" role="button">All Resource Messages</a>
						<?php } else { ?>
							<a class="btn btn-secondary" href="<?= $base_url . "editSystemMessages.php?application=".$getRecords[0]['application_id']."&lang=". $_GET['lang']."&file=".$getRecords[0]['resource_id']; ?>" role="button">All System Messages</a>
							<?php } ?>
					</div>
				</section>
			</div>
		</div>
	</div>
</body>

</html>
<script>
	$(function() {

		$(':input').on('propertychange input', function () {
			$(this).css("border-color", "");
		});


		$("#updateSys").on("click", function() {
			var transSts = "<?php echo $sts; ?>";
			if (!$("#Title").val()) {
				$("#Title").css("border-color", "red");
				
			} else if (!$("#Message").val()) {
				
				$("#Message").css("border-color", "red");
			}
			else
			{
				$.ajax({
				type: "POST",
				url: "<?php echo $base_url."model/sqlCall.php"; ?>",
				data: {					
					Message:$("#Message").val(),
					SysId:<?php echo $_GET['sid']; ?>,
					Lang:<?php echo $_GET['lang']; ?>,
					updateSystemMessage: "TRUE",
					isNew:transSts

				},
				dataType: "json",
				success: function (response) {
					if(response.status)
					{
						$("#Msg").html(response.response);
					}
				}
			});
			}
			
		});

	});
</script>