<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
   exit(); // Stop script execution after the redirect
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   // Validate the 'delete' parameter to prevent SQL Injection
   $delete_id = mysqli_real_escape_string($conn, $delete_id);

   // Perform the delete query
   $delete_query = mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php'); // Redirect to the same page after deleting
   exit(); // Ensure script stops here after the redirect
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard - Messages</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php @include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">Messages</h1>

   <div class="box-container">

      <?php
      // Update SQL query to join the 'message' table with the 'users' table
      $select_message = mysqli_query($conn, "
          SELECT m.id, m.user_id, u.firstname, u.lastname, u.phone_number, m.email, m.message
          FROM `message` m
          JOIN `users` u ON m.user_id = u.id
      ") or die('query failed');

      // Check if there are messages
      if (mysqli_num_rows($select_message) > 0) {
         // Loop through all messages and display them
         while ($fetch_message = mysqli_fetch_assoc($select_message)) {
      ?>
      <div class="box" style="width: 300px; height: 350px; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 8px; text-align: center;">
         <p>User ID: <span><?php echo htmlspecialchars($fetch_message['user_id']); ?></span> </p>
         <p>Name: <span><?php echo htmlspecialchars($fetch_message['firstname']); ?> <?php echo htmlspecialchars($fetch_message['lastname']); ?></span> </p>
         <p>Phone Number: <span><?php echo htmlspecialchars($fetch_message['phone_number']); ?></span> </p>
         <p>Email: <span><?php echo htmlspecialchars($fetch_message['email']); ?></span> </p>
         <p>Message: <span><?php echo htmlspecialchars($fetch_message['message']); ?></span> </p>
         <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?');" class="delete-btn" style="margin-top: auto;">Delete</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">You have no messages!</p>';
      }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>
	