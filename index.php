<?php
define('BASE_DIR', '/home/michelesk/domains/michele.sk/public_html/send-email/upload/');

echo "start";
$errorStatus = '';
if ( isset($_POST["submit"]) ) {

    if ( isset($_FILES["csvFile"])) {
        //if there was an error uploading the file
        if ($_FILES["csvFile"]["error"] > 0) {
            $errorStatus = "Return Code: " . $_FILES["csvFile"]["error"] . "<br />";
        }else if($_FILES["csvFile"]["type"] !== 'text/csv'){
        	$errorStatus = 'Uploaded file is not type of csv.';
        }
        else {
            //Store file in directory "upload" with the name of "uploaded_file.txt"
            $storagename = "email_list.csv";
            $status = move_uploaded_file($_FILES["csvFile"]["tmp_name"], BASE_DIR . $storagename);

            if(!$status){
            	$errorStatus = "Error occured while uploading CSV file";
            }else{
	            $errorStatus = $errorStatus . "<br/>Stored in: " . BASE_DIR . $storagename . "<br />";

	            $tmpName = BASE_DIR . $storagename;
				$csvAsArray = array_map('str_getcsv', file($tmpName));

				// $php_array = json_encode($csvAsArray);
				// echo $php_array . "<br/>";
				$index = 0;
				foreach ($csvAsArray[0] as $item) {
					$index ++;
					$item = trim($item);
					echo 'Email' . $index . ':    ' . $item . "<br/>";
				}
            }
        }
	}
	else {
		$errorStatus = "No CSV file selected.";
	}


	if ( isset($_FILES["htmlFile"])) {
        //if there was an error uploading the file
        if ($_FILES["htmlFile"]["error"] > 0) {
            $errorStatus = "Return Code: " . $_FILES["htmlFile"]["error"] . "<br />";
        }
        else if($_FILES["htmlFile"]["type"] !== 'text/html'){
        	$errorStatus = $errorStatus . '<br>Uploaded file is not type of HTML.';
        }
        else {
            //Store file in directory "upload" with the name of "uploaded_file.txt"
            $storagename = "template_email.html";
            $status = move_uploaded_file($_FILES["htmlFile"]["tmp_name"], BASE_DIR . $storagename);

            if(!$status){
            	$errorStatus = $errorStatus . "<br/>Error occured while uploading HTML template.";
            }else{
	            $errorStatus = $errorStatus . "<br/>Stored in: " . BASE_DIR . $storagename . "<br />";

	            $tmpName = BASE_DIR . $storagename;
				$csvAsArray = array_map('str_getcsv', file($tmpName));

				// $php_array = json_encode($csvAsArray);
				// echo $php_array . "<br/>";
				
				$errorStatus = $errorStatus . "<br/>Successfully uploaded HTML template !" ;
            }
        }
	}
	else {
		$errorStatus = $errorStatus . "<br>No HTML Template selected.";
	}
}
?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<title>Mass Email Track</title>
	</head>
	<body>
		
		<div class="container">
			<div class="row">
				<h1 class="text-info">Email Tracker</h1>
			</div>
			<?php
			if(isset($errorStatus))
				echo "<span class='text-danger'>" . $errorStatus . "</span><br>";
			?>
			<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
				<div class="form-group row">
					<label class="col-md-4 form-control">Select CSV file.</label>
					<div class="col-md-8"><input type="file" name="csvFile" id="csvFile" class="form-control" /></div>
				</div>
				<div class="form-group row">
					<label class="col-md-4 form-control">Select HTML template file.</label>
					<div class="col-md-8">
						<input type="file" name="htmlFile" id="htmlFile" class="form-control" />
					</div>
				</div>
				<div class="form-group row">
					<input type="submit" name="submit" class="btn btn-primary col-md-4 pull-right form-control"/>
				</div>
			</form>

			<form action="sendmail.php" method="post">
				<input type="submit" name="Go email">
			</form>
			<div class="progress">
			    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
			      40%
			    </div>
			</div>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	</body>
</html>