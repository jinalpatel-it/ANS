<?php
require_once "dbconfig.php";
// Check userlogin
if(!isset($_SESSION['loggedin']) && (!isset($_POST['application']) || !isset($_POST['lang'])))
{
	header("Location:index.php");
}

$sqlGetLang = mysqli_query($con, "SELECT * FROM " . $lang_Table . " WHERE id  = '" . $_GET['lang'] . "'");
if (mysqli_num_rows($sqlGetLang) == 1) {
	$language = mysqli_fetch_assoc($sqlGetLang);
} else {
	header("Location:index.php");
}

$sqlFile = mysqli_query($con, "SELECT * FROM " . $resources_Table . " WHERE id  = '" . $_GET['file'] . "'");
if (mysqli_num_rows($sqlFile) == 1) {
	$file = mysqli_fetch_assoc($sqlFile);
} else {
	header("Location:index.php");
}


$myfiles = mysqli_query($con,"SELECT $SystemMessage_Table.*,$Translation_Table.*,$SystemMessage_Table.id as sysid FROM " . $SystemMessage_Table . " LEFT JOIN " . $Translation_Table . " ON $Translation_Table.sys_message_id = $SystemMessage_Table.id WHERE application_id = '" . $_GET['application'] . "' AND resource_id = '".$_GET['file']."'");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Resource Files</title>
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
	<div class="container edit-res-files">
		<div class="row">
			<div class="col-sm-9 col-md-9 col-lg-8 mx-auto">
				<section class="row pt-5 header-row">
					<div class="col text-left">
						<img src="assets/image/ans-logo.png" class="img-fluid" alt="logo">
					</div>
					<div class="col text-right">
						<a href="<?= $base_url."resourceFiles.php?application=".$_GET['application']."&lang=".$_GET['lang']?>" class="btn btn-secondary">All RESX Files</a>
						<a href="<?= $base_url."logout.php"?>" class="btn btn-outline-secondary">Logout</a>
					</div>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 mx-auto">
				<section class="py-4 page-content">
					<div class="row justify-content-center">
						<h2 class="font-weight-bold title-underline">Translate Web Page: <?= $file['title']; ?></h2>
					</div>
				</section>
				<?php if ($_SESSION['isAdmin'] == 1) : ?>
				<section>
					<div class="row justify-content-center pt-4">
						<div class="col-4 text-center ">
						<form action="" method="post" enctype="multipart/form-data" >
							<div class="mb-3">							  
							  <input class="form-control"  name="file"  required type="file" id="formFile">
							</div>
							<div class="mb-3">
							<input type="submit" name="importSubmit" class="btn btn-secondary import-btn" value="Import Web Page">
								
							</div>
						</form>
						</div>
					</div>
				</section>
					<?php endif; ?>

				<section>
					<div class="row">
						<div class="col-12 pt-4">
							<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead>
									<tr>	
									<th class="th-sm">Title</th>									
										<th class="th-sm">English</th>
										<th class="th-sm"><?php echo $language['name']; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php while ($row = mysqli_fetch_assoc($myfiles)) :?>								
										<?php if ($row['language_id'] == $_GET['lang']) : $lantrans = $row['translation_msg'];
											else : $lantrans = null;
											endif;  ?>
									<tr id="<?= $row['sysid']; ?>" class="update">
										
										<td><?= $row['Title']; ?></td>
										<td><?= $row['Message']; ?></td>
										<td><?= $lantrans; ?></td>
									</tr>
									<?php endwhile;?>
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
<script>
	var url = "<?php echo $base_url . "updateSystemMessages.php"; ?>";
	$(document).ready(function() {
		$(".update").on("click", function() {
			var id = $(this).attr('id');
			window.location.href = url + '?sid=' + id + "&lang=<?php echo  $_GET['lang']; ?>"+"&resource=true";
		});
	});
</script>
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
			$sql = "INSERT INTO " . $SystemMessage_Table . " (  Title,Message,application_id,module_id,resource_type,resource_id) VALUES ('" . $title . "', '" . $message . "','" . $_GET['application'] . "', '" . (isset($_GET['module'])? $_GET['module'] : 0) . "', 2,'".$_GET['file']."')";
			$result = mysqli_query($con, $sql);
		}

		// Close opened CSV file
		fclose($csvFile);

		header("location:".$base_url . "resourceFiles.php?application=".$_GET['application']."&lang=".$_GET['lang']);
		exit;
	}
} 
 
}