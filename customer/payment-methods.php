<?php
include "../config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
   header('location:login.php');
};

$user_id = $_SESSION['user_id'];

// query if customer has already a payment method
$sql = "SELECT * FROM payment_methods WHERE user_id = $user_id";
$query = mysqli_query($conn, $sql);
$user1 = mysqli_fetch_assoc($query);

// check if user1 is null
if (!$user1) {
    $user1 = [
        'gcash_number' => '',
        'paymaya_number' => '',
        'paypal_email' => '',
        'card_number' => '',
        'card_holders_name' => '',
        'card_expiration' => '',
        'card_cvv' => ''
    ];
}

// update customer payment methods
if (isset($_POST['submit'])) {
   $gcash_number = mysqli_real_escape_string($conn, $_POST['gcash_number']);
   $paymaya_number = mysqli_real_escape_string($conn, $_POST['paymaya_number']);
   $paypal_email = mysqli_real_escape_string($conn, $_POST['paypal_email']);
   $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
   $card_holders_name = mysqli_real_escape_string($conn, $_POST['card_holders_name']);
   $card_expiration = mysqli_real_escape_string($conn, $_POST['card_expiration']);
   $card_cvv = mysqli_real_escape_string($conn, $_POST['card_cvv']);
   $updated_at = date('Y-m-d H:i:s');

   // query update user payment method
   $sql_update = "UPDATE payment_methods SET 
   gcash_number = '$gcash_number',
   paymaya_number = '$paymaya_number',
   paypal_email = '$paypal_email',
   card_number = '$card_number',
   card_holders_name = '$card_holders_name',
   card_expiration = '$card_expiration',
   card_cvv = '$card_cvv',
   updated_at = '$updated_at'
   WHERE user_id = $user_id";

   $query = mysqli_query($conn, $sql_update);

   if ($query) {
      // save to audit trail
      $user_id = $_SESSION['user_id'];
      $sql = "INSERT INTO audit_trail (user_id, description) VALUES ($user_id, 'User successfully updated payment methods')";
      mysqli_query($conn, $sql);

      echo "<script> alert('Successfully updated payment methods');</script>";
      echo "<script>window.location.replace('payment-methods.php');</script>";
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
   <h3 class="title">Payment Methods</h3>
   <div class="box-container">
      <div class="box" style="margin-left:20%; margin-right:20%;">
         <form method="POST">
            <table style="width:100%; border: 1;">
               <tr>
                  <td class="td-form">
                     <label>GCash Number</label><br>
                     <input type="text" name="gcash_number" id="gcash_number" class="textbox full-width" value="<?= $user1['gcash_number'] ?>" placeholder="09123456789" minlength="11" maxlength="11">
                  </td>
                  <td class="td-form">
                     <label>Paymaya Number</label><br>
                     <input type="text" name="paymaya_number" id="paymaya_number" class="textbox full-width" value="<?= $user1['paymaya_number'] ?>" placeholder="09123456789" minlength="11" maxlength="11">
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>Paypal Email</label><br>
                     <input type="email" name="paypal_email" id="paypal_email" class="textbox full-width" value="<?= $user1['paypal_email'] ?>" placeholder="your@email.com">
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
                     <label>Card Number</label><br>
                     <input type="text" name="card_number" id="card_number" class="textbox full-width" value="<?= ($user1['card_number'] != "" )  ? $user1['card_number'] : '' ?>" placeholder="123456789" minlength="9" maxlength="16">
                  </td>
                  <td class="td-form">
                     <label>Card Holder's Name</label><br>
                     <input type="text" name="card_holders_name" id="card_holders_name" class="textbox full-width" value="<?= $user1['card_holders_name'] ?>" placeholder="Juan Dela Cruz">
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label>Card Expiration</label><br>
                     <input type="month" name="card_expiration" id="card_expiration" class="textbox full-width" value="<?= ($user1['card_expiration'] != "" )  ? $user1['card_expiration'] : '' ?>">
                  </td>
                  <td class="td-form">
                     <label>CVV</label><br>
                     <input type="text" name="card_cvv" id="card_cvv" class="textbox full-width" value="<?= ($user1['card_cvv'] != "" )  ? $user1['card_cvv'] : '' ?>" minlength="3" maxlength="4" placeholder="123">
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
</body>
</html>
