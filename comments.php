<!DOCTYPE html>
<html>
   <head>
      <title>Comments</title>
   </head>
   <style type="text/css">
      @import url(https://fonts.googleapis.com/css?family=Roboto:300);
      h1, h3
      {
      text-align:center;
      font-family: "Roboto", sans-serif;
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
      button a
      {
      font-family: "Roboto", sans-serif;
      outline: 0;
      width: 100%;
      border: 0;
      margin: 0 0 5px;
      padding: 20px;
      border-radius: 8px;
      color: black;
      font-size: 18px;
      text-decoration: none;
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
      .username {
      font-family: "Roboto", sans-serif;
      font-size: 49px;
      text-align: center;
      }
      .message {
      font-family: "Roboto", sans-serif;
      font-size: 22px;
      text-align: center;
      }
   </style>
   <body>
      <button><a href="forum.php">Back to Topic List</a></button>
      <?php
         session_start();
         //require "modules/bdd.php";
         require "modules/functions.php";
         
         
         // récuperer pseudo via id
         
         
         //récupération du billet
         	$requete = $pdo->prepare('SELECT id,title, content, id_creator, DATE_FORMAT(creation_date, "%d/%m/%Y at %H:%i:%s") AS creation_date_mod FROM topic WHERE id = ? ORDER BY creation_date DESC LIMIT 0, 5');
         	$requete->execute(array($_GET['topic']));
         	$donnees = $requete->fetch();
         		echo "<div class='news'><h3>" . htmlspecialchars($donnees['title'])."	".htmlspecialchars($donnees['creation_date_mod'])." by ".usernameById($donnees['id_creator'])."</h3><p>".htmlspecialchars($donnees['content']). "</p></div>";
         	$requete->closeCursor();
         
         //compteur de commentaires
         
         	$row = $pdo->prepare('SELECT COUNT(*) AS xx FROM comments WHERE id_topic = ?');
         	$row->execute(array($_GET['topic']));
         	$nblignes = $row->fetch();
         	$row->closeCursor();
         
         //affichage des commentaires
         
         	$requete = $pdo->prepare('SELECT id_author, comment, DATE_FORMAT(date_comment, "%d/%m/%Y at %H:%i:%s") AS creation_date_mod FROM comments WHERE id_topic = ? ORDER BY id DESC LIMIT 10');
         	$requete->execute(array($_GET['topic']));
         	
         	if ($nblignes['xx'] == 0) {
         		echo "<h1>No comment in this topic yet</h1>";
         	}
         	else {
         		echo "<h1>Comments</h1>";
         		echo "<table><tr><th>Pseudo</th><th>Message</th><th>Hour</th></tr>";
         		while ($donnees = $requete->fetch()) {
         		echo "<tr><td>" . htmlspecialchars(usernameById($donnees['id_author']))."</td><td>".htmlspecialchars($donnees['comment']). "</td><td>".htmlspecialchars($donnees['creation_date_mod'])."</td></tr>";
         		}
         		echo "</table>";
         	}
         	
         //formulaire pour écrire des commentaires
         
         	echo "<form action='modules/post_comments.php?topic=".$_GET['topic']."'method='POST'>";
         	?>
      <div class="username"><?php echo usernameById($_SESSION['user_id']);?></div>
      </br>
      <label><span class="message">Message : </span><input type="text" name="message"></label>
      <input type="submit" value="Post" />
      </form>
      <?php
         $requete->closeCursor();
         
         ?>
   </body>
</html>