<?php
require 'bdd.php';

session_start(); 

// function refresh_session(){
//     $sql = ("SELECT username, firstname, lastname, birthdate, FROM users WHERE id = :id");
//     $stmt = $pdo->prepare($sql);
//     //$stmt->bindValue(':id', 30);     
//     $stmt->execute();
//     $response = $stmt->fetch();
//     print_r($response);
//     $_SESSION['user_username']=$response['username'];
//     $_SESSION['user_firstname']=$response['firstname'];
//     $_SESSION['user_lastname']=$response['lastname'];
//     $_SESSION['user_birthdate']=$response['birthdate'];
//     //$_SESSION['user_description']=$response['description'];

// }


$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
$firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
$lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
$birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;

$sql = "UPDATE users SET 
    username = :username,
    email = :email,
    firstname = :firstname,
    lastname = :lastname,
    birthdate = :birthdate
WHERE id= 30";

$stmt = $pdo->prepare($sql);
    
$stmt->bindValue(':username', $username);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':firstname', $firstname);
$stmt->bindValue(':lastname', $lastname);
$stmt->bindValue(':birthdate', $birthdate);
    
$result = $stmt->execute();
    
if($result){
    // refresh_session();
    header('Location: ../profile.php');
}

?>