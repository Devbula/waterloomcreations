<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

// Fetch user details to get firstname, lastname, phone number, and email
$user_query = mysqli_query($conn, "SELECT firstname, lastname, phone_number, email FROM `users` WHERE id = '$user_id'") or die('query failed');
$user_data = mysqli_fetch_assoc($user_query);
$firstname = $user_data['firstname'];
$lastname = $user_data['lastname'];
$phone_number = $user_data['phone_number'];
$email = $user_data['email'];

if (isset($_POST['send'])) {
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if the message has already been sent
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE user_id = '$user_id' AND message = '$msg'") or die('query failed');

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'Message sent already!';
    } else {
        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO `message` (user_id, firstname, lastname, phone_number, email, message) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind parameters (ensure the correct type string and number of parameters)
        $stmt->bind_param('isssss', $user_id, $firstname, $lastname, $phone_number, $email, $msg);
        
        // Execute the statement
        if ($stmt->execute()) {
            $message[] = 'Message sent successfully!';
        } else {
            $message[] = 'Failed to send message!';
        }
        
        // Close the statement
        $stmt->close();
    }
}

?>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Contact Us</h3>
    <p> <a href="/">Home</a> / Contact </p>
</section>

<section class="contact">

    <form action="" method="POST">
        <h3>Send us a message!</h3>
        <textarea name="message" class="box" placeholder="Enter your message" required cols="30" rows="10"></textarea>
        <input type="submit" value="Send Message" name="send" class="btn">
    </form>

</section>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php @include 'footer.php'; ?>
