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

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$query = mysqli_query($conn, $sql);
$user123 = mysqli_fetch_assoc($query);

?>
<header class="header">
   <div class="flex">
      <a href="index.php" class="logo">User<span>Dashboard</span></a>
      <nav class="navbar">
         <a href="index.php">Orders</a>
         <a href="payment-methods.php">Payment Methods</a>
         <a href="profile.php">Update Profile</a>
         <a href="password.php">Update Password</a>
         <!--<a href="../logout.php">Logout</a> -->
      </nav>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bar"></div>
         <div id="user-btn" class="fas fa-user"></div> 
         <span style="font-size:1.5rem;font-weight:bold;"> Hi <?php echo ucfirst($user123['firstname']); ?>!</span>
      </div>
      <div class="account-box">
         <p>Customer Name : <span><?= $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></span></p>
         <a href="../logout.php" class="delete-btn">logout</a>
      </div>
   </div>
</header>