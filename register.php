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
	<title>Register</title>
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
				</section>
				<section class="card card-signin my-3">
					<div class="card-body">
						<h5 class="card-title text-center text-uppercase font-weight-bold text-underline">Register</h5>
						<div class="info text-center my-4">
							<p>Welcome!</p>
							<p>Register with your Username and Password to access the Translation system.</p>
							<a class="underlineHover pb-3" href="accountRecovery.php">Did you Forgot your Password?</a>
						</div>

                            <div class="form-label-group">
								<input type="text" id="inputname" name="name" class="form-control" placeholder="Name" required>
								<label for="inputname">Name</label>
							</div>
							<div class="form-label-group">
								<input type="text" id="inputUname" name="username" class="form-control" placeholder="Username" required>
								<label for="inputUname">Username</label>
							</div>
                            <div class="form-label-group">
								<input type="text" id="inputEmail" name="email" class="form-control" placeholder="Email" required>
								<label for="inputEmail">Email</label>
							</div>
							<div class="form-label-group">
								<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
								<label for="inputPassword">Password</label>
							</div>
                            <div class="form-label-group">
								<input type="password" id="inputPassword2" name="password2" class="form-control" placeholder="Re-enter Password" required>
								<label for="inputPassword2">Re-enter Password</label>
							</div>
							<button class="btn btn-lg btn-secondary text-center text-uppercase" type="submit" name="register">Sign Up</button>
							<div class="form-label-group text-center">
								<a class="underlineHover pb-3" href="index.php">Login</a>
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
		
        $('#inputPassword, #inputPassword2').on('keyup', function () {
            if( $('#inputPassword2').val()!=""){
                if (($('#inputPassword').val() != $('#inputPassword2').val())){
                    $('#errorMsg').html('Passwords not Matching');
                }else{
                    $('#errorMsg').html('');
                }
            }
        });
	});
</script>

</html>



<?php

if (isset($_POST['register'])) {
    
	if (!isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'])) {
		// Could not get the data that should have been sent.
		exit('Please fill all fields!');
	} else {
		$sql = "SELECT id, name, user_name,is_admin FROM " . $Login_Table . " WHERE user_name = '" . $_POST['username'] . "'";

		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) > 0) {
            exit('User with same username already exists');
        }else{
            $sql = "INSERT INTO " . $Login_Table . " (name,user_name,user_password,user_email,forgot_id) VALUES ('" . $_POST['name'] . "', '" . $_POST['username'] . "','" . md5($_POST['password']) . "','" . $_POST['email'] . "','')";
            $result = mysqli_query($con, $sql);
            if($result){
                // output data of each row
                $sql = "SELECT id, name, user_name,is_admin FROM " . $Login_Table . " WHERE user_name = '" . $_POST['username'] . "'";

		        $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {

                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['username'];
                    $_SESSION['id'] = $row["id"];
                    $_SESSION['lang'] = $_POST['selectedLang'];
                    $_SESSION['isAdmin'] = $row["is_admin"];
                    header("Location:selectApplication.php");
                }
            }
        }
	}
}

?>