<?php
   session_start();
   require 'modules/functions.php';
   
   $errorLogName = "<div></div>";
   $errorLogPw = "<div></div>";
   $errorLogMail = "<div></div>";
   $validation = true;
   
   
   
   if(isset($_POST['register'])){
   
   
       // ====================== RETRIEVE POST VALUES ====================== //
       //Retrieve the field values from our registration form. CONDITIONS TERNAIRES 
       $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
       $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
       $email = !empty($_POST['email']) ? trim($_POST['email']) : null; 
       $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
       $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
       $birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;
       // ================================================================= //
   
   
       // ====================== CONFIRMATION PASSWORD ====================== //
       // checking the equality of the two passwords
       $pwd_corresp = checkCorrespondanceBetween2Passwords($_POST['password'], $_POST['confirm_password']);
       if ($pwd_corresp === false) {
           $errorLogPw = '<div style="font-style: italic; font-weight: bold; text-align: center">The 2 passwords are different</div></br>';
           $validation = false;
       }
       // ========================================================= //
       
   
       // ====================== UNIQUE CHECKER ====================== //
       // checking the unicity of username & password
       $unicity = checkUnicityOfUsernameAndEmail($username, $email);
       if (isset($unicity)) {
           $validation = false;
       }
       // ========================================================= //
   
   
       // ====================== REGEX ON PASSWORD ====================== //
       $response_pwd = check_password($pass);
       // ========================================================= //
   
   
       // ====================== INSERT INTO DB ====================== //
       if ($response_pwd === true && $validation === true) {
           require 'modules/bdd.php';
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
           
           // Send welcome Email
           send_mail($email);
   
           // Redirect to login page
           header('Location: login.php');
       }
       // ========================================================= //
   }
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Register</title>
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
   </head>
   <body>
      <section class="login-page">
         <section class="form">
            <h1>Register</h1>
            <form action="register.php" method="post">
               <?php if(isset($unicity)) echo $unicity;?>
               <div>
                  <input type="text" placeholder="username" name="username" class="form-control" required/>
               </div>
               <div>
                  <input type="text" placeholder="firstname" name="firstname" class="form-control" required/>
               </div>
               <div>
                  <input type="text" placeholder="lastname" name="lastname" class="form-control" required/>
               </div>
               <div>
                  <input type="email" placeholder="email" name="email" class="form-control" required/>
               </div>
               <div>
                  <input type="date" placeholder="birthdate" name="birthdate" class="form-control" required/>
               </div>
               <?php if ((!empty($_POST['password'])) && $response_pwd !=1){
                  echo $response_pwd;
                  }?>
               <p id="regexVerif"></p>
               <div>
                  <input type="text" id="password" placeholder="password" name="password" class="form-control" onkeyup="regexOnPassword();" required/>
               </div>
               <?php echo $errorLogPw;?>
               <div>
                  <input type="text" id="check_password" placeholder="confirm password" name="confirm_password" class="form-control" onkeyup="checkEqualityOnPasswords()" disabled="true" />
               </div>
               <div id="verif"></div>
               <div>
                  <input id="validation" type="submit" name="register" class="btn btn-primary" value="SIGN IN" disabled="true" />
               </div>
            </form>
         </section>
      </section>
      <script type="text/javascript" src="assets/js/player.js"></script> 
   </body>
</html>