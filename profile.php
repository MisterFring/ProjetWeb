<?php
   session_start(); 
   if(!isset($_SESSION['user_id'])){
       //User not logged in. Redirect them back to the login.php page.
       header('Location: login.php');
       //exit;
   }
   
   /*echo 'Congratulations! You are logged in!';*/
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>ITESFY</title>
      <link rel="stylesheet" type="text/css" href="assets/css/stylemain.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
   </head>
   <body>
      <div class="container">
         <?php include"header.php" ?>
         <nav class="sidebar">Playlists
         </nav>
         <main>
            <div class="main-content">
               <section class="login-page">
                  <section class="form">
                     <form action="modules/updateuser.php" method="post" enctype="multipart/form-data">
                        <!-- <a href="popup.html" onClick="openWin(this.href);return false">Cliquez ici</a> -->
                        <!-- <a href="javascript:change_password()">sdzed</a> -->
                        <a href="modules/change_password.php"><input style="color: red;" type="button" name="change_pwd" value="CHANGE YOUR PASSWORD"></a>              
                        <?php if (isset($error_username)) {
                           echo $error_username;
                           } ?>
                        <div>
                           <label for="username">Username</label>
                           <input type="text" id="username" name="username" Value="<?php echo $_SESSION['user_username']; ?>" required/>
                        </div>
                        <div>
                           <label for="firstname">First Name</label>
                           <input type="text" id="firstname" name="firstname" Value="<?php echo $_SESSION['user_firstname']; ?>" required/>
                        </div>
                        <div>
                           <label for="lastname">Last Name</label>              
                           <input type="text" id="lastname" name="lastname" Value="<?php echo $_SESSION['user_lastname']; ?>" required/>
                        </div>
                        <?php if (isset($error_email)) {
                           echo $error_email;
                           } ?>
                        <div>
                           <label for="email">Email</label>
                           <input type="email" id="email" name="email" Value="<?php echo $_SESSION['user_email']; ?>" required/>
                        </div>
                        <div>
                           <label for="birthdate">Birth date</label>
                           <input type="date" id="birthdate" name="birthdate" Value="<?php echo $_SESSION['user_birthdate']; ?>" required/>
                        </div>
                        <div>
                           <label for="description">Description</label>
                           <textarea placeholder="Description..." type="text" id="description" name="description"><?php echo $_SESSION['user_description']; ?></textarea></br></br>
                        </div>
                        <div class="picture"><img src="assets/images/userpictures/<?php echo $_SESSION['user_image']; ?>" style="height: 150px; width: 150px;">
                        </div>
                        </br></br>
                        <label for="picture">Choose a new picture</label>
                        <div>
                           <input type="file" id="picture" name="image" />
                        </div>
                        <!-- ----------------------- CONFIRM ----------------------- -->
                        <div> 
                           <label for="password">Password Verify</label> 
                           <input placeholder="Confirm your password" id="password" type="text" name="verify" required/>
                        </div>
                        <!-- VALIDATE -->
                        <div> 
                           <input type="submit" name="profile" value="SAVE CHANGES"/>
                        </div>
                     </form>
                  </section>
               </section>
            </div>
         </main>
      </div>
   </body>
</html>