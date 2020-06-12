
<?php
session_start();
require 'bdd.php';
require 'functions.php';

$errorLogName = "<div></div>";
$errorLogPw = "<div></div>";
$errorLogMail = "<div></div>";
$validation = true;

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
        $errorLogPw = '<div style="font-style: italic; font-weight: bold; text-align: center">The 2 passwords are different</div></br>';
        $validation = false;
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
        $errorLogName = '<div style="font-style: italic; font-weight: bold; text-align: center">That username already exists !</div></br>';
            $validation = false;
            break;
        }
        if($email == $valuecheck['email']){
            $errorLogMail = '<div style="font-style: italic; font-weight: bold; text-align: center">That email is already registered !</div></br>';
            $validation = false;
            break;
        }

    }

    // ========================================================= //
    if ($validation) {
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

            send_mail($email);
            header('Location: login.php');


        }    
    }
}
?>