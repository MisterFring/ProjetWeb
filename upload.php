<?php
   session_start(); 
   require "modules/functions.php";
   
   if(!isset($_SESSION['user_id'])){
       //User not logged in. Redirect them back to the login.php page.
       header('Location: login.php');
       //exit;
   }
   
    if(isset($_POST['upload'])){ 
     
      $title = !empty($_POST['title']) ? trim($_POST['title']) : null;
      $description = !empty($_POST['description']) ? trim($_POST['description']) : null;
      $tag = !empty($_POST['tag']) ? trim($_POST['tag']) : null;
     
      $sql = "INSERT INTO upload (title, filename, description, tag, picture) VALUES (:title, :filename, :description, :tag, :picture)";
      $stmt = $pdo->prepare($sql);
     
      
      $content_dir = 'uploads/'; // dossier où sera déplacé le fichier
   
          $tmp_file = $_FILES['file']['tmp_name'];
   
          
          if( !is_uploaded_file($tmp_file) )
          {
              exit("Le fichier est introuvable");
          }
   
          // on vérifie maintenant l'extension
          $type_file = $_FILES['file']['type'];
   
          if( !strstr($type_file, 'audio') && !strstr($type_file, 'mpeg '))
          {
              exit("Le fichier n'est pas une image");
          }
   
          // on copie le fichier dans le dossier de destination
          $name_file = $_FILES['file']['name'];
   
          if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
          {
              exit("Impossible de copier le fichier dans $content_dir");
          }
   
          echo "Le fichier a bien été uploadé";
   
      // ----------------------------------------------------------------
        $folder ="assets/images/musicpictures/"; 
        $image = $_FILES['image']['name']; 
        $path = $folder . $image ; 
   
        $target_file=$folder.basename($_FILES["image"]["name"]);
        $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
   
        $allowed=array('jpeg','png' ,'jpg'); 
   
        $filename=$_FILES['image']['name'];
   
        print_r($_FILES);
   
        $ext=pathinfo($filename, PATHINFO_EXTENSION);
   
        if(!in_array($ext,$allowed) ) {
                
            echo "Sorry, only JPG, JPEG, PNG & GIF  files are allowed.";
        }
        else { 
            move_uploaded_file($_FILES['image'] ['tmp_name'], $path);             
           
        }
    
   
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':filename', $name_file);  
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':tag', $tag);  
      $stmt->bindValue(':picture', $_FILES['image']['name']);   
   
      $result = $stmt->execute();
   }
   
   ?>
<form action="upload.php" method="POST"  enctype="multipart/form-data">
   <section>
      <div>
         <label for="title">Title</label>
         <input type="text" id="firstname" name="title"  />
      </div>
      <div>
         <label for="description">Description</label>
         <input type="text" id="firstname" name="description"  />
      </div>
      <div>
         <label for="tag">Tag</label>
         <input type="text" id="firstname" name="tag" />
      </div>
      <label for="picture">Choose a new picture</label>
      <div>
         <input type="file" id="picture" name="image" />
      </div>
      <label for="file"><span>Filename:</span></label> 
      <input type="file" name="file" id="file" /> 
      <div> 
         <input type="submit" name="upload" value="SAVE CHANGES"/>
      </div>
   </section>
</form>