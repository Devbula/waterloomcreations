<?php

include "../config.php";

session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login.php');
};

$user_id = $_SESSION['user_id'];

// update customer password
if (isset($_POST['submit'])) {
   $old_password = md5(mysqli_real_escape_string($conn, $_POST['old_password']));
   $new_password = md5(mysqli_real_escape_string($conn, $_POST['new_password']));

   // query old password to validated
   $sql = "SELECT * FROM users WHERE id = $user_id";
   $query = mysqli_query($conn, $sql);
   $user = mysqli_fetch_assoc($query);

   if ($user['password'] === $old_password) {
      // since the old password is correct - update now the new password
      $sql_update = "UPDATE `users` SET 
         password = '$new_password'
         WHERE id = $user_id";
      $query = mysqli_query($conn, $sql_update);

      if ($query) {
         // save to audit trail
         $user_id = $_SESSION['user_id'];
         $sql = "INSERT INTO audit_trail (user_id, description) VALUES ($user_id, 'User successfully updated password')";
         mysqli_query($conn, $sql);

         echo "<script> alert('Successfully updated password');</script>";
         echo "<script>window.location.replace('password.php');</script>";
      } else {
         echo "<script> alert('Sorry, something went wrong');</script>";
      }
   } else {
      echo "<script> alert('Sorry, the old password is incorrect.');</script>";
   }
}
?>

<?php 
   include 'header.php'; 
   include 'navbar.php'; 
?>
<section class="dashboard">
   <h3 class="title">User Password</h3>
   <div class="box-container">
      <div class="box" style="margin-left:20%;margin-right:20%;">
         <form method="POST">
            <table style="width:100%;" border="1">
               <tr>
                  <td class="td-form" colspan="2">
                     <label>Old password</label><br>
                     <input type="password" name="old_password" id="old_password" class="textbox full-width" required>
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
                     <label>New password</label><br>
                     <input type="password" name="new_password" id="new_password" class="textbox full-width" required onkeyup="validate()" minlength="5">
                  </td>
                  <td class="td-form">
                     <label>Confirm password</label><br>
                     <input type="password" name="confirm_password" id="confirm_password" class="textbox full-width" required onkeyup="validate()" minlength="5">
                  </td>
               </tr>
            </table>
            <br>            
            <input type="submit" id="btn_update" class="btn" name="submit" value="Update">
         </form>
      </div>
   </div>
</section>
   <script src="../js/admin_script.js"></script>
   <script>
      var old_password = document.getElementById('old_password');
      var new_password = document.getElementById('new_password');
      var confirm_password = document.getElementById('confirm_password');
      var btn_update = document.getElementById('btn_update');

      btn_update.disabled = true;
      btn_update.style.opacity = 0;

      function validate() {
         if (new_password.value.length > 5 && confirm_password.value.length > 5) {
            if (new_password.value === confirm_password.value) {
               btn_update.disabled = false;
               btn_update.style.opacity = 100;
            } else {
               btn_update.disabled = true;
               btn_update.style.opacity = 0;
            }
         } else {
             btn_update.disabled = true;
               btn_update.style.opacity = 0;
         }
         
      }
   </script>
   </body>
</html>