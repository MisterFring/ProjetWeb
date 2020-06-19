<?php
   session_start();
   require "functions.php";
   $errorLogName = "<div></div>";
   $errorLogPw = "<div></div>";
   $errorLogMail = "<div></div>";
   $validation = true;
    
   
   // ON GET LES INPUTS
   $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
   $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
   $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
   $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
   $birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;
   $description = !empty($_POST['description']) ? trim($_POST['description']) : null;
   //$pass = !empty($_POST['password']) ? trim($_POST['password']) : null; // CHANGEMENT DU MOT DE PASSE
   $passverify = !empty($_POST['verify']) ? trim($_POST['verify']) : null; //VERIFICATION DU MOT DE PASSE
   
     
   // ====================== UNIQUE CHECKER ====================== //
       // checking the unicity of username & password
       // $unicity_username = checkUnicityOfUsername($username);
       // if (isset($unicity)) {
       //     $validation = false;
       // }
   // ========================================================= //
   
     
   // ON UPDATE LES DONNES 
   $sql = "UPDATE users SET 
       username = :username,
       email = :email,
       firstname = :firstname,
       lastname = :lastname,
       birthdate = :birthdate,
       description = :description
   WHERE id = :id";
   //password = :password
   $stmt = $pdo->prepare($sql);
   // ============================================= BIND VALUES ====================================================== //
   
   if (!empty($username)) {
       //echo "je suis set(usernma)";
       if ($username != $_SESSION['user_username']) {
           $unicity_user = checkUnicityOfUsername($username);
           if (isset($unicity_user)) {
               $validation = false;
               $error_message = 1;
               //echo "je suis rentré la";
           }
           else{
           $stmt->bindValue(':username', $username);
           //echo "je suis rentré ici";
           }
       }
       
       else{
           $stmt->bindValue(':username', $username);
           //echo "je suis rentré sqjkdfvsjdhv";
       }
   }
   else {
       $validation = false;
   }
   // ========================================================= //
   if (!empty($email)) {
       //echo "je suis set(mail)";
       if ($email != $_SESSION['user_email']) {
           $unicity_email = checkUnicityOfEmail($email);
           if (isset($unicity_email)) {
               $validation = false;
               $error_message = 2;
               //echo "je suis rentré la email ";
           }
           else{
           $stmt->bindValue(':email', $email);
           //echo "je suis rentré ici email ";
           }
       }
       
       else{
           $stmt->bindValue(':email', $email);
           //echo "je suis rentré sqjkdfvsjdhv email ";
       }
   }
   else {
       $validation = false;
   }
   // ========================================================= //
   // vérifier si firstname != session fisrtname 
   if ($fisrtname != $_SESSION['user_firstname']) {
       $stmt->bindValue(':firstname', $firstname);
       ////echo "je suis set firstname";
   }
   else {
       $stmt->bindValue(':firstname', $_SESSION['user_firstname']);
       ////echo "je suis set PAS firstname";
   }
   // ========================================================= //

   if ($lastname != $_SESSION['user_lastname']) {
       $stmt->bindValue(':lastname', $lastname);
   }
   else {
       $stmt->bindValue(':lastname', $_SESSION['user_lastname']);
   }
   // ========================================================= //
   if ($birthdate != $_SESSION['user_birthdate']) {
       $stmt->bindValue(':birthdate', $birthdate);
   }
   else {
       $stmt->bindValue(':birthdate', $_SESSION['user_birthdate']);
   }
   // ========================================================= //
   if ($description != $_SESSION['user_description']) {
       $stmt->bindValue(':description', $description);
   }
   else {
       $stmt->bindValue(':description', $_SESSION['user_description']);
   }
   // ========================================================= //

   $stmt->bindValue(':id', $_SESSION['user_id']);
// ================================================================================================================= //

   
   
   //$stmt->bindValue(':password', $passwordHash);
   //$passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
   
   // IMAGE
   if (isset($_FILES['image'])) {
       if($_FILES['image']['size'] == 0) { 
       //IF NO PICTURE THEN DO NOTHING
       }
       else{
           $folder ="../assets/images/userpictures/"; 
           $image = $_FILES['image']['name']; 
           $path = $folder . $image ; 
   
           $target_file=$folder.basename($_FILES["image"]["name"]);
           $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
   
           $allowed=array('jpeg','png' ,'jpg'); 
   
           $filename=$_FILES['image']['name'];
   
           
           $ext=pathinfo($filename, PATHINFO_EXTENSION);
   
           if(!in_array($ext,$allowed) ) {
                   
               echo "Sorry, only JPG, JPEG, PNG & GIF  files are allowed.";
           }
           else { 
               move_uploaded_file($_FILES['image'] ['tmp_name'], $path);
                   
               $sth=$pdo->prepare("UPDATE users SET image = :image WHERE id = :id");  
               $sth->bindValue(':id', $_SESSION['user_id']);
               $sth->bindValue(':image', $image); 
               $sth->execute(); 
           }
       }
   }
   
   
   //---------------------------------
   // $hash = $user['password'];
   //  if (password_verify($passverify, $hash)) {
   //      $result = $stmt->execute(); 
   //  } 
   //  else {
   //      //echo $user['password'];
   //      //echo 'Le mot de passe est invalide!'; // TRANSFORMER EN ERREUR SUR LA PAGE
   //  } 
   //---------------------------------
   
   if ($validation===true) {
       $result = $stmt->execute();
   }
   else {
       header('Location: ../profile.php?error='.$error_message.'');
   }
   
   if(isset($result)){
       updateSession($email);
       header('Location: ../profile.php');
   }
   ?>