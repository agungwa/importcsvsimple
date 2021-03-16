<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if ( isset( $_POST["import"] ) ) {
	$fileName = $_FILES["file"]["tmp_name"];

	if ($_FILES["file"]["size"] > 0) {

			$file = fopen($fileName, "r");

			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

		$invoice_code = "";
		if (isset($column[0])) {
		$invoice_code = mysqli_real_escape_string($conn, $column[0]);
		}
		$course_code = "";
		if (isset($column[1])) {
		$course_code = mysqli_real_escape_string($conn, $column[1]);
		}
		$platform_code = "";
		if (isset($column[2])) {
			$platform_code = mysqli_real_escape_string($conn, $column[2]);
		}
		$completion_datetime = "";
		if (isset($column[3])) {
		$completion_datetime = mysqli_real_escape_string($conn, $column[3]);
		}
		$nilai = "";
		if (isset($column[4])) {
		$nilai = mysqli_real_escape_string($conn, $column[4]);
		}
		$status = "";
		if (isset($column[5])) {
		$status = mysqli_real_escape_string($conn, $column[5]);
		}
		$certificate_url = "";
		if (isset($column[6])) {
		$certificate_url = mysqli_real_escape_string($conn, $column[6]);
		}
		$rating = "";
		if (isset($column[7])) {
			$rating = mysqli_real_escape_string($conn, $column[7]);
		}
		$ulasan = "";
		if (isset($column[8])) {
			$ulasan = mysqli_real_escape_string($conn, $column[8]);
		}
		$rating_score = "";
		if (isset($column[9])) {
			$rating_score = mysqli_real_escape_string($conn, $column[9]);
		}
		$ulasan_text = "";
		if (isset($column[10])) {
			$ulasan_text = mysqli_real_escape_string($conn, $column[10]);
		}
		$report_datetime = "";
		if (isset($column[11])) {
			$report_datetime = mysqli_real_escape_string($conn, $column[11]);
			}

		$sqlInsert = "INSERT into vol_prakerja_pmo (invoice_code,course_code,platform_code,completion_datetime,nilai,status,certificate_url,rating,ulasan,rating_score,ulasan_text,report_datetime)
                   values (?,?,?,?,?,?,?,?,?,?,?,?)";
		$paramType = "ssssssssssss";
		$paramArray = array(
			$invoice_code,
			$course_code,
			$platform_code,
			$completion_datetime,
			$nilai,
			$status,
			$certificate_url,
			$rating,
			$ulasan,
			$rating_score,
			$ulasan_text,
			$report_datetime
		);
		$insertId = $db->insert($sqlInsert, $paramType, $paramArray);
		// echo '<pre>';
		// print_r( $paramType );
		// echo '</pre>';
		// exit;
		if ( !empty($insertId) ) {
				$type = "success";
				$message = "CSV Data Imported into the Database";
			} else {
				$type = "error";
				$message = "Problem in Importing CSV Data";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<script src="jquery-3.2.1.min.js"></script>

	<style>
	body {
		font-family: Arial;
		width: 550px;
	}

	.outer-scontainer {
		background: #F0F0F0;
		border: #e0dfdf 1px solid;
		padding: 20px;
		border-radius: 2px;
	}

	.input-row {
		margin-top: 0px;
		margin-bottom: 20px;
	}

	.btn-submit {
		background: #333;
		border: #1d1d1d 1px solid;
		color: #f0f0f0;
		font-size: 0.9em;
		width: 100px;
		border-radius: 2px;
		cursor: pointer;
	}

	.outer-scontainer table {
		border-collapse: collapse;
		width: 100%;
	}

	.outer-scontainer th {
		border: 1px solid #dddddd;
		padding: 8px;
		text-align: left;
	}

	.outer-scontainer td {
		border: 1px solid #dddddd;
		padding: 8px;
		text-align: left;
	}

	#response {
		padding: 10px;
		margin-bottom: 10px;
		border-radius: 2px;
		display: none;
	}

	.success {
		background: #c7efd9;
		border: #bbe2cd 1px solid;
	}

	.error {
		background: #fbcfcf;
		border: #f3c6c7 1px solid;
	}

	div#response.display-block {
		display: block;
	}
	</style>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#frmCSVImport").on("submit", function() {

			$("#response").attr("class", "");
			$("#response").html("");
			var fileType = ".csv";
			var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
			if (!regex.test($("#file").val().toLowerCase())) {
				$("#response").addClass("error");
				$("#response").addClass("display-block");
				$("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
				return false;
			}
			return true;
		});
	});
	</script>
</head>

<body>
	<h2>Import CSV </h2>

	<div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
		<?php if(!empty($message)) { echo $message; } ?>
	</div>
	<div class="outer-scontainer">
		<div class="row">

			<form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport"
				enctype="multipart/form-data">
				<div class="input-row">
					<label class="col-md-4 control-label">Choose CSV
						File</label> <input type="file" name="file" id="file" accept=".csv">
					<button type="submit" id="submit" name="import" class="btn-submit">Import</button>
					<br />

				</div>

			</form>

		</div>	
	</div>

</body>

</html>