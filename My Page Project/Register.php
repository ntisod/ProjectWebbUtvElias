<!DOCTYPE HTML>  
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="RegisterStyle.css">
</head>
<body>  
<?php
define('BASEPATH', true);
require('Pform/db.php'); 

//If the item with the type submit if clicked appy the followed:
 if(isset($_POST['submit'])){  
   //Applies certain values
        try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
            //Gives values to items with the following names
         $user = $_POST['username'];
         $email = $_POST['email'];
         $pass = $_POST['password'];
         
         //Encrypt password
         $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
          
         //Check if username exists
         $sql = "SELECT COUNT(username) AS num FROM admin WHERE username =      :username";
         $stmt = $pdo->prepare($sql);

         $stmt->bindValue(':username', $user);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         //Check if Email exists
         $sql = "SELECT COUNT(email) AS num FROM admin WHERE email =      :email";
         $stmt = $pdo->prepare($sql);

         $stmt->bindValue(':email', $email);
         $stmt->execute();
         $rowE = $stmt->fetch(PDO::FETCH_ASSOC);

         //If name already exist, give an alert
         if($row['num'] > 0){
             echo '<script>alert("Username already exists")</script>';
        }
        //If Email already exist, give an alert
        else if ($rowE['num'] > 0){
          echo '<script>alert("Email already exists")</script>';
        }

       else{

        //If the name and mail do not exist, continue and fill out the information / create account
    $stmt = $dsn->prepare("INSERT INTO admin (username, email, password) 
    VALUES (:username,:email, :password)");
    $stmt->bindParam(':username', $user);    
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);
    header("login.php");
    
//If stmt was executed give out the following script alert.
   if($stmt->execute()){
    echo '<script>alert("New account created.")</script>';
    
    echo '<script>window.location.replace("login.php")</script>';
     
   }else{
       echo '<script>alert("An error occurred")</script>';
   }
}
//Catch errors with catch PDOException
}catch(PDOException $e){
    $error = "Error: " . $e->getMessage();
    echo '<script type="text/javascript">alert("'.$error.'");</script>';
}
     }    
?>

<form action="Register.php" method="post">
  <!-- Image box: -->
<div class="img-box">
<img src="BlackPFP.png" alt="Avatar" style="width:200px">
</div>
<br>
  <!-- Username text box + type, required, name and placeholder -->
  <input type="text" required="required" name="username" placeholder="Username">
  <br><br>
  <!-- Email text box + values -->
  <input required="required" type="email" name="email" placeholder="Email">
  <br><br>
  <!-- Showpassword button -->
  <input type="checkbox" onclick="ShowPasswordFunction()">Show password
  <!-- Password text box + value, type, name, id and placeholder -->
  <input required="required" type="password" name="password" placeholder="Password" id="ShowPassword">   
  <br> <br>      
  <!-- Register button -->         
  <button name="submit" type="submit">Register</button>
  </form>
  
  <!-- The script section is used to show password  -->
  <script>
function ShowPasswordFunction() {
  var x = document.getElementById("ShowPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
  </html>