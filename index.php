<?php
session_start(); 
if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
    //User not logged in. Redirect them back to the login.php page.
    header('Location: login.php');
    exit;
}

echo 'Congratulations! You are logged in!';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Titre - Description</title>
</head>
<body>
<h1><?php echo 'Welcome "'.$_POST['username'].'"'; ?> </h1>
</body>
</html>