<?php

// Connect to the database(host, username, password)
$con = mysql_connect('localhost','dagplannah','hoepla');
if (!$con)
{
	echo "Failed to make connection.";
	exit;
}
// Select the database. Enter the name of your database (not the same as the table name)
$db = mysql_select_db('dagplanner_db');
if (!$db)
{
	echo "Failed to select db.";
	exit;
}

// $_POST['username'] and $_POST['password'] are the param names we sent in our click event in login.js
$username = $_POST['username'];
$password = md5(sha1($_POST['password']));

// Select eveything from the users table where username field == the username we posted and password field == the password we posted
$sql = "SELECT * FROM users WHERE email = '" . $username . "' AND `password` LIKE '" . $password . "'";
$query = mysql_query($sql);
// If we find a match, create an array of data, json_encode it and echo it out
if (mysql_num_rows($query) > 0){
	$row = mysql_fetch_array($query);
	$response = array(
		'logged' => true,
		'name' => $row['name'],
		'email' => $row['email']
	);
	echo json_encode($response);
}
else{
	// Else the username and/or password was invalid! Create an array, json_encode it and echo it out
	$response = array(
		'logged' => false,
		'message' => 'Invalid Username and/or Password'
	);
	echo json_encode($response);
}
?>
