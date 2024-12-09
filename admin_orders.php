<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

// Handle delete request
if (isset($_GET['delete'])) {
   $delete_id = intval($_GET['delete']);  // Use intval for security

   // Perform deletion query
   $delete_order_query = "DELETE FROM `orders` WHERE id = $delete_id";
   if (mysqli_query($conn, $delete_order_query)) {
       $message[] = 'Order deleted successfully!';
   } else {
       $message[] = 'Failed to delete the order!';
   }

   // Redirect to avoid resubmission of the delete request
   header('Location: admin_orders.php');
   exit;
}

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];

   // Check if 'update_payment' is set
   if(isset($_POST['update_payment'])){
      $update_payment = $_POST['update_payment'];
      
      // Ensure 'current_status' is set and check if update_payment is not the same as current_status
      if(!empty($update_payment) && isset($_POST['current_status']) && $update_payment !== $_POST['current_status']){
         mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
         $message[] = 'Payment status has been updated!';
      } else {
         $message[] = 'Please select a new status before updating!';
      }
   } else {
      $message[] = 'Please select a new status before updating!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- DataTables CSS -->
   <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">

   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
</head>
<body>

<?php @include 'admin_header.php'; ?>

<section class="dashboard">
   <h3 class="title">Placed Orders</h3>
   <div class="box-container" style="width: 500%;">
      <div class="box">
         <style>
            table { border-spacing: 0px; border: 1px solid black; width: 100%;}
            .td-data { text-align: left; padding: 5px; border-right: 1px solid black; border-bottom: 1px solid black; }
         </style>
         <table id="adminTable">
            <thead>
               <tr style="background: #f0f0f0;">
                  <td><h1>Order Id</h1></td>
                  <td><h1>User ID</h1></td>
                  <td><h1>Name</h1></td>
                  <td><h1>Phone Number</h1></td>
                  <td><h1>Email</h1></td>
                  <td><h1>Address</h1></td>
                  <td><h1>Products</h1></td>
                  <td><h1>Price</h1></td>
                  <td><h1>Payment Method</h1></td>
                  <td><h1>Date</h1></td>
                  <td><h1>Status</h1></td>
                  <td><h1>Actions</h1></td>
               </tr>
            </thead>
            <tbody>
               <?php
               $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
               if(mysqli_num_rows($select_orders) > 0){
                  while($fetch_orders = mysqli_fetch_assoc($select_orders)){
               ?>
               <tr>
                  <td class="td-data">WCOR00<?= $fetch_orders['id'] ?></td>
                  <td class="td-data"><?= $fetch_orders['user_id'] ?></td>
                  <td class="td-data"><?= $fetch_orders['name'] ?></td>
                  <td class="td-data"><?= $fetch_orders['number'] ?></td>
                  <td class="td-data"><?= $fetch_orders['email'] ?></td>
                  <td class="td-data"><?= $fetch_orders['address'] ?></td>
                  <td class="td-data"><?= $fetch_orders['total_products'] ?></td>
                  <td class="td-data">₱<?= number_format($fetch_orders['total_price'], 2) ?></td>
                  <td class="td-data"><?= $fetch_orders['method'] ?></td>
                  <td class="td-data"><?= $fetch_orders['placed_on'] ?></td>
                  <td class="td-data">
                     <h5>
                        <?php 
                           if ($fetch_orders['payment_status'] === 'pending') {
                              echo "<i style='color:red'>pending</i>";
                           } elseif ($fetch_orders['payment_status'] === 'processing') {
                              echo "<i style='color:orange'>processing</i>";
                           } elseif ($fetch_orders['payment_status'] === 'completed') {
                              echo "<i style='color:green'>completed</i>";
                           }
                        ?>
                     </h5>
                  </td>
                  <td class="td-data">
                     <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?= $fetch_orders['id'] ?>">
                     <input type="hidden" name="current_status" value="<?= $fetch_orders['payment_status'] ?>">
                     <select name="update_payment">
                        <option disabled selected>Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                     </select>
                     <input type="submit" name="update_order" value="Update" class="option-btn" 
                           style="padding: 5px 25px; font-size: 14px;">
                     </form>
                     <a href="admin_orders.php?delete=<?= $fetch_orders['id'] ?>" class="delete-btn" 
                        onclick="return confirm('Delete this order?');" 
                        style="padding: 5px 28px; font-size: 14px;">Delete</a>
                  </td>
               </tr>
               <?php
                  }
               } else {
                  echo '<tr><td colspan="12" class="empty">No orders placed yet!</td></tr>';
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</section>

<script>
   new DataTable('#adminTable');
</script>
<script src="js/admin_script.js"></script>

</body>
</html>