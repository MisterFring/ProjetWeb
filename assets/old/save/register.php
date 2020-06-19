<?php
session_start();
require 'modules/bdd.php';
require 'modules/functions.php';

$errorLogName = "<div></div>";
$errorLogPw = "<div></div>";
$errorLogMail = "<div></div>";



if(isset($_POST['register'])){
    
    //Retrieve the field values from our registration form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;

    $birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;

    // checking the equality of the two passwords

    // if (($_POST['password'])!=($_POST['confirm_password'])) {
    //     $errorLogPw = '<div style="font-style: italic; font-weight: bold; text-align: center">The 2 passwords are different</div></br>';
    //     $validation = false;
    // }
    
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
    if (check_password($pass) === true) {
       
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
        
        send_mail($email);
        header('Location: login.php');
 
   
     
    }
    else{
        echo 'fhjkdjksdjkskjhdf';
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
    </style>
    <body>
    <section class="login-page">
    <section class="form">
    <h1>Register</h1>
       <form action="register.php" method="post">
       <?php echo $errorLogName;?>
            <div>
                <input type="text" placeholder="username" name="username" class="form-control" required/>
            </div>

            <div>
                <input type="text" placeholder="firstname" name="firstname" class="form-control" required/>
            </div>
            <div>
                <input type="text" placeholder="lastname" name="lastname" class="form-control" required/>
            </div>
            <?php echo $errorLogMail;?>
            <div>
                <input type="email" placeholder="email" name="email" class="form-control" required/>
            </div>   

            <div>
                <input type="date" placeholder="birthdate" name="birthdate" class="form-control" required/>
            </div>
            <?php if (isset($_POST['password'])){
                echo check_password($pass);
            }?>            
            <div>
                <input type="te"  placeholder="password" name="password" class="form-control" required/>
            </div>

            <?php echo $errorLogPw;?>
            <div>
                <input type="password" placeholder="confirm_password" name="confirm_password" class="form-control"/>
            </div>

            <div>
                <input type="submit" name="register" class="btn btn-primary" value="SIGN IN"/>
            </div>
        </section>
        </section>
        </form>
    </body>
</html>