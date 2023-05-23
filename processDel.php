<?php
session_start();
$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];
$qID = $_SESSION['qID'];
if ($loggedIn && $accountType == 'staff')
{
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$sql = ('DELETE FROM quizzes WHERE qID =:qid');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qid' => $qID]);

	header("Location: quizDashboard.php");
}
else
{
	echo('invalid permissions! <a href="login.php">Return to Login</a>');
}

?>