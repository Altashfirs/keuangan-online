<?php  

$sname = "sql313.epizy.com";
$uname = "epiz_34349350";
$password = "2e9N8DaE5QQa";

$db_name = "epiz_34349350_db_hutang";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection Failed!";
	exit();
}