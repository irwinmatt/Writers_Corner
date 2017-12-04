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
	if ($html == 'logedin') {
		$html = '<!DOCTYPE html>
			<html lang="en" >
			<head>

			<style>
			table {
				border-collapse: collapse;
				width: 100%;
			}
			th, td {
				text-align: left;
				padding: 8px;
			}
			tr:nth-child(odd) {background-color: #0066CC;}
			   </style>

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
		//echo $type;
		if (isset($_GET['getfiles'])) {
                        $getfiles = $_GET['getfiles'];
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
					$id = $row['ID'];
				$html .= "<h2>$name<img src='WC_Logo.png' style='width:300px;height:30px;' align='right'></h2>";
				}
				$html .= "<br/>
					<br/>";
					if ($getfiles == "mine") {
						$html .= "<h2><a href='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/WritersCorner.php'><div class='button' style='float:left;'>Logout</div></h2>
							<h2><center>My Works</center>
							<a href='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/WritersCorner.php?
							html=logedin&type=login&email=$email&password=$password&getfiles=all'>
							<div class='button large-btn' align='right'>Community Work</div></h2>
							<hr align='left' width='96%'/>";
					}
					else {
						$html .= "<h2><center>Community Works</center>
                                                        <a href='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/WritersCorner.php?
							html=logedin&type=login&email=$email&password=$password&getfiles=mine'>
                                                        <div class='button large-btn' align='right'>My Work</div></h2>
                                                        <hr align='left' width='96%'/>";
					}
				$html .= "<form action='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/Upload.php' method='post' enctype='multipart/form-data'>
                                        <center>
                                        <p style='color:white'>Upload a File
					<input type='hidden' name='email' value='$email'>
                                        <input type='hidden' name='password' value='$password'>
                                        <input type='file' name='fileToUpload' id='fileToUpload'>
                                        <input type='submit' value='Upload File' name='submit'>
                                        </p>
					<br/>
					<table>";
				if ($getfiles == "mine") {
					$sql = "SELECT * FROM files WHERE creatorID = '$id'";
				}
				if ($getfiles == "all") {
					$sql = "SELECT * FROM files WHERE creatorID != '$id'";
				}				
				$result = mysqli_query($connection, $sql);
				while ($row = $result->fetch_assoc()) {
					$creatorname = $row['creatorName'];
					$filename = $row['fileName'];
					$html .= "<tr>
						<td><font color='white'>Creator: $creatorname </font></td>
						<td><font color='white'>Title: $filename </font></td>
						<td>
							<a href='uploads/$filename'><div class='button medium-btn'>View File</div></a>
						</td>
						</tr>
						<br/>";
				}

				$html .= "</table>
					</center>
					</form>
					</div>
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
					<br/>";
					if ($getfiles == "mine") {
                                                $html .= "<h2><center>My Works</center>
                                                        <a href='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/WritersCorner.php?
                                                        html=logedin&type=login&email=$email&password=$password&getfiles=all'>
                                                        <div class='button large-btn' align='right'>Community Work</div></h2>
                                                        <hr align='left' width='96%'/>";
                                        }
                                        else {
                                                $html .= "<h2><center>Community Works</center>
                                                        <a href='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/WritersCorner.php?
							html=logedin&type=login&email=$email&password=$password&getfiles=mine'>
                                                        <div class='button large-btn' align='right'>My Work</div></h2>
                                                        <hr align='left' width='96%'/>";
                                        }
				$html .= "<form action='http://ec2-18-217-87-83.us-east-2.compute.amazonaws.com/Upload.php' method='post' enctype='multipart/form-data'>
					<center>
					<p style='color:white'>Upload a File
					<input type='hidden' name='email' value='$email'>
					<input type='hidden' name='password' value='$password'>
					<input type='file' name='fileToUpload' id='fileToUpload'>
					<input type='submit' value='Upload File' name='submit'>
					</p>
					<br/>
					<table>";


				if ($getfiles == "mine") {
                                        $sql = "SELECT * FROM files WHERE creatorID = '$id'";
                                }
                                if ($getfiles == "all") {
                                        $sql = "SELECT * FROM files WHERE creatorID != '$id'";
                                }
                                $result = mysqli_query($connection, $sql);
                                while ($row = $result->fetch_assoc()) {
                                        $creatorname = $row['creatorName'];
                                        $filename = $row['fileName'];
                                        $html .= "<tr>
                                                <td><font color='white'>Creator: $creatorname </font></td>
                                                <td><font color='white'>Title: $filename </font></td>
                                                <td>
                                                        <a href='uploads/$filename'><div class='button medium-btn'>View File</div></a>
                                                </td>
                                                </tr>
                                                <br/>";
                                }
				

				$html .= "</table>
					</center>
					</form>	
					</div>
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
