<?php
    session_start();
    
    $Min=60;
define('BASEPATH', true); //access connection script if you omit this line file will be blank
require('Pform/db.php'); //require connection script

if(isset($_POST['submit'])){  
        // try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Forgot this code's function, i will come back to it.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT id, username, password FROM admin WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetches information.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
    //If $row is false statement. If fetching user went wrong.
    if($user === false){
       echo '<script>alert("invalid username")</script>';
    } else{
         
        //Compare and decrypt passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);
        
        //If validPassword is true.
        if($validPassword){
            
            //Re-directs user.
             
            $_SESSION['admin'] = $username;
           //Removed something here temporaraly (Do not tinker with this u stupid elias, u will ruin it.)

           $v1 = $_POST['username'];
           $v2 = $_POST['password'];
           $v3 = $_POST['username'];
           $v4 = $_POST['password'];
           if ($v1 == $v3 && $v2 == $v4) {
               $_SESSION['luser'] = $v1;
               $_SESSION['start'] = time(); // Taking now logged in time.
               // Ending a session in 1 minutes from the starting time.
               $_SESSION['expire'] = $_SESSION['start'] + (1 * $Min);
               echo '<script>window.location.replace("index.php");</script>';
           } else {
               echo "Please enter the username or password again!";
           }

            exit;
            
        } else{
            //If password false, then print this message..
            echo '<script>alert("invalid password")</script>';
        }
    } 
    }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="LoginStyle2.css">
</head>
<body>   

<form action="login.php" method="post">
 <!-- Image box: -->
<div class="img-box">
<img src="CyanPFP.png" alt="Avatar" style="width:200px">
</div>        
<!-- Username text box + type, name and placeholder -->
 <input type="text" name="username" placeholder="Username">
 <br><br>
 <!-- Showpassword button -->
 <input type="checkbox" onclick="ShowPasswordFunction()">Show Password
 <br>
<!-- Password text box + type, name, id and placeholder -->
 <input type="password" name="password" placeholder="Password" id="ShowPassword">   
 <br><br> 
<!-- Sign in / login button -->
 <button name="submit" type="submit">Sign in</button>
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