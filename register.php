<?php

@include 'config.php';

if(isset($_POST['submit'])){

   //$filter_firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);

   //$filter_lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

   $house_number = mysqli_real_escape_string($conn, $_POST['house_number']);
   $street = mysqli_real_escape_string($conn, $_POST['street']);
   $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $state = mysqli_real_escape_string($conn, $_POST['state']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
   $zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']); 

   //$filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

   //$filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   //$pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));


   //$filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   //$cpass = mysqli_real_escape_string($conn, md5($filter_cpass));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpass']));


   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password does not match!';
      }else{
         // Insert user details into the database
         // mysqli_query($conn, "INSERT INTO `users`(firstname, lastname, house_number, street, barangay, city, state, country, zip_code, email, phone_number, password) VALUES('$firstname', '$lastname', '$house_number', '$street', '$barangay', '$city', '$state', '$country', '$zip_code', '$email', '$phone_number', '$pass')") or die('Query failed');
         $sql = "INSERT INTO `users`(firstname, lastname, house_number, street, barangay, city, state, country, zip_code, email, phone_number, password) VALUES('$firstname', '$lastname', '$house_number', '$street', '$barangay', '$city', '$state', '$country', '$zip_code', '$email', '$phone_number', '$pass')";
         if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            
            // insert new row for user payment method
            $sql = "INSERT INTO `payment_methods` (user_id) VALUES ($last_id)";
            mysqli_query($conn, $sql);

            echo "
               <script>
                  var answer = window.confirm('Successfully registered');
                  if (answer) {
                     window.location.replace('login.php');
                  } else {
                     window.location.replace('login.php');
                  }
               </script>";
         } else {
            echo "<script>alert('Something went wrong, please try again later. );</script>";
         }


         // Registration successful, redirect to home.php
         // echo "<script>alert('User successfully registered! );</script>";
         // echo "<script>windows.location.replace('login.php');</script>";
         // header('location:login.php');
         // exit(); // Ensure the script stops after redirection
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style1.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<section class="regform-container">

   <form action="" method="post">
   <h3>START YOUR ECO-SHOPPING!</h3>
      
      <!-- Full Name Section -->
      <label>Fullname</label>
      <div class="flex">
         <input type="text" name="firstname" class="box" placeholder="Enter your firstname" required>
         <input type="text" name="lastname" class="box" placeholder="Enter your lastname" required>
      </div>

      <!-- Address Section -->
      <label>Address</label>
      <div class="flex">
         <input type="text" name="house_number" class="box" placeholder="House number" required>
         <input type="text" name="street" class="box" placeholder="Street" required>
      </div>
      <div class="flex">
         <input type="text" name="barangay" class="box" placeholder="Barangay" required>
         <input type="text" name="city" class="box" placeholder="City" required>
         <input type="text" name="state" class="box" placeholder="State" required>
      </div>
      <div class="flex">
         <input type="text" name="country" class="box" placeholder="Country" required>
         <input type="text" name="zip_code" class="box" placeholder="Zip Code" required>
      </div>

      <!-- Contact Details -->
      <label>Contact</label>
      <div class="flex">
      <input type="tel" name="phone_number" class="box" placeholder="e.g., +639XXXXXXXXX" required>
      <input type="email" name="email" class="box" placeholder="Email" required>
      </div>
      
      <!-- Password -->
      <label>Password</label>
      <div class="flex">
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
      </div>

      <input type="submit" class="btn" name="submit" value="Register Now">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>

</section>

</body>
</html>