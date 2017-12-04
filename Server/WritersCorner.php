<?php 

function USAGE() {
    echo "USAGE: \n";
    echo "GET {html} {remaining query}\n";
}

function LoadHTML ($HTMLToLoad ) {
	$host='writerscorner.cigrvvvr3l3f.us-east-2.rds.amazonaws.com:3306';
	$user='admin';
	$password='WritersCorner!';
	$sql_name='WritersCorner';
	$connection = mysqli_connect($host,$user,$password, $sql_name);

	if($connection->connect_error){
		die('404\n');
	}			

	if (isset($_GET['html'])) {
                        $html = $_GET['html'];
        }
	else {
		//echo "broken";
	}
	if ($html == 'logedin') {
		$html = '<!DOCTYPE html>
			<html lang="en" >
			<head>
			<meta charset="UTF-8">
			<title>Writers Corner</title>
			<link rel="stylesheet" href="HomePage/css/style.css">
			</head>
			<body>
			<div id="wrap">
			<div id="regbar">
			<div id="navthing">';

		//echo "test";
		if (isset($_GET['type'])) {
			$type = $_GET['type'];
		}
		if ($type == 'login') {
			//echo "test 2";
			if (isset($_GET['email'])) {
				$email = $_GET['email'];
			}
			if (isset($_GET['password'])) {
				$password = $_GET['password'];
			}
			//echo $email;
			//echo $password;
			$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password';";
			//echo $sql;

			$result = mysqli_query($connection, $sql);
			
			/*while ($row = $result->fetch_assoc()) {
                                        echo $row["fullName"];
                        }*/			

			if ($result->num_rows > 0) {
				// output data of each row
				while ($row = $result->fetch_assoc()) {
					$name = $row['fullName'];
					$html .= "<h2>$name<img src='WC_Logo.png' style='width:300px;height:30px;' align='right'></h2>";
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
					</html>";
					echo $html; 
					return;		
			} 
			else {
				readfile('HomePage/homepage.html');
				//echo "results not greater than 0";
				return;
			}
		}
		else if ($type == 'register'){
			//echo "test 2";
			if (isset($_GET['email'])) {
				$email = $_GET['email'];
			}
			if (isset($_GET['password'])) {
				$password = $_GET['password'];
			}
			if (isset($_GET['repassword'])) {
                                $repass = $_GET['repassword'];
                        }
			
			if ($password != $repass) {
				readfile('HomePage/homepage.html');
				//echo "not equal";
				return;
			}

			//echo $email;
			//echo $password;
			$sql = "SELECT * FROM users WHERE email = '$email';";
			//echo $sql;

			$result = mysqli_query($connection, $sql);

			/*while ($row = $result->fetch_assoc()) {
			  echo $row["fullName"];
			  }*/
			if ($result->num_rows == 0) {
				// output data of each row
				if (isset($_GET['name'])) {
                        	        $name = $_GET['name'];
                	        }
				$sql = "INSERT INTO users (`email`, `password`, `fullName`) VALUES ('$email', '$password', '$name');";
				$result = mysqli_query($connection, $sql);
								
				if (!$result) {
					readfile('HomePage/homepage.html');
					//echo "not inserted";
					return;
				}
				$html .= "<h2>$name<img src='WC_Logo.png' style='width:300px;height:30px;' align='right'></h2>";
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
					</html>";
				echo $html;
				return;
			}
			else {
				readfile('HomePage/homepage.html');
				//echo "exists in database";
				return;
			}
		}
		readfile($HTMLToLoad);
	}
	else {

		readfile('HomePage/homepage.html');
	}
}

//Query Strings
if (isset($_GET['html'])) {
	$html = $_GET['html'];
}

//Homepage
if (empty($html)) {
	LoadHTML('HomePage/homepage.html');
}
else if ($html == 'homepage') {
	LoadHTML ('HomePage/homepage.html');
}
else if ($html == 'logedin') {
        LoadHTML ('HomePage/logedin.html');
}
else {
        LoadHTML ('HomePage/homepage.html');
}

?>
