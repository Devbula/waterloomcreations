<?php

include "../config.php";

session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login.php');
};

$user_id = $_SESSION['user_id'];

// query customer orders
$sql1 = "SELECT * FROM `orders` WHERE user_id = $user_id ORDER BY id DESC";
$query1 = mysqli_query($conn, $sql1);

?>

<?php 
   include 'header.php'; 
   include 'navbar.php'; 
?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<section class="dashboard">
   <h3 class="title">Orders</h3>
   <div class="box-container">
      <div class="box">
      <style>
         table {border-spacing: 0px; border: 1px solid black;}
         .td-data{text-align: left; padding:5px;border-right:1px solid black;border-bottom:1px solid black;}
      </style>
      <table style="width:100%;  border:1;" id="myTable">
         <thead>
            <tr style="background:#f0f0f0;">
               <td><h1>Order Id</h1></td>
               <td><h1>Phone Number</h1></td>
               <td><h1>Email Address</h1></td>
               <td><h1>Payment Method</h1></td>
               <td><h1>Products</h1></td>
               <td><h1>Price</h1></td>
               <td><h1>Date</h1></td>
               <td><h1>Status</h1></td>
               <td><h1>Actions</h1></td>
            </tr>
         </thead>
         <tbody>
            <?php
               if (mysqli_num_rows($query1) > 0) { 
                  while($orders = mysqli_fetch_assoc($query1)) {
            ?>
               <tr>
                  <td class="td-data">
                     <h5 style="text-align: left;">WCOR00<?= $orders['id'] ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;;">
                     <h5 ><?= $orders['number'] ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;;">
                     <h5 ><?= $orders['email'] ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;;">
                     <h5 ><?= $orders['method'] ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;;">
                     <h5 ><?= $orders['total_products'] ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;;">
                     <h5 >₱<?= number_format($orders['total_price'], 2) ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;text-align:center;;">
                     <h5 ><?= $orders['placed_on'] ?></h5>
                  </td>
                  <td class="td-data" style="padding:5px;text-align:center;">
                     <h5>
                     <?php 
                        if ($orders['payment_status'] === 'pending') {
                           echo "<i style='color:red'>pending</i>";
                        } elseif ($orders['payment_status'] === 'processing') {
                           echo "<i style='color:orange'>processing</i>";   
                        } else {
                           echo "<i style='color:green'>completed</i>";
                        }
                     ?>
                     </h5>
                  </td>
                  <td class="td-data">
                     <a href="order-details.php?id=<?= $orders['id'] ?>"><i class="fa fa-file"></i></a>
                  </td>
               </tr>
            <?php } } ?>
         </tbody>
      </table>
      </div>
   </div>
</section>

<br>
<br>
<br>
<br>
<br>
<br>


<?php @include 'userfooter.php'; ?>

   <script>
      new DataTable('#myTable');
   </script>
   <script src="../js/admin_script.js"></script>

   </body>
</html>