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
   
   $sql_slit = 'SELECT id, title, filename FROM upload';
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
      <style type="text/css">
      <style type="text/css">
         @import url(https://fonts.googleapis.com/css?family=Roboto:300);
         h1, h3
         {
         text-align:center;
         }
         h3
         {
         background: #07051a;
         color:white;
         font-size:1em;
         margin-bottom:0px;
         font-family: "Roboto", sans-serif;
         padding: 5px;
         border-radius: 8px;
         }
         .news p
         {
         background-color:#FFCDD2;
         margin-top:0px;
         font-family: "Roboto", sans-serif;
         padding: 5px;
         border-radius: 8px;
         }
         .news
         {
         width:70%;
         margin:auto;
         }
         a
         {
         text-decoration: none;
         color: blue;
         box-sizing: border-box;
         }
         table {
         margin-top: 30px;
         border: medium solid #6495ed;
         border-collapse: collapse;
         width: 50%;
         }
         th {
         font-family: monospace;
         border: thin solid #6495ed;
         width: 50%;
         padding: 5px;
         background-color: #D0E3FA;
         background-image: url(sky.jpg);
         }
         td {
         font-family: sans-serif;
         border: thin solid #6495ed;
         width: 50%;
         padding: 5px;
         text-align: center;
         background-color: #ffffff;
         }
         form {
         position: relative;
         z-index: 1;
         background: #FFCDD2;
         width: 300px;
         height: 300px;
         padding: 30px;
         box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
         border-radius: 8px;
         margin-right: auto;
         margin-left: auto;
         }
         form input {
         font-family: "Roboto", sans-serif;
         outline: 0;
         background: #f2f2f2;
         width: 100%;
         border: 0;
         margin: 0 0 5px;
         padding: 20px;
         box-sizing: border-box;
         font-size: 15px;
         border-radius: 8px;
         }
         caption {
         font-family: sans-serif;
         }
      </style>
      </style>
   </head>
   <body>
      <div class="container">
         <?php include"header.php" ?>
         <nav class="sidebar">Playlists
         </nav>
         <main>
            <?php
               if (isset($_POST['new_topic'])) {
                 $tile = !empty($_POST['title']) ? trim($_POST['title']) : null;
                 $content = !empty($_POST['content']) ? trim($_POST['content']) : null;
               
                 $requete = $pdo->prepare('INSERT INTO topic (id_creator, title, content, creation_date) VALUES (:id_user, :title, :content, NOW())');
                 $requete->bindParam(':id_user', $_SESSION['user_id']);
                 $requete->bindParam(':title', $_POST['title']);
                 $requete->bindParam(':content', $_POST['content']);
               
                 $requete->execute();
               
               }
               
               // Display 5 last topics
               $requete = $pdo->query('SELECT id,title, content, id_creator, DATE_FORMAT(creation_date, "%d/%m/%Y at %H:%i:%s") AS creation_date_mod FROM topic ORDER BY creation_date DESC LIMIT 0, 5');
               
               while ($data = $requete->fetch()) {
                 echo "<div class='news'><h3>" . htmlspecialchars($data['title'])."  ".htmlspecialchars($data['creation_date_mod'])." by ".usernameById($data['id_creator'])."</h3><p>".htmlspecialchars($data['content']). "<br/><a href='comments.php?topic=".$data['id']."'>Comments</a></p></div>";
               }
               $requete->closeCursor();
               
               ?>
            <form action="forum.php" method="POST">
               <h3>Post a new topic</h3>
               </br>
               <input type="text" name="title" placeholder="title">
               <input type="text" name="content" placeholder="content"></br></br>
               <input type="submit" name="new_topic" value="Submit">
            </form>
         </main>
      </div>
   </body>
</html>