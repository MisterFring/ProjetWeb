<?php
   require "bdd.php";
   
   
   function send_mail($email){
       $to      =  $email;
       $subject = '[ITEFY] Thank you for registering on our website.';
       $message = 'Thank you for registering on our website.';
       $headers = array(
           'From' => 'support@itefy.com',
           'Reply-To' => 'notreply@itefy.com',
           'X-Mailer' => 'PHP/' . phpversion()
       );
       mail($to, $subject, $message, $headers);
   }
   function check_password($password){
       $error = null;
       if( strlen($password ) < 8 ) {
       $error .= "Password too short!
       ";
       }
       if( strlen($password ) > 20 ) {
       $error .= "Password too long!
       ";
       }
       if( !preg_match("#[0-9]+#", $password ) ) {
       $error .= "Password must include at least one number!
       ";
       }
       if( !preg_match("#[a-z]+#", $password ) ) {
       $error .= "Password must include at least one letter!
       ";
       }
       if( !preg_match("#[A-Z]+#", $password ) ) {
       $error .= "Password must include at least one CAPS!
       ";
       }
       if( !preg_match("#\W+#", $password ) ) {
       $error .= "Password must include at least one symbol!
       ";
       }
   
       if($error){    
           $errorLogPw_2 = '<div style="font-style: italic; font-weight: bold; text-align: center">Password validation failure '.$error.'</div></br>';
           return $errorLogPw_2;
       } else {
           return true;
       }
   }
   function usernameById($id){
       $pdoOptions = array(
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_EMULATE_PREPARES => false
       );
       $pdo = new PDO(
       "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
       MYSQL_USER, //Username
       MYSQL_PASSWORD, //Password
       $pdoOptions //Options
       );
       $requete = $pdo->prepare('SELECT username FROM users WHERE id = ?');
       $requete->execute(array($id));
       $res = $requete->fetch();
       $requete->closeCursor();
       return $res['username'];
   }
   function checkCorrespondanceBetween2Passwords($firstPass, $secondPass){
       if ($firstPass!=$secondPass) {
           return false;
       }
       else {
           return true;
       }
   }
   function checkUnicityOfUsernameAndEmail($username, $email){
       $pdoOptions = array(
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_EMULATE_PREPARES => false
       );
       $pdo = new PDO(
       "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
       MYSQL_USER, //Username
       MYSQL_PASSWORD, //Password
       $pdoOptions //Options
       );
       $sql = "SELECT username, email FROM users WHERE username = :username || email = :email";
       $stmt = $pdo->prepare($sql);
       
       $stmt->bindValue(':username', $username);
       $stmt->bindValue(':email', $email);
       $stmt->execute();
   
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
       foreach ($row as $valuecheck) {
           if($username == $valuecheck['username']){
               $errorLogName = '<div style="font-style: italic; font-weight: bold; text-align: center">That username already exists !</div></br>';
               return $errorLogName;
               break;
           }
           if($email == $valuecheck['email']){
               $errorLogMail = '<div style="font-style: italic; font-weight: bold; text-align: center">That email is already registered !</div></br>';
               return $errorLogMail;
               break;
           }
   
       }
   }
   function checkUnicityOfUsername($username){
       $pdoOptions = array(
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_EMULATE_PREPARES => false
       );
       $pdo = new PDO(
       "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
       MYSQL_USER, //Username
       MYSQL_PASSWORD, //Password
       $pdoOptions //Options
       );
       $sql = "SELECT username FROM users WHERE username = :username";
       $stmt = $pdo->prepare($sql);
       
       $stmt->bindValue(':username', $username);
       $stmt->execute();
   
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
       foreach ($row as $valuecheck) {
           if($username == $valuecheck['username']){
               $errorLogName = '<div style="font-style: italic; font-weight: bold; text-align: center">That username already exists !</div></br>';
               return $errorLogName;
               break;
           }
       }
   }
   function checkUnicityOfEmail($email){
       $pdoOptions = array(
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_EMULATE_PREPARES => false
       );
       $pdo = new PDO(
       "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
       MYSQL_USER, //Username
       MYSQL_PASSWORD, //Password
       $pdoOptions //Options
       );
       $sql = "SELECT email FROM users WHERE email = :email";
       $stmt = $pdo->prepare($sql);
       
       $stmt->bindValue(':email', $email);
       $stmt->execute();
   
       $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
       foreach ($row as $valuecheck) {
           if($email == $valuecheck['email']){
               $errorLogName = '<div style="font-style: italic; font-weight: bold; text-align: center">That email already exists !</div></br>';
               return $errorLogName;
               break;
           }
       }
   }
   function updateSession($email){
       $pdoOptions = array(
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_EMULATE_PREPARES => false
       );
       $pdo = new PDO(
       "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
       MYSQL_USER, //Username
       MYSQL_PASSWORD, //Password
       $pdoOptions //Options
       );
       $sql = "SELECT * FROM users WHERE email = :email";
       $stmt = $pdo->prepare($sql);
       
       $stmt->bindValue(':email', $email);
       
       $stmt->execute();
       
       $user = $stmt->fetch();
   
       $_SESSION['user_id'] = $user['id'];
       $_SESSION['user_username'] = $user['username'];
       $_SESSION['user_email'] = $user['email'];
       $_SESSION['user_firstname'] = $user['firstname'];
       $_SESSION['user_lastname'] = $user['lastname'];
       $_SESSION['user_birthdate'] = $user['birthdate'];
       $_SESSION['user_description'] = $user['description'];
       $_SESSION['user_image'] = $user['image'];
       $_SESSION['user_password'] = $user['password'];
   }
   
   
   
   ?>