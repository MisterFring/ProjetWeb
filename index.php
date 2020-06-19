<?php
   session_start();
   require "modules/functions.php";
   
   if(!isset($_SESSION['user_id'])){
       //User not logged in. Redirect them back to the login.php page.
       header('Location: login.php');
       //exit;
   }
   
   $name = "PLEASE SELECT A MUSIC";
   
   if(isset($_POST['oui'])){ 
   
    $id_music = $_POST['id_music'];
    $sql = "SELECT * FROM upload WHERE id = :id_music";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_music', $id_music);
    $stmt->execute(); 
    $music = $stmt->fetch(PDO::FETCH_ASSOC);
   
    $music_title = $music['title'];
    $music_picture = $music['picture'];
    $music_filename = 'https://itescia.praaly.fr/uploads/'.$music['filename'];
    //etc
   
   }
   
   $sql_slit = 'SELECT id, title, filename, description FROM upload';
   $stmt_slist = $pdo->prepare($sql_slit);
   
   $stmt_slist->execute();
   
   $server = $stmt_slist->fetchALL(PDO::FETCH_ASSOC);
   
   
   
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
            <div class="main-">
               <?
                  foreach($server as $row) {
                   print '
                   <div class="content-box"><font color="white">'.$row['title']. ' / '.$row['description'].'</font>
                   <form action="index.php" method="POST">
                    <input type="hidden" name="id_music" value="'.$row['id'].'"> 
                    <input type="submit" name="oui" value="Play">                             
                     </form>
                   </div>';
                  }
                   ?>
            </div>
         </main>
      </div>
      <footer class="audio-player">
         <div id="play-btn"></div>
         <div class="audio-wrapper" id="player-container" href="javascript:;">
            <audio id="player" ontimeupdate="initProgressBar()">
               <source src="<?php if(isset($music_filename)) echo $music_filename?>" type="audio/mp3">
            </audio>
         </div>
         <div class="player-controls scrubber">
            <p><?php if(isset($music_title)) { echo $music_title; } ?></p>
            <span id="seekObjContainer">
            <progress id="seekObj" value="0" max="1"></progress>
            </span>
            <br>
            <small style="float: left; position: relative; left: 15px;" class="start-time"></small>
            <small style="float: right; position: relative; right: 20px;" class="end-time"></small>
         </div>
         <div class="album-image"><img style="height: 150px; width: 150px; margin-left: -50px;" src="https://itescia.praaly.fr/assets/images/musicpictures/<?php if(isset($music_picture)) {echo $music_picture; } ?>">
         </div>
         <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
         <script type="text/javascript" src="assets/js/player.js"></script> 
      </footer>
   </body>
</html>