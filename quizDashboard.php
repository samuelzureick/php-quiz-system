<?php
//error_reporting(E_ALL);
session_start();

$loggedIn = $_SESSION['loggedin'];
$un = $_SESSION['un'];
$accountType = $_SESSION['accountType'];
$id = $_SESSION['id'];

function staffDash()
{
	$sql = 'SELECT qID, qName FROM quizzes WHERE author IN (SELECT name FROM staff WHERE staffId = (:uID))';
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	echo('<h1>Your Quizzes</h1>');
	echo('<hr>');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['uID' => $_SESSION['id']]);

	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo('<form method="post" id="modQ" action="editQuiz.php">');
	while ($row = $stmt->fetch())
	{
		echo('<input type="radio" id="'.$row['qName'].'" name="qName" value="'.$row['qName'].'" required>');
		echo('<label for="'.$row['qName'].'">'.$row['qName'].'</label>');
		echo('<br>');
	}
	echo('<hr><input type="submit" value="Modify">');
	echo('</form>');

	echo('<br><hr><h2>Create New quiz</h2><br>');
	echo('<form method = "POST" id="qCreateForm" action="create.php"><label for="qNo">Number of Questions:</label><input type="text" id="qNo" name="qNo" required><br><input type="submit" value="Create"></form>');

	
}
function studentDash()
{
	$avail = 1;
	$sql = ('SELECT qID, qName FROM quizzes WHERE availability = (:avail)');
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=x83005sz', 'x83005sz', 'databaseCwk2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	echo('<h1>Quizzes</h1>');
	echo('<hr>');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['avail' => $avail]);

	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo('<form method="post" id="takeQ" action="takeQuiz.php">');
	while ($row = $stmt->fetch())
	{
		echo('<input type="radio" id="'.$row['qName'].'" name="qName" value="'.$row['qName'].'" required>');
		echo('<label for="'.$row['qName'].'">'.$row['qName'].'</label>');
		echo('<br>');
	}
	echo('<hr><input type="submit" value="Take">');
	echo('</form>');

	echo('<hr><h1>Previous Attempts</h1>');
	$sql = ('SELECT * 
		    FROM (quizzes INNER JOIN attempts ON quizzes.qID = attempts.qID) 
		    WHERE sID = :sid
		    ORDER BY score ASC');
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['sid' => $_SESSION['id']]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo('<ul>');
	while ($row = $stmt->fetch())
	{
		echo('<li>');
		echo('Quiz: '.$row['qName'].', attempt '.$row['attemptNo'].': '.$row['score'].'%');
		echo('</li>');
	}
	echo('</ul>');
}

echo('
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quiz Creator- Register</title>
</head>
<body>');

if ($loggedIn && $accountType == 'staff')
{
	staffDash();
}
else if ($loggedIn && $accountType == 'student')
{
	studentDash();
}
else
{
	echo('Not logged in! <a href="login.php">Return to login</a>');
}

echo('
</body>
</html>');

?>