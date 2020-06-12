<?php
require 'modules/bdd.php';

session_start(); 

if(!isset($_SESSION['user_id'])){
    //User not logged in. Redirect them back to the login.php page.
    header('Location: login.php');
    exit;
}

//-------------- CREER UNE FONCTION ? --------------//
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
//-------------- CREER UNE FONCTION/REQUIRE? --------------//

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

       <form action="modules/updateuser.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Username : </label>
                <input type="text" name="username" Value="<?php echo $user['username']; ?>"/>
            </div>

            <div class="form-group">
                <label for="">First Name : </label>
                <input type="text" name="firstname" Value="<?php echo $user['firstname']; ?>"/>
            </div>
            <div class="form-group">
                <label for="">Last Name : </label>
                <input type="text" name="lastname" Value="<?php echo $user['lastname']; ?>"/>
            </div>

            <div class="form-group">
                <label for="">Email : </label>
                <input type="email" name="email" Value="<?php echo $user['email']; ?>"/>
            </div>
            
            <!-- <div class="form-group">
                <label for="">Change Password : </label>
                <input type="password" name="password"/>
            </div>        -->

            <div class="form-group">
                <label for="">Birth date : </label>
                <input type="date" name="birthdate" Value="<?php echo $user['birthdate']; ?>"/>
            </div>

            <div class="form-group">
                <label for="">Description : </label>
                <textarea type="text" name="description" rows="4" cols="50"><?php echo $user['description']; ?></textarea>
            </div>

            <div style="height: 150px;width: 150px;border: 2px solid black;"><img src="assets/images/userpictures/<?php echo $user['image']; ?>" style="height: 150px; width: 150px;"></div>    
            <input type="file" name="image" />

            <!-- ----------------------- CONFIRM ----------------------- -->
            <br/>
            
            <div class="form-group"> 
                <label for="">Password Verify : <?php echo $user['password']; ?></label> 
                <input type="password" name="verify" required/>
            </div>

            <div class="form-group"> <!-- VALIDATE -->
                <input type="submit" name="profile" value="Save"/>
            </div>

        </form>
    </body>
</html>

