<?php
require_once "dbconfig.php";
// Check userlogin
if (!isset($_SESSION['loggedin'])) {
	header("Location:index.php");
}
// $dir = "resourceFiles";
// $res = array_diff(scandir($dir), array('.', '..'));

$res = mysqli_query($con,"SELECT * FROM $resources_Table");
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Resource Files</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</head>

<body>
	<div class="container res-files">
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
						<h2 class="font-weight-bold title-underline">Resource Files</h2>
					</div>
					<?php if ($_SESSION['isAdmin'] == 1) : ?>
						<div class="row justify-content-center pt-4">
							<div class="col-4 text-center ">
								<div class="my-2">
									<a data-toggle="modal" data-target="#myModal" href="#"><i class="fas fa-plus-circle"></i> Add Web Pages</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="row justify-content-center">
						<div class="col-lg-12">
							<p class="font-italic pt-4 pb-3 subtitle text-center">-Please select a resource file from the list below to translate a web page-</p>
						</div>
						<div class="col-lg-12">
							<ul class="text-center no-disc">
								<?php while ($row = mysqli_fetch_assoc($res)) { ?>
									<?php if ($_SESSION['isAdmin'] == 1) : ?>
										<li><a href="<?= $base_url . "editresourceFiles.php?application=".$_GET['application']."&lang=".$_GET['lang']."&file=" . $row['id'] ?>"><?= $row['title']; ?></a><i class="fas fa-edit update" data-id="<?= $row['id']; ?>" data-title="<?= $row['title']; ?>"style="margin-left: 1em;" ></i></li>
									<?php else : ?>
										<li><a href="<?= $base_url . "editresourceFiles.php?application=".$_GET['application']."&lang=".$_GET['lang']."&file=" . $row['id'] ?>"><?= $row['title']; ?></a></li>
									<?php endif; ?>
								<?php } ?>


							</ul>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add New WebPage</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">

					<table width="100%">
						<tr>
							<td><label>Title:</label></td>
							<td><input type="text" name="Title" class="form-control" id="sTitle"></textarea></td>
						</tr>

					</table>

					<div id="stsmsg"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="savefile">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>


	<div id="updateModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Webpage Name</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">

					<table width="100%">
						<tr>
							<td><label>Title:</label></td>
							<td><input type="text" name="Title" class="form-control" id="uTitle"></textarea></td>
							<input type="hidden"  id="uid">
						</tr>

					</table>

					<div id="ustsmsg"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="updatefile">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>


</body>

</html>
<script>
	$(document).ready(function() {
		$("#savefile").on("click", function() {
			if (!$("#sTitle").val()) {
				$("#sTitle").css("border-color", "red");
			} else {
				$("#sTitle").css("border-color", "green");
				$.ajax({
					type: "POST",
					url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
					data: {
						addFile: "TRUE",
						title: $("#sTitle").val()
					},
					dataType: "json",
					success: function(response) {
						$("#stsmsg").html(response.response);
						setTimeout(function() {
							// getLangauge();
							location.reload();
						}, 2000);
					}
				});
			}
		});

		$(".update").on("click", function () {
			$("#uTitle").css("border-color", "black");
			$("#updateModal").modal("show");
			$("#uTitle").val($(this).data("title"));
			$("#uid").val($(this).data("id"));
		});

		$("#updatefile").on("click", function() {
			if (!$("#uTitle").val()) {
				$("#uTitle").css("border-color", "red");
			} else {
				$("#uTitle").css("border-color", "green");

				
				$.ajax({
					type: "POST",
					url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
					data: {
						updateFileName: "TRUE",
						title: $("#uTitle").val(),
						id: $("#uid").val()
					},
					dataType: "json",
					success: function(response) {
						$("#ustsmsg").html(response.response);
						setTimeout(function() {
							// getLangauge();
							location.reload();
						}, 2000);
					}
				});
			}
		});

	});
</script>