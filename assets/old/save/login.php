<?php
session_start();
 
require 'modules/bdd.php';
$errorLog = "<div></div>";

if(isset($_POST['login'])){
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user === false){
        $errorLog = '<div style="font-style: italic; font-weight: bold">Incorrect username / password combination !</div></br>';
    } 
    else {
        $validPassword = password_verify($passwordAttempt, $user['password']);
            
        if($validPassword){
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_firstname'] = $user['firstname'];
            $_SESSION['user_lastname'] = $user['lastname'];
            $_SESSION['user_birthdate'] = $user['birthdate'];
            $_SESSION['user_description'] = $user['description'];
            $_SESSION['user_image'] = $user['image'];
          
            
            header('Location: profile.php');
            exit;
            
        } 
        else {$errorLog = "<div>Incorrect username / password combination!</div>";}
        }
     
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>

    <body>
        <div class="login-page">
        <div class="form">
            <center style="margin-top: -30px;"><img src="assets/images/itescia.png" height="120px" width="120px" />
            <h2>TO CONTINUE, LOGIN TO ITESFY.</h2></center>
                <?php echo $errorLog;?>
                <form action="login.php" method="post">
                    <input type="text" name="email" id="email" placeholder="EMAIL"><br>
                    <input type="text" name="password" id="password" placeholder="PASSWORD"><br>
                
                <div class="login">
                    <input type="checkbox" name="remember-me"><label for="remember-me">REMEMBER ME</label>
                    <span class="checkmark"></span>
                    <button type="submit" name="login">Log In</button>
                </div>
                
                <br/>
                </form>
                <p class="message">NOT REGISTERED ? <a href="register.php">SIGN IN</a></p>
                <br/>
                <div class="google-btn">
                    <button>Continue with Google</button>
                </div>
        </div>
        </div>
    </body>
</html>