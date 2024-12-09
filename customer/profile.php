<?php

include "../config.php";

session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login.php');
};

$user_id = $_SESSION['user_id'];

// query customer details
$sql = "SELECT * FROM `users` WHERE id = $user_id";
$query = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($query);

// updating customer details
if (isset($_POST['submit'])) {
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $house_number = mysqli_real_escape_string($conn, $_POST['house_number']);
   $street = mysqli_real_escape_string($conn, $_POST['street']);
   $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $state = mysqli_real_escape_string($conn, $_POST['state']);
   $country = mysqli_real_escape_string($conn, $_POST['country']);
   $zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);
   $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);

   $sql_update = "UPDATE `users` SET 
      firstname = '$firstname',
      lastname = '$lastname',
      house_number = '$house_number',
      street = '$street',
      barangay = '$barangay',
      city = '$city',
      state = '$state',
      country = '$country',
      zip_code = '$zip_code',
      phone_number = '$phone_number',
      email = '$email'
      WHERE id = $user_id";
   $query = mysqli_query($conn, $sql_update);

   if ($query) {
      // save to audit trail
      $user_id = $_SESSION['user_id'];
      $sql = "INSERT INTO audit_trail (user_id, description) VALUES ($user_id, 'User successfully updated profile details')";
      mysqli_query($conn, $sql);

      echo "<script> alert('Successfully updated profile');</script>";
      echo "<script>window.location.replace('profile.php');</script>";
   } else {
      echo "<script> alert('Sorry, something went wrong');</script>";
   }
   
}
?>


<?php 
   include 'header.php'; 
   include 'navbar.php'; 
?>
<section class="dashboard">
   <h1 class="title">User Profile</h1>
   <div class="box-container">
      <div class="box" style="margin-left:20%;margin-right:20%;">
         <form method="POST">
            <table style="width:100%;" border="1">
               <tr>
                  <td class="td-form">
                     <label>Firstname</label><br>
                     <input type="text" name="firstname" class="textbox full-width" placeholder="Enter your firstname" required  value="<?= $user['firstname']?>">
                  </td>
                  <td class="td-form">
                     <label>Lastname</label><br>
                     <input type="text" name="lastname" class="textbox full-width" placeholder="Enter your lastname" required value="<?= $user['lastname']?>">
                  </td>
               </tr>
               <tr>
                  <td colspan="2"><br></td>
               </tr>
               <tr style="padding-top:20px;">
                  <td colspan="2" style="border-top:1px solid black;"><br></td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>House Number</label><br>
                     <input type="text" name="house_number" class="textbox full-width" placeholder="Enter your house number" value="<?= $user['house_number']?>">
                  </td>
                  <td class="td-form">
                     <label>Street</label><br>
                     <input type="text" name="street" class="textbox full-width" placeholder="Enter your street" value="<?= $user['street']?>">
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>Barangay</label><br>
                     <input type="text" name="barangay" class="textbox full-width" placeholder="Enter your barangay" value="<?= $user['barangay']?>">
                  </td>
                  <td class="td-form">
                     <label>City</label><br>
                     <input type="text" name="city" class="textbox full-width" placeholder="Enter your city" value="<?= $user['city']?>">
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>State</label><br>
                     <input type="text" name="state" class="textbox full-width" placeholder="Enter your state" value="<?= $user['state']?>">
                  </td>
                  <td class="td-form">
                     <label>Country</label><br>
                     <input type="text" name="country" class="textbox full-width" placeholder="Enter your country" value="<?= $user['country']?>">
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>Zip</label><br>
                     <input type="text" name="zip_code" class="textbox full-width" placeholder="Enter your zip" value="<?= $user['zip_code']?>">
                  </td>
                  <td class="td-form">
                  </td>
               </tr>
               <tr>
                  <td colspan="2"><br></td>
               </tr>
               <tr style="padding-top:20px;">
                  <td colspan="2" style="border-top:1px solid black;"><br></td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>Phone number</label><br>
                     <input type="text" name="phone_number" class="textbox full-width" placeholder="Enter your phone number" value="<?= $user['phone_number']?>">
                  </td>
                  <td class="td-form">
                     <label>Email</label><br>
                     <input type="text" name="email" class="textbox full-width" placeholder="Enter your email" value="<?= $user['email']?>">
                  </td>
               </tr>
            </table>
            <br>            
            <input type="submit" class="btn" name="submit" value="Update">
         </form>
      </div>
   </div>
</section>
   <script src="../js/admin_script.js"></script>
   </body>
</html>