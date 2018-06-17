<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

if(!empty($_POST['Name']) && !empty($_POST['Password'])):
	
	$records = $conn->prepare('SELECT id,Name,Password FROM users WHERE Name = :Name');
	$records->bindParam(':Name', $_POST['Name']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['Password'], $results['Password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: /");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">MED_HELP</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Login</h1>
	<span>or <a href="register.php">register here</a></span>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter your email" name="Name">
		<input type="password" placeholder="and password" name="Password">

		<input type="submit">

	</form>

</body>
</html>