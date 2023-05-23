<?php 
session_start();

$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];
$qID = $_SESSION['qTook'];
echo('
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quiz Creator- Register</title>
</head>
<body>');


if ($loggedIn && $accountType == 'student')
{
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$numQs = $_SESSION['numQs'];
	$numCorrect = 0;
	echo('RESULTS<hr>');
	echo('<ul>');
	for ($i = 1; $i <= $numQs; $i++)
	{
		$sql = ('SELECT * FROM answers WHERE qID = (:qid) AND qNo = (:qno) and ansNo = (:ansno) and correct = 1');
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['qid' => $qID,
						'qno' => $i,
						'ansno' => $_POST['q'.$i.'a']]);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		if (count($stmt->fetchAll()) ==  1)
		{
			$numCorrect++;
			echo('<li>Question '.$i.': Correct</li>');
		}
		else
		{
			echo('<li>Question '.$i.': Incorrect</li>');
		}
	}

	$sql = ('SELECT * FROM attempts WHERE qID = (:qid) and sID = (:sid)');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qid' => $qID,
					'sid' => $id]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$attempt = 1 +($stmt->rowCount());
	$score = (int)(100*($numCorrect/$numQs));
	echo('<hr>Final Score: '.$score.'%');
	$sql = ('INSERT INTO attempts (qID, sID, attemptNo, attemptDate, score) VALUES (:qid, :sid, :attemptno, now(), :score)');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qid' => $qID,
					'sid' => $id,
					'attemptno' => $attempt,
					'score' => $score]);
	echo('<br><a href="quizDashboard.php">Return To Quiz Dashboard</a>');
}
else
{
	echo('Invalid access. <a href="login.php">Return to login</a>');
}
echo('
</body>
</html>');

?>