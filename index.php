<?php
session_start();
function reg()
{
	return '
	<h1>REGISTER</h1><br>
	<label for="accountType">Account Type:</label>
	<select id="accountType" name="accountType" form="regForm" required>
		<option value="student">Student</option>
		<option value="staff">Staff</option>
	</select> 
	<br>
	<form method="POST" id="regForm" action="doReg.php">
		<label for="name">Name:</label>
		<input type ="text" id="name" name="name" required>
		<br>
		<label for="un">Username:</label>
		<input type="text" id="un" name="un" required>
		<br>
		<label for="pw">Password:</label>
		<input type="password" id="pw" name="pw" required>
		<input type="submit" value="Register">
	</form>
	<br><hr>
	<p>Already have an account? <a href="login.php">Login here</a></p>
	';
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
echo(reg());
echo('
</body>
</html>');

?>

