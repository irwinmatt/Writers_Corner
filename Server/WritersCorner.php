<?php

function USAGE() {
    echo "USAGE: \n";
    echo "GET {html}\n";
}

function LoadHTML ($HTMLToLoad) {
        readfile($HTMLToLoad);
}

/*
$host='rds-mysql-dormsocial.ct1feoczg7ml.us-east-2.rds.amazonaws.com:3306';
$user='rajat95';
$password='307database';
$sql_name='DormSocialDatabase';
$firstTimeThrough = 0;
$connection = mysqli_connect($host,$user,$password, $sql_name);

if($connection->connect_error){
    die('404\n');
}
*/

//Query Strings
if (isset($_GET['html'])) {
        $html = $_GET['html'];
}

//Homepage
if (empty($html)) {
        LoadHTML('HomePage/homepage.html');
}
else {
        LoadHTML ($html);
}

?>
