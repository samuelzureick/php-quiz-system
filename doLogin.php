<?php
session_start();
$accountType = $_POST['accountType'];
$un = $_POST['un'];
$pw = $_POST['pw'];

if($accountType == "staff")
{
	$sql = "SELECT staffID, username, pw FROM staff WHERE username = (:uID)";
}
else
{
	$sql = "SELECT sID, username, pw FROM students WHERE username = (:uID)";
}

$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$stmt = $pdo->prepare($sql);
$stmt->execute(['uID' => $un]);

$stmt->setFetchMode(PDO::FETCH_ASSOC);

while ($row = $stmt->fetch())
{
	if (password_verify($pw, $row['pw']))
	{
		$_SESSION['loggedin'] = true;
		$_SESSION['un'] = $un;
		$_SESSION['accountType'] = $accountType;
		if ($accountType == 'staff')
		{
			$_SESSION['id'] = $row['staffID'];
		}
		else
		{
			$_SESSION['id'] = $row['sID'];
		}
		echo("Login successful!");
		header("Location: quizDashboard.php");
	}
}
echo("Invalid credentials! <a href='login.php'>Back to login</a>");

?>