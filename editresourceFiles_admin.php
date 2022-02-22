<?php
require_once "dbconfig.php";
// Check userlogin
if(!isset($_SESSION['loggedin']))
{
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Resource Files - Admin</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
	crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {

			$('#dtBasicExample').DataTable({
				//"pagingType": "numbers",
				"searching": false,
				"paging":   false,
        		"ordering": false,
        		"info":     false
				//"dom": '<"top"i>rt<"bottom"flp><"clear">'
			});
			$('.dataTables_length').addClass('bs-select');
		});
	</script>
</head>
<body>
	<div class="container edit-res-files admin">
		<div class="row">
			<div class="col-sm-9 col-md-9 col-lg-8 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col text-left">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
					<div class="col text-right">
						<a href="resourceFiles_admin.html" class="btn btn-secondary">All RESX Files</a>
						<a href="<?= $base_url."logout.php"?>" class="btn btn-outline-secondary">Logout</a>
					</div>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 mx-auto">
				<section class="py-4 page-content">
					<div class="row justify-content-center">
						<h2 class="font-weight-bold title-underline">Translate Web Page: Default.aspx</h2>
					</div>
				</section>
				<section>
					<div class="row justify-content-center pt-4">
						<div class="col-4 text-center ">
							<div class="mb-3">
							  <label for="formFile" class="form-label">Select File</label>
							  <input class="form-control" type="file" id="formFile">
							</div>
							<div class="mb-3">
								<a class="btn btn-secondary import-btn" href="" role="button">Import Web Page</a>
							</div>
						</div>
					</div>
				</section>
				<section>
					<div class="row">
						<div class="col-12 pt-4">
							<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th class="th-sm">Key</th>
										<th class="th-sm">English</th>
										<th class="th-sm">Indonesian</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="del-icon"><i class="far fa-trash-alt"></i> Label15Resouce1.Text</td>
										<td>For Further Information, please contact:</td>
										<td>Untuk informasi lebih lanjut, silakhan hubungi;</td>
									</tr>
									<tr>
										<td class="del-icon"><i class="far fa-trash-alt"></i> Label15Resouce1.Text</td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</section>
				<section class="prev-nxt text-center pt-5">
					<div class="btn-group" role="group" aria-label="Prev Nxet">
						<a class="btn btn-secondary" href="" role="button">Save Edited Row(s)</a>
					</div>
				</section>
			</div>
		</div>
	</div>
</body>
</html>