<?php 
session_start();

$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];

echo('
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quiz Creator- Register</title>
</head>
<body>');

if ($loggedIn && $accountType == "student")
{
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$sql = ('SELECT * FROM quizzes WHERE qName = (:qname)');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qname' => $_POST['qName']]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$qData = $stmt->fetch();
	$qID = $qData['qID'];
	$qAuthor = $qData['author'];
	$qName = $qData['qName'];
	$dur = $qData['duration'];
	$_SESSION['qTook'] = $qID;
	echo('<h1>Quiz: '.$qName.'</h1>');
	echo('<br><h2>Author: '.$qAuthor.'<br>Duration: '.$dur.'</h2>');
	echo('<hr>');
	$sql = ('SELECT * FROM questions WHERE qID = (:qid) ORDER BY qNo ASC');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qid' => $qID]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo('<form method = "POST" id="subQuiz" action="gradeQuiz.php">');
	$i = 1;
	while($row = $stmt->fetch())
	{
		echo("Q".$i.") ".$row['question']);
		$sql2 = ('SELECT answer from answers WHERE qID = (:qid) and qNo = (:qno) ORDER BY ansNo ASC');
		$stmt2 = $pdo->prepare($sql2);
		$stmt2->execute(['qid' => $qID,
						 'qno' => $i]);
		$stmt2->setFetchMode(PDO::FETCH_ASSOC);
		$j = 1;
		while($col = $stmt2->fetch())
		{
			echo('<br>  '.$j.') '.$col['answer']);
			$j++;
		}

		echo('<br><label for="q'.$i.'a">Answer: </label>');
		echo('<select id="q'.$i.'a" name="q'.$i.'a" form="subQuiz" required>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select><br>');
		$i++;
	}
	$_SESSION['numQs'] = $i-1;
	echo('<br><hr><input type="submit" value="Submit Quiz">');
	echo('</form>');

}
else
{
	echo('Invalid access. <a href="login.php">Return to login</a>');
}

echo('
</body>
</html>');


?>