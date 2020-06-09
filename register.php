<?php
session_start();

require 'modules/bdd.php';

if(isset($_POST['register'])){
    
    //Retrieve the field values from our registration form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;

    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;

    $birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;

    // checking the equality of the two passwords

    if (($_POST['password'])!=($_POST['confirm_password'])) {
    	exit('The 2 passwords are different');
    }
    
    // ====================== UNIQUE CHECKER ====================== //
    // checking the unicity of username & password
    $sql = "SELECT username, email FROM users WHERE username = :username || email = :email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $valuecheck) {
      if($username == $valuecheck['username']){
            exit('That username already exists!');
        }
        if($email == $valuecheck['email']){
            exit('That email is already registered!');
        }
    }
   
    // ========================================================= //

    $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
       
    $sql = "INSERT INTO users (username, password, email, firstname, lastname, birthdate) VALUES (:username, :password, :email, :firstname, :lastname, :birthdate)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':email', $email);

    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':birthdate', $birthdate);
 
    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        echo 'Thank you for registering with our website.';
    }    
}

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
    <h1>Register</h1>

       <form action="register.php" method="post">
            <div class="form-group">
                <label for="">Username* : </label>
                <input type="text" name="username" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="">First Name : </label>
                <input type="text" name="firstname" class="form-control" required/>
            </div>
            <div class="form-group">
                <label for="">Last Name : </label>
                <input type="text" name="lastname" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="">Email* : </label>
                <input type="email" name="email" class="form-control" required/>
            </div>   

            <div class="form-group">
                <label for="">Birth date : </label>
                <input type="date" name="birthdate" class="form-control" required/>
            </div>
         
            <div class="form-group">
                <label for="">Password* : </label>
                <input type="password" name="password" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="">Confirm Password* : </label>
                <input type="password" name="confirm_password" class="form-control" required/>
            </div>

            <div class="form-group">
                <input type="submit" name="register" class="btn btn-primary" value="Register"/>
            </div>

        </form>
    </body>
</html>