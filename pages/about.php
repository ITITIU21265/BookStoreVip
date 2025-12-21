<?php

require_once __DIR__ . '/../includes/config.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Guard: redirect guests to login.
if(!$user_id){
   header('location:' . APP_BASE . '/pages/login.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="<?php echo APP_BASE; ?>/assets/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Page heading -->
<div class="heading">
   <h3>about us</h3>
   <p> <a href="<?php echo APP_BASE; ?>/pages/home.php">home</a> / about </p>
</div>

<!-- About content -->
<section class="about">

   <div class="flex">

      <div class="image">
         <img src="<?php echo APP_BASE; ?>/assets/images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>At Bookly, we offer more than just books—we offer curated journeys into imagination, knowledge, and inspiration. Each title in our collection is thoughtfully selected to bring you literary gems that enlighten, entertain, and endure.</p>
         <p>What distinguishes us is our unwavering dedication to quality and service. From swift delivery to personalized recommendations, we’re here to make your reading experience seamless, meaningful, and truly memorable.</p>
         <a href="<?php echo APP_BASE; ?>/pages/contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<!-- Customer reviews -->
<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/pic-1.png" alt="">
         <p>"A must-have for book lovers—easy to use and full of great titles!" </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/pic-2.png" alt="">
         <p> "This app reignited my love for reading. Highly recommended!" </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>julie</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/pic-3.png" alt="">
         <p>"Smooth interface, vast library, and great reading features."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>rice</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/pic-4.png" alt="">
         <p>"I love how convenient it is to read anytime, anywhere." </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>gomez</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/pic-5.png" alt="">
         <p> "Great selection and user-friendly design. Five stars!" </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>viktor</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/pic-6.png" alt="">
         <p>"Affordable, accessible, and addictive in the best way!" </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>lan anh</h3>
      </div>

   </div>

</section>

<!-- Featured authors -->
<section class="authors">

   <h1 class="title">greate authors</h1>

   <div class="box-container">

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/author-1.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>david</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/author-2.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>asley</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/author-3.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>beiber</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/author-4.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>aurora</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/author-5.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>gunther</h3>
      </div>

      <div class="box">
         <img src="<?php echo APP_BASE; ?>/assets/images/author-6.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>rica</h3>
      </div>

   </div>

</section>







<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- custom js file link  -->
<script src="<?php echo APP_BASE; ?>/assets/js/script.js"></script>

</body>
</html>
