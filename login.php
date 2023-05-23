<?php
session_start();
function logForm()
{
	return '
	<h1>Login</h1><br>
	<label for="accountType">Account Type:</label>
	<select id="accountType" name="accountType" form="regForm" required>
		<option value="student">Student</option>
		<option value="staff">Staff</option>
	</select> 
	<br>
	<form method="POST" id="regForm" action="doLogin.php">
		<label for="un">Username:</label>
		<input type="text" id="un" name="un" required>
		<br>
		<label for="pw">Password:</label>
		<input type="password" id="pw" name="pw" required>
		<input type="submit" value="Login">
	</form>
	<br><hr>
	<p>Don\'t have an account? <a href="index.php">Create one here</a></p>
	';
}

echo('
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Quiz Creator- Login</title>
</head>
<body>');
echo(logForm());
echo('
</form>
</body>
</html>');



