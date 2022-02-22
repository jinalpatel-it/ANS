<?php
require_once "dbconfig.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Account Recovery</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" id="ans-css">
	<link href="assets/css/signin.css" rel="stylesheet" id="ans-css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container account-recovery">
		<div class="row">
			<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col text-center">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
				</section>
				<section class="card card-signin my-3">
					<div class="card-body">
						<h5 class="card-title text-center font-weight-bold">Username and Password Reminder</h5>
						<div class="info text-center my-4">
							<p>Your Username and Password will be sent to your registered e-mail address.</p>
						</div>
						<form class="form-signin" method="POST">
							<div class="form-label-group">
								<input type="email" id="inputemail" class="form-control" name="Remail" placeholder="Your E-mail Address" required autofocus>
								<label for="inputemail">Your E-mail Address</label>
							</div>

							<button class="btn btn-lg btn-secondary text-center text-uppercase" type="submit" name="submit">Send Request</button>
							<div id="errorMsg" class="mt-5"></div>
						</form>
					</div>
				</section>
			</div>
		</div>
	</div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
	if (!isset($_POST['Remail'])) {
?>
		<script>
			$("#errorMsg").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Unknow User!</strong> Please enter email address......</div>');
		</script>
		<?php
	} else {
		$sql = "SELECT id, name, user_name,user_password FROM " . $Login_Table . " WHERE user_email = '" . $_POST['Remail']."'";
	
		$result = mysqli_query($con, $sql);
		$newPassword = randomPassword();
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$message = '				
				<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
					<!--100% body table-->
					<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
						style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
						<tr>
							<td>
								<table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
									align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td style="height:80px;">&nbsp;</td>
									</tr>									
									<tr>
										<td style="height:20px;">&nbsp;</td>
									</tr>
									<tr>
										<td>
											<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
												style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
												<tr>
													<td style="height:40px;">&nbsp;</td>
												</tr>
												<tr>
													<td style="padding:0 35px;">
														<h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">You have
															requested to login details</h1>
														<span
															style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
														<p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
														We cannot simply send you your old password. We generate new password for you.
															Your login information:
																UserName : ' . $row["user_name"] . '
																Password : ' . $newPassword . '
														</p>
														<a href="javascript:void(0);"
															style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
															Password</a>
													</td>
												</tr>
												<tr>
													<td style="height:40px;">&nbsp;</td>
												</tr>
											</table>
										</td>
									<tr>
										<td style="height:20px;">&nbsp;</td>
									</tr>
									
									
								</table>
							</td>
						</tr>
					</table>
					<!--/100% body table-->
				</body>
				
				</html>';
				if (mail($_POST['Remail'], "Your Login Information For ANS", $message)) {
					$sql = "UPDATE " . $Login_Table . " SET user_password=" . md5($newPassword) . " WHERE id=" . $row['id'];
					$result = mysqli_query($con, $sql);
					if (mysqli_query($con, $sql)) {
		?>
						<script>
							$("#errorMsg").html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Email send!</strong> Please cehck your email for details</div>');
						</script>
					<?php
					header("Refresh:5;url=".$base_url."index.php");
					} else {

					?>
						<script>
							$("#errorMsg").html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Something wrong!</strong> Please try again......</div>');
						</script>
<?php

					}
					
				}
			}
		}
	}
}


function randomPassword()
{
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

?>