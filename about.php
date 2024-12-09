<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="/">home</a> / about </p>
</section>

<section class="about">

    <div class="flex">
        <div class="image">
            <img src="images/about-img-1.jpg" alt="">
        </div>
        <div class="content">
            <h3>why choose us?</h3>
            <p>We offer unique bags and slippers crafted from eco-friendly water lilies, combining sustainability with style. Our products are not only beautiful but also durable, giving you the best of both worlds.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>
    </div>

    <div class="flex">
        <div class="content">
            <h3>what we provide?</h3>
            <p>We provide a diverse range of stylish bags and comfortable slippers, all made from high-quality water lilies. Our products are perfect for those who appreciate nature and want to make a fashion statement while being environmentally conscious.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>
        <div class="image">
            <img src="images/f.jpg" alt="">
        </div>
    </div>

    <div class="flex">
        <div class="image">
            <img src="images/us.jpg" alt="">
        </div>
        <div class="content">
            <h3>who we are?</h3>
            <p>We are passionate artisans dedicated to creating beautiful and sustainable products from water lilies. Our team believes in empowering local communities while delivering exceptional craftsmanship in every item we create.</p>
            <a href="#owners" class="btn">meet the owners</a>
        </div>
    </div>

</section>

<section class="owners">
        <h1 class="title">Owners</h1>
        <div class="owners-container">
            <div class="owner-box">
                <img src="images/prof.jpg" alt="Owner 1">
                <h3>Kim Harley Quitol</h3>
                <p>Founder</p>
            </div>
            <div class="owner-box">
                <img src="images/profile.jpeg" alt="Owner 2">
                <h3>Krasnaya Jamaica Payno</h3>
                <p>Co-Founder</p>
            </div>
            <div class="owner-box">
                <img src="images/profile.jpeg" alt="Owner 3">
                <h3>Francine Rabaya</h3>
                <p>Marketing Manager</p>
            </div>
            <div class="owner-box">
                <img src="images/prof.jpg" alt="Owner 4">
                <h3>Aaron Janricson Que</h3>
                <p>Financial Advisor</p>
            </div>
        </div>
    </section>


<?php @include 'footer.php'; ?>