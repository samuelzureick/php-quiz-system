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

if ($loggedIn && $accountType == 'staff')
{
	echo('<h1>Create New Quiz</h1><hr>');
	echo('<form method="POST" id="newQuiz" name = "newQuiz" action="processQuiz.php"');
	echo('<label for="qName">Quiz Name:</label>');
	echo('<input type="text" id="qName" name="qName" required><br>');
	echo('<label for="qDur">Quiz Duration:</label>');
	echo('<input type="text" id="qDur" name="qDur" required><br>');
	echo('Make Available?:<br>');
	echo('<input type="radio" id="avail1" name="qAvail" value ="1"required>
		<label for ="avail1">Yes</label><br>
		<input type="radio" id="avail2" name="qAvail" value="0" required>
		<label for ="avail2">No</label><br>
		');
	$numRows = (int)$_POST['qNo'];
	$_SESSION['numRows'] = $numRows;
	for($i = 0; $i < $numRows; $i++)
	{
		echo('<br><br>');
		echo('<label for="q'.(string)($i+1).'"><b>Question '.(string)($i + 1) .': </b></label>');
		echo('<input type="text" id="q'.(string)($i+1).'" name="q'.(string)($i+1).'" required>');
		echo('<br>');
		echo('<label for="q'.(string)($i+1).'a1">Answer 1: </label>');
		echo('<input type="text" id="q'.(string)($i+1).'a1" name="q'.(string)($i+1).'a1" required>');
		echo('<br>');
		echo('<label for="q'.(string)($i+1).'a3">Answer 2: </label>');
		echo('<input type="text" id="q'.(string)($i+1).'a2" name="q'.(string)($i+1).'a2" required>');
		echo('<br>');
		echo('<label for="q'.(string)($i+1).'a3">Answer 3: </label>');
		echo('<input type="text" id="q'.(string)($i+1).'a3" name="q'.(string)($i+1).'a3" required>');
		echo('<br>');
		echo('<label for="q'.(string)($i+1).'a4">Answer 4: </label>');
		echo('<input type="text" id="q'.(string)($i+1).'a4" name="q'.(string)($i+1).'a4" required>');
		echo('<br>');
		echo('<label for="q'.(string)($i+1).'ans"> Correct Answer:</label>');
		echo('<select id="q'.(string)($i+1).'ans" name="q'.(string)($i+1).'ans" form="newQuiz" required>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>');
	}
	echo('<br><hr><input type="submit" value="Create">');
	echo('</form>');
	
}
else
{
	echo('<h1>ACCESS DENIED<br><hr><a href="login.php">Return to login</a></h1>');
}
echo('
</body>
</html>');

?>