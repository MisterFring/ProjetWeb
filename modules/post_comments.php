<?php
   session_start();
   require "bdd.php";
   
   $id_author = $_SESSION['user_id'];
   $message = $_POST['message'];
   $getId = $_GET['topic'];
   
   	$requete = $pdo->prepare('INSERT INTO comments (id_topic, id_author, comment, date_comment) VALUES (:id_billet, :auteur, :com, NOW())');
   	$requete->bindParam(':id_billet', $getId);
   	$requete->bindParam(':auteur', $id_author);
   	$requete->bindParam(':com', $message);
   	$requete->execute();
   
   header("Location: ../comments.php?topic=$getId");
   ?>