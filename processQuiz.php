<?php 
session_start();

$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];
$numRows = $_SESSION['numRows'];
$qName = $_POST["qName"];
$qAvail = $_POST["qAvail"];
$dur = $_POST["qDur"];
// print_r($_POST); debugging

if ($loggedIn && $accountType == 'staff')
{
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$sql = ('SELECT * FROM quizzes WHERE qName = (:qName)');
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qName' => $qName]);
	if (count($stmt->fetchAll()) != 0)
	{
		echo("<h1><b>QUIZ NAME ALREADY IN USE. <a href='quizDashboard.php'>RETURN TO QUIZ DASHBOARD</a></b></h1>");

	}
	else
	{
	$sql = ('SELECT name FROM staff WHERE staffId = (:uID)');
	

	$stmt = $pdo->prepare($sql);
	$stmt->execute(['uID' => $_SESSION['id']]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);

	$name = ($stmt->fetch()['name']);

	$sql = ('INSERT INTO quizzes (qName, author, availability, duration) values (:qName, :qAuthor, :qAvail, :qDur)');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qName' => $qName,
					'qAuthor' => $name,
					'qAvail' => $qAvail,
					'qDur' => $dur]);
	$lastId = $pdo->lastInsertId();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	//print_r($_POST);
	for($i = 1; $i <= $numRows; $i++)
	{
		$sql = ('INSERT INTO questions (qID, qNo, question) values (:qID, :qNo, :qQ)');
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['qID' => $lastId,
						  'qNo' => ($i),
						  'qQ' => $_POST['q'.(string)($i)]]);

		for ($j = 1; $j < 5; $j++)
		{
			$cVal = 0;
			if ($j == $_POST['q'.(string)($i).'ans'])
			{
				$cVal = 1;
			}
			$sql = ('INSERT INTO answers (qID, qNo, ansNo, answer, correct) VALUES (:qID, :qNo, :ansNo, :ans, :correct)');
				$stmt = $pdo->prepare($sql);
				$stmt->execute(['qID' => $lastId,
							  'qNo' => ($i),
							  'ansNo' => $j,
							  'ans' => $_POST['q'.(string)($i).'a'.(string)$j], 'correct' => $cVal]);
		}
	}
	header("Location: quizDashboard.php");
	}
}


?>