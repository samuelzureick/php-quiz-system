<?php
session_start();
$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];
$qName = $_POST['qName'];

echo('
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quiz Editor</title>
</head>
<body>');

if ($loggedIn && $accountType == 'staff')
{
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$sql = ('SELECT * FROM quizzes WHERE qName = (:qName)');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qName' => $qName]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$out = $stmt->fetch();

	$qID = $out['qID'];
	$qName = $out['qName'];
	$qAvail = $out['availability'];
	$qDur = $out['duration'];

	$_SESSION['qID'] = $qID;


	$sql = ('SELECT * FROM questions WHERE qID = (:qid)');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['qid' => $qID]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$iterator = 1;

	echo('<form method="POST" id="modQuiz" name = "modQuiz" action="updateQuiz.php"');
	echo('<label for="qName">Quiz Name:</label>');
	echo('<input type="text" id="qName" name="qName" value="'.$qName.'" required><br>');
	echo('<label for="qDur">Quiz Duration:</label>');
	echo('<input type="text" id="qDur" name="qDur" value="'.$qDur.'" required><br>');
	echo('Make Available?:<br>');
	echo('<input type="radio" id="avail1" name="qAvail" value ="'.$qAvail.'"required>
		<label for ="avail1">Yes</label><br>
		<input type="radio" id="avail2" name="qAvail" value="0" required>
		<label for ="avail2">No</label><br>
		');
	while ($row = $stmt->fetch())
	{
		echo('<br>');
		echo('<label for="q'.(string)($iterator).'"><b>Question '.(string)($iterator) .': </b></label>');
		echo('<input type="text" id="q'.(string)($iterator).'" name="q'.(string)($iterator).'" value="'.$row['question'].'" required><br>');

		$sql2 = ('SELECT * FROM answers WHERE qID = (:qid) and qNo = (:qno)');
		$stmt2 = $pdo->prepare($sql2);
		$stmt2->execute(['qid' => $qID,
						 'qno' => $iterator]);
		$stmt2->setFetchMode(PDO::FETCH_ASSOC);
		$correctAns = 0;
		$iterator2 = 1;
		while($row2 = $stmt2->fetch())
		{
			if ($row2['correct'] == 1)
			{
				$correctAns = $iterator2;
			}
			echo('<label for="q'.(string)($iterator).'a1">Answer '.(string)($iterator2).': </label>');
			echo('<input type="text" id="q'.(string)($iterator).'a'.(string)($iterator2).'" name="q'.(string)($iterator).'a'.(string)$iterator2.'" value ="'.$row2['answer'].'" required>');
			echo('<br>');

			$iterator2++;
		}

		echo('<label for="q'.(string)($iterator).'ans"> Correct Answer:</label>');
		echo('<select id="q'.(string)($iterator).'ans" name="q'.(string)($iterator).'ans" form="modQuiz" value="'.$correctAns.'" required>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>');


		$iterator++;
	}
	$_SESSION['qCt'] = $iterator-1;
	echo('<br><hr><input type="submit" value="Update">');
	echo('</form>');
	echo('<form action="processDel.php"><br><input type="submit" value="Delete"></form>');
}
else
{
	echo('Not logged in/ invalid permissions! <a href="login.php">Return to login</a>');
}



?>