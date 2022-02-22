<?php
require_once "dbconfig.php";
// Check userlogin
if(!isset($_SESSION['loggedin']) && (!isset($_POST['selectedApplication']) || !isset($_POST['selectedLang'])))
{
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Options</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
	crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container user-opts">
		<div class="row">
			<div class="col-sm-9 col-md-9 col-lg-8 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col text-left">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
					<div class="col text-right">
						<a href="<?= $base_url."logout.php"?>" class="btn btn-outline-secondary">Logout</a>
					</div>
				</section>
				<section class="row justify-content-center pt-5 page-title">
					<div class="col-5 text-center">
						<h1 class="text-uppercase">Dashboard</h1>
					</div>
				</section>
				<section class="row justify-content-center pt-4 page-content">
					<div class="col-12 text-center">
						<h2 class="font-weight-bold title-underline">Select Option</h2>
						<p class="font-italic pt-4 pb-3 subtitle">-Please select one option at a time-</p>
					</div>
					<div class="col-5 text-center">
						<div class="ans-radio-uopt">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-outline-secondary form-check-label waves-effect waves-light">
									<input class="form-check-input" type="radio" autocomplete="off">
									<a class="text-decoration-none" href="<?= $base_url."downloadsystemMessages.php?application=".$_POST['selectedApplication']."&lang=".$_POST['selectedLang']?>">Download System Messages</a>
								</label>
								<label class="btn btn-outline-secondary form-check-label waves-effect waves-light">
									<input class="form-check-input" type="radio" autocomplete="off">
									<a class="text-decoration-none" href="<?= $base_url."editSystemMessages.php?application=".$_POST['selectedApplication']."&lang=".$_POST['selectedLang']?>">Edit System Messages</a>
								</label>
								<label class="btn btn-outline-secondary form-check-label waves-effect waves-light active">
									<input class="form-check-input" type="radio" autocomplete="off">
									<a class="text-decoration-none" href="<?= $base_url."downloadResourceMessages.php?application=".$_POST['selectedApplication']."&lang=".$_POST['selectedLang']?>">Download Resource Files</a>
								</label>
								<label class="btn btn-outline-secondary form-check-label waves-effect waves-light active">
									<input class="form-check-input" type="radio" autocomplete="off"><a class="text-decoration-none" href="<?= $base_url."resourceFiles.php?application=".$_POST['selectedApplication']."&lang=".$_POST['selectedLang']?>">Edit Resource Files</a>
								</label>
							</div>
						</div>
					</div>
				</section>
				<section class="prev-nxt text-center pt-2">
					<div class="btn-group" role="group" aria-label="Prev Nxet">
						<a class="btn btn-secondary" href="<?= $base_url."selectLanguage.php"?>" role="button">Previous</a>
				  		<!-- <a class="btn btn-secondary" href="userOptions.html" role="button">Next</a> -->
					</div>
				</section>
			</div>
		</div>
	</div>
</body>
</html>