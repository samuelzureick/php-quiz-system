<?php 
session_start();

$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];
$qName = $_POST["qName"];
$qAvail = $_POST["qAvail"];
$dur = $_POST["qDur"];
$qID = $_SESSION['qID'];
// print_r($_POST); debugging

if ($loggedIn && $accountType == 'staff')
{
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$sql = ('SELECT * FROM quizzes WHERE qName = (:qName) and qID != (:qid)');
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qName' => $qName,
					'qid' => $qID]);
	if (count($stmt->fetchAll()) != 0)
	{
		echo("<h1><b>QUIZ NAME ALREADY IN USE. <a href='quizDashboard.php'>RETURN TO QUIZ DASHBOARD</a></b></h1>");

	}
	else
	{
	$sql = ('UPDATE quizzes SET qName = (:qname), availability= (:qAvail), duration = (:dur) WHERE qID = (:qid)');	

	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qname' => $qName,
					'qAvail' => $qAvail,
					'dur' => $dur,
					'qid' => $qID]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	for($i = 1; $i<=$_SESSION['qCt']; $i++)
	{
		$sql = ('UPDATE questions SET question = (:newQ) WHERE qID = (:qid) and qNo = (:qno)');
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['newQ' => $_POST['q'.(string)($i)],
						'qid' => (int)$qID,
						'qno' => (int)$i]);
		for($j = 1; $j < 5; $j++)
		{
			$qCorrect = 0;
			if ($_POST['q'.$i.'ans'] == $j)
			{
				$qCorrect = 1;
			}
			$sql = ('UPDATE answers SET answer = (:newAns), correct = (:newCorrect) WHERE qID = (:qid) and qNo = (:qno) and ansNo = (:ansno)');
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['newAns' => $_POST['q'.(string)($i).'a'.(string)($j)],
							'newCorrect' => (int)$qCorrect,
							'qid' => (int)$qID,
							'qno' => (int)$i,
							'ansno' => (int)$j]);
		}
	}


	header("Location: quizDashboard.php");
	}
}


?>