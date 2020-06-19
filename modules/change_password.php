<?php
   session_start();
   require "functions.php";
   
   // ====================== RETRIEVE POST DATAS ====================== //
   $previous_pwd = !empty($_POST['previous_pwd']) ? trim($_POST['previous_pwd']) : null;
   $new_pwd = !empty($_POST['new_pwd']) ? trim($_POST['new_pwd']) : null;
   $confirm_new_pwd = !empty($_POST['confirm_new_pwd']) ? trim($_POST['confirm_new_pwd']) : null;
   // ========================================================= //
   
   
   // ====================== APPLY FUNCTIONS ON PASSWORDS ====================== //
   $validPassword = password_verify($previous_pwd, $_SESSION['user_password']);
   $regexMatch = check_password($new_pwd);
   $bool = checkCorrespondanceBetween2Passwords($new_pwd, $confirm_new_pwd);
   // ========================================================= //
   
   
   // ====================== CONDITIONS & ERRORS ====================== //
   if (isset($_POST['validate'])) {
   	if ($validPassword) {
   		if ($regexMatch === true) {
   			if ($bool) {
   					$new_pwd_hash = password_hash($new_pwd, PASSWORD_BCRYPT, array("cost" => 12));
   					$sql = "UPDATE users SET 
   				    password = :password
   					WHERE id = :id";
   					$stmt = $pdo->prepare($sql);
   					$stmt->bindValue(':password', $new_pwd_hash);
   					$stmt->bindValue(':id', $_SESSION['user_id']);
   					$stmt->execute();
   					updateSession($_SESSION['user_email']);
   					header('Location: ../profile.php');
   			}
   			else{
   				$error = 'Your confirmation password was wrong';
   			}
   		}
   		else {
   			$error = $regexMatch;
   		}
   	}
   	else {
   		$error = 'Your password does not match the one associated with your account';
   	}
   }
   // ========================================================= //
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title></title>
   </head>
   <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
   <body>
      <section class="login-page">
         <section class="form">
            <form action="change_password.php" method="post">
               <?php if (isset($error)) {
                  echo $error;
                  }?>
               <div>
                  <input placeholder="Previous password" type="text" name="previous_pwd" required/>
               </div>
               <p id="regexVerif"></p>
               <div> 
                  <input id="password" placeholder="New Password" type="text" name="new_pwd" onkeyup="regexOnPassword();" required/>
               </div>
               <div> 
                  <input id="check_password" placeholder="Confirm your new password" type="text" name="confirm_new_pwd" onkeyup="checkEqualityOnPasswords()" required disabled="true" />
               </div>
               <div id="verif"></div>
               <div>
                  <input id="validation" type="submit" name="validate" class="btn btn-primary" value="VALIDATE" disabled="true" />
               </div>
            </form>
         </section>
      </section>
      <script type="text/javascript" src="../assets/js/player.js"></script>
   </body>
</html>