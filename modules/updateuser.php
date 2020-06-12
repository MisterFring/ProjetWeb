<?php
require 'bdd.php';
session_start(); 

//-------------- CREER UNE FONCTION/REQUIRE ? --------------//
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
//-------------- CREER UNE FONCTION/REQUIRE ? --------------//

// ON GET LES INPUTS
$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
$firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
$lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
$birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;
$description = !empty($_POST['description']) ? trim($_POST['description']) : null;
//$pass = !empty($_POST['password']) ? trim($_POST['password']) : null; // CHANGEMENT DU MOT DE PASSE
$passverify = !empty($_POST['verify']) ? trim($_POST['verify']) : null; //VERIFICATION DU MOT DE PASSE


// ON UPDATE LES DONNES 
$sql = "UPDATE users SET 
    username = :username,
    email = :email,
    firstname = :firstname,
    lastname = :lastname,
    birthdate = :birthdate,
    description = :description
WHERE id= :id";
//password = :password

$stmt = $pdo->prepare($sql);
    
$stmt->bindValue(':username', $username);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':firstname', $firstname);
$stmt->bindValue(':lastname', $lastname);
$stmt->bindValue(':birthdate', $birthdate);
$stmt->bindValue(':description', $description);
//$stmt->bindValue(':password', $passwordHash);
$stmt->bindValue(':id', $_SESSION['user_id']);

//$passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

// IMAGE
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

//---------------------------------
$hash = $user['password'];
 if (password_verify($passverify, $hash)) {
     $result = $stmt->execute(); 
 } 
 else {
     echo $user['password'];
     echo 'Le mot de passe est invalide!'; // TRANSFORMER EN ERREUR SUR LA PAGE
 } 
//---------------------------------



if($result){
    header('Location: ../profile.php');
}

?>

