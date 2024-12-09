<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {

   // Sanitize and get email and password
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));  // MD5 encryption for password

   // Query to check if the user exists with the provided credentials
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {

      $row = mysqli_fetch_assoc($select_users);

      if ($row['user_type'] == 'admin') {

         // Set session variables for admin user
         $_SESSION['admin_name'] = $row['firstname'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];

         // Insert into audit_trail for admin login
         $user_id = $_SESSION['admin_id'];
         $sql = "INSERT INTO audit_trail (user_id, description) VALUES ($user_id, 'Admin successfully logged in')";
         mysqli_query($conn, $sql);

         // Redirect to the admin page
         header('location:admin_page.php');

      } elseif ($row['user_type'] == 'user') {

         // Set session variables for regular user
         $_SESSION['firstname'] = $row['firstname'];
         $_SESSION['lastname'] = $row['lastname'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];

         // Insert into audit_trail for user login (now including user_id)
         $user_id = $_SESSION['user_id'];
         $sql = "INSERT INTO audit_trail (user_id, description) VALUES ($user_id, 'User successfully logged in')";
         mysqli_query($conn, $sql);

         // Redirect to the user home page
         header('location:index.php');

      } else {
         $message[] = 'No user found!';
      }

   } else {
      $message[] = 'Incorrect email or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style1.css">

</head>

<body>

   <?php
   // Display any error or success messages
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <section class="logform-container">
      <form action="" method="post">
         <h3>HELLO AGAIN!</h3>
         <input type="email" name="email" class="box" placeholder="Enter your email" required>
         <input type="password" name="pass" class="box" placeholder="Enter your password" required>
         <input type="submit" class="btn" name="submit" value="Login Now">
         <p>Don't have an account? <a href="register.php">Register Now</a></p>
      </form>
   </section>

</body>

</html>
