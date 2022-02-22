<?php
require_once "dbconfig.php";
// Check userlogin
if (!isset($_SESSION['loggedin'])) {
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Select Application</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container sel-application">
		<div class="row">
			<div class="col-sm-9 col-md-9 col-lg-8 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col text-left">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
					<div class="col text-right">
						<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">
							New Application
						</button>
						<a href="<?= $base_url . "logout.php" ?>" class="btn btn-outline-secondary">Logout</a>
					</div>
				</section>
				<section class="row justify-content-center pt-5 page-title">
					<div class="col-5 text-center">
						<h1 class="text-uppercase">Dashboard</h1>
					</div>
				</section>
				<form action="<?=  $base_url . "selectLanguage.php"?>" method="post">
				<section class="row justify-content-center pt-4 page-content">
					<div class="col-12 text-center">
						<h2 class="font-weight-bold title-underline">Select Application</h2>
						<p class="font-italic pt-4 pb-4 subtitle">-Please select an application from the dropdown list below-</p>
						<select class="form-select font-weight-bold" name="selectedApplication" id="selectedApplication" aria-label="Default select example" required>
							
						</select>
					</div>
				</section>
				<section class="prev-nxt text-center mt-4 pt-5">
					<div class="btn-group" role="group" aria-label="Prev Nxet">
						<!-- <a class="btn btn-secondary" href="#" role="button">Previous</a> -->
						<input class="btn btn-secondary" type="submit"  role="submit" value="Next">
					</div>
				</section>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Add New Application</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
					  <label for="">Application Name</label>
					  <input type="text" class="form-control" name="application" id="application" aria-describedby="helpId" placeholder="Enter Application Name">
					  <small id="helpId" class="form-text text-muted d-none"></small>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="save_application">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>
</body>

</html>


<script>
	

	$(document).ready(function () {
		getLangs();
		$("#save_application").on('click', function() {
				if(!$('#application').val()) {
					$('#application').addClass('is-invalid');
					$('#application').removeClass('is-valid');
				}
				else
				{
					$('#application').removeClass('is-invalid');
					$('#application').addClass('is-valid');

					$.ajax({
						type: "POST",
						url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
						data: {
							newApplication:"TRUE",
							name:$('#application').val()
						},
						dataType: "json",
						success: function (response) {
							console.log(response.status);
							if(!response.status)
							{
								
								$("#helpId").html(response.response);
								$("#application").removeClass("is-valid").addClass("is-invalid");
								$("#helpId").removeClass("d-none");
								
							}
							else
							{
								$('#application').val('');
								$("#helpId").html('Application Saved');
								$("#application").removeClass("is-invalid").removeClass("is-valid");
								$("#helpId").removeClass("d-none");
								setTimeout(function () {
									getLangs();
									$("#myModal").modal('hide');
                                },2000);
							}
						}
					});
				}
		});


		function getLangs()
		{
			$.ajax({
				type: "POST",
				url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
				data: {
					getApplication:"TRUE"
				},
				dataType: "json",
				success: function (response) {
					if(!response.status)
					{
						alert("You don't have application please add");
					}
					else
					{
							$("#selectedApplication").html(response.data);
					}
				}
			});
		}
	});
</script>