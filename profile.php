<?php
require 'modules/bdd.php';

session_start(); 

if(!isset($_SESSION['user_id'])){
    //User not logged in. Redirect them back to the login.php page.
    header('Location: login.php');
    exit;
}
$sql = "SELECT * FROM users WHERE id = 30";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//print_r($_SESSION); 
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <style type="text/css">
    	.form-group {
    		margin-top: 10px;
    	}
    </style>
    <body>
        <h1>Welcome test <?php echo $_SESSION['user_id']; ?> <a href="modules/logout.php">Logout</a></h1>

       <form action="modules/updateuser.php" method="post">
            <div class="form-group">
                <label for="">Username : </label>
                <input type="text" name="username" class="form-control" Value="<?php echo $user['username']; ?>"/>
            </div>

            <div class="form-group">
                <label for="">First Name : </label>
                <input type="text" name="firstname" class="form-control" Value="<?php echo $user['firstname']; ?>"/>
            </div>
            <div class="form-group">
                <label for="">Last Name : </label>
                <input type="text" name="lastname" class="form-control" Value="<?php echo $user['lastname']; ?>"/>
            </div>

            <div class="form-group">
                <label for="">Email : </label>
                <input type="email" name="email" class="form-control" Value="<?php echo $user['email']; ?>"/>
            </div>   

            <div class="form-group">
                <label for="">Birth date : </label>
                <input type="date" name="birthdate" class="form-control" Value="<?php echo $user['birthdate']; ?>"/>
            </div>

            <div class="form-group">
                <label for="">Description : </label>
                <textarea type="text" name="description" rows="4" cols="50"/><?php echo $user['description']; ?></textarea>
            </div>

            <div class="form-group"> <!-- VALIDER LES MODIFICATIONS -->
                <input type="submit" name="profile" class="btn btn-primary" value="Save"/>
            </div>

        </form>
    </body>
</html>