<?php
session_start();
$accountType = $_POST['accountType'];
$un = $_POST['un'];
$pw = $_POST['pw'];
$name = $_POST['name'];
$pw = password_hash($pw, PASSWORD_DEFAULT);

if($accountType == "staff")
{
	$sql = "SELECT username FROM staff WHERE username = (:uID)";
}
else
{
	$sql = "SELECT username FROM students WHERE username = (:uID)";
}

$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$stmt = $pdo->prepare($sql);
$stmt->execute(['uID' => $un]);

$result = $stmt->fetchAll();
if (count($result) == 0)
{
	if($accountType == "staff")
	{
		$sql = "INSERT INTO staff (username, name, pw) VALUES (:uID, :userName, :uPw)";
	}
	else
	{
		$sql = "INSERT INTO students (username, name, pw) VALUES (:uID, :userName, :uPw)";
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['uID'=> $un,
					'userName'=> $name,
					'uPw'=> $pw]);

	echo("Account created successfully! <a href='login.php'>Login Here</a>");
}
else
{
	echo("Username Already in use! Try again.");
	echo("<a href='index.php'>Register</a>");
}

?>