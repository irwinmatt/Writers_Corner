<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

//header('Content-Type: text/plain; charset=utf-8');

$host='writerscorner.cigrvvvr3l3f.us-east-2.rds.amazonaws.com:3306';
$user='admin';
$password='WritersCorner!';
$sql_name='WritersCorner';
$connection = mysqli_connect($host,$user,$password, $sql_name);

$email = "";
$password = "";

if($connection->connect_error){
	die('404\n');
}

if (isset($_POST['email'])) {
	$email = $_POST['email'];
}
if (isset($_POST['password'])) {
	$password = $_POST['password'];
}
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password';";
$result = mysqli_query($connection, $sql);
if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                $name = $row['fullName'];
                $id = $row['ID'];
                //$html .= "<h2>$name<img src='WC_Logo.png' style='width:300px;height:30px;' align='right'></h2>";
        }
}


/*$html = "<!DOCTYPE html>
<html lang='en' >
<head>
<meta charset='UTF-8'>
<title>Writers Corner</title>
<link rel='stylesheet' href='HomePage/css/style.css'>
</head>
<body>
<div id='wrap'>
<div id='regbar'>
<div id='navthing'>";

$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password';";
$result = mysqli_query($connection, $sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$name = $row['fullName'];
		$id = $row['ID'];
		$html .= "<h2>$name<img src='WC_Logo.png' style='width:300px;height:30px;' align='right'></h2>";
	}
}

$html .= "<br/>
<br/>
<h2><center>My Works</center></h2>
<hr align='left' width='96%'/>";
$html .= "<form action='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/Upload.php' method='post' enctype='multipart/form-data'>
<center>
<p style='color:white'>Upload a File
<input type='hidden' name='email' value='$email'>
<input type='hidden' name='password' value='$password'>
<input type='file' name='fileToUpload' id='fileToUpload'>
<input type='submit' value='Upload File' name='submit'>
</p>
</center>
</form>";
$html .= "</div>
</div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script  src='HomePage/js/index.js'></script>

</body>
</html>";*/

//$sql = "INSERT INTO `WritersCorner`.`files` (`creatorID`, `filePath`) VALUES ('$id', 'fileName');";
//$result = mysqli_query($connection, $sql);

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
    } else {
        //echo "File is not an image.";
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "pdf" && $imageFileType != "docx" && $imageFileType != "txt") {
    //echo "DOCX, PDF & TXT files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	$fileName = basename($_FILES["fileToUpload"]["name"]);
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	$sql = "INSERT INTO `WritersCorner`.`files` (`creatorID`, `filePath`, `fileName`, `creatorName`) VALUES ('$id', '$target_file', '$fileName', '$name');";
	$result = mysqli_query($connection, $sql);

    } else {
        //echo "Sorry, there was an error uploading your file.";
    }
}

header("Location: http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/WritersCorner.php?html=logedin&type=login&email=$email&password=$password&getfiles=mine");
exit;
//echo $html;
 
?> 
