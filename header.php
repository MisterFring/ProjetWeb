<header>
   <nav class="headerstyle">
      <div>
         <form action="">
            <input type="search">
            <i class="fa fa-search"></i>
         </form>
      </div>
      <div style="margin-left: auto;">
         <h1 style="color: white;"><a href="https://itescia.praaly.fr/index.php"> ITESFY</a></h1>
      </div>
      <div style="margin-left: auto; margin-top: 5px;margin-right: 30px">
         <a href="forum.php"><button class="forum">Forum</button></a>
         <a href="upload.php"><button class="forum">Upload</button></a>
      </div>
      <div class="headermargin"><img src="assets/images/userpictures/<?php echo $_SESSION['user_image'];?>" alt="Avatar"></div>
      <div style="margin-right: 10px; margin-top: 18px">
         <div class="dropdown">
            <button class="dropbtn"><?php echo $_SESSION['user_username']?></button>
            <div class="dropdown-content">
               <a href="profile.php">Settings</a>
               <a href="modules/logout.php">Log Out</a>
            </div>
         </div>
      </div>
   </nav>
</header>