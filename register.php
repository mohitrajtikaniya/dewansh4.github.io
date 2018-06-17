<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

$message = '';

if(!empty($_POST['Name']) && !empty($_POST['Password'])&& !empty($_POST['LicenseId'])&& !empty($_POST['Specialist'])&& !empty($_POST['Gender'])&& !empty($_POST['ContactNo'])):
	
	// Enter the new user in the database
	$sql = "INSERT INTO users (Name, Password,LicenseId,Specialist,Gender,ContactNo) VALUES (:Name, :Password,:LicenseId,:Specialist,:Gender,:ContactNo)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':Name', $_POST['Name']);
	$stmt->bindParam(':LicenseId', $_POST['LicenseId']);
	$stmt->bindParam(':Specialist', $_POST['Specialist']);
	$stmt->bindParam(':Gender', $_POST['Gender']);
	$stmt->bindParam(':ContactNo', $_POST['ContactNo']);
	$stmt->bindParam(':Password', password_hash($_POST['Password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
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

	<h1>Register</h1>
	<span>or <a href="login.php">login here</a></span>

	<form action="register.php" method="POST">
		
		<input type="text" placeholder="Enter your email" name="Name">
		<input type="password" placeholder="and password" name="Password">
		<input type="password" placeholder="confirm password" name="Password">
		<input type="text" placeholder="Enter your LicenseId" name="LicenseId">
		<input type="text" placeholder="Enter your speciality" name="Specialist">
		<input type="text" placeholder="Enter your Gender" name="Gender">
		<input type="text" placeholder="Enter your ContactNo" name="ContactNo">
		<input type="submit">

	</form>

</body>
</html>