<?php
ob_start();
include_once "dbconfig.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
	header("Location:selectApplication.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
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
	<div class="container login">
		<div class="row">
			<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
					<form class="form-signin" method="POST">
					<div class="col text-right">
						<div class="dropdown language">
							<select class="form-select font-weight-bold" id="selectedLang" name="selectedLang" aria-label="Default select example">

							</select>
						</div>
					</div>
					<!-- <div class="col text-right">
						<div class="dropdown language">
							<button class="btn dropdown-toggle text-uppercase" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="flag-icon flag-icon-us"></span> En
							</button>
							<div class="dropdown-menu dropdown-menu-right text-right language text-uppercase">
								<a class="dropdown-item" href="#fr"><span class="flag-icon flag-icon-us"></span>En</a>
								<a class="dropdown-item" href="#fr"><span class="flag-icon flag-icon-fr"> </span>Fr</a>
								<a class="dropdown-item" href="#it"><span class="flag-icon flag-icon-it"> </span>It</a>
								<a class="dropdown-item" href="#ru"><span class="flag-icon flag-icon-ru"> </span>Ru</a>
							</div>
						</div>
					</div> -->
				</section>
				<section class="card card-signin my-3">
					<div class="card-body">
						<h5 class="card-title text-center text-uppercase font-weight-bold text-underline">Login</h5>
						<div class="info text-center my-4">
							<p>Welcome Back!</p>
							<p>Login with your Username and Password to access the Translation system.</p>
							<a class="underlineHover pb-3" href="accountRecovery.php">Did you Forgot your Password?</a>
						</div>

						
							<div class="form-label-group">
								<input type="text" id="inputUname" name="username" class="form-control" placeholder="Your Username" required autofocus>
								<label for="inputUname">Your Username</label>
							</div>
							<input type="hidden" name="flag" id="flags">
							<div class="form-label-group">
								<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
								<label for="inputPassword">Password</label>
							</div>

							<div class="custom-control custom-checkbox text-center mb-4">
								<input type="checkbox" class="custom-control-input" id="customCheck1">
								<label class="custom-control-label" for="customCheck1">Remember me</label>
							</div>
							<button class="btn btn-lg btn-secondary text-center text-uppercase" type="submit" name="login">Login</button>
							<div class="form-label-group text-center">
								<a class="underlineHover pb-3" href="register.php">Sign Up</a>
							</div>
							<div id="errorMsg" class="mt-5"></div>
						</form>
					</div>
				</section>
			</div>
		</div>
	</div>
</body>
<script>
	$(function() {
		getLangauge();
		// $("#flags").val("En");
		// $('.dropdown-menu a').click(function() {
		// 	$("#dropdownMenuButton").html($(this).html());
		// 	$("#flags").val($.trim($(this).text()));
		// });

		function getLangauge() {
			$.ajax({
				type: "POST",
				url: "<?php echo $base_url . "model/sqlCall.php"; ?>",
				data: {
					getLang: "TRUE"
				},
				dataType: "json",
				success: function(response) {
					if (!response.status) {
						alert("You don't have language please add");
					} else {
						$("#selectedLang").html(response.data);
					}
				}
			});
		}
	});
</script>

</html>



<?php

if (isset($_POST['login'])) {
	if (!isset($_POST['username'], $_POST['password'])) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
	} else {
		$sql = "SELECT id, name, user_name,is_admin FROM " . $Login_Table . " WHERE user_name = '" . $_POST['username'] . "' AND user_password = '" . md5($_POST['password']) . "'";

		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($result)) {

				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $row["id"];
				$_SESSION['lang'] = $_POST['selectedLang'];
				$_SESSION['isAdmin'] = $row["is_admin"];
				header("Location:selectApplication.php");
			}
		} else {
?>
			<script>
				$("#errorMsg").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>				<strong>Unknow User!</strong> You have enter wrong information try again......</div>')
			</script>

<?php

		}
	}
}

?>