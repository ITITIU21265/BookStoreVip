<?php

require_once __DIR__ . '/../includes/config.php';


session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Guard: redirect guests to login.
if(!$user_id){
   header('location:' . APP_BASE . '/pages/login.php');
   exit;
}



// Add item to cart from the home page list.
if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="<?php echo APP_BASE; ?>/assets/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Hero section -->
<section class="home">

   <div class="content">
      <h3>Hand Picked Book to your door.</h3>
      <p> Discover a world of stories, knowledge, and inspiration. Whether you're looking for bestsellers, timeless classics, or hidden gems, we have something for every reader. Start your next chapter with us today!</p>
      <a href="<?php echo APP_BASE; ?>/pages/about.php" class="white-btn">discover more</a>
   </div>

</section>

<!-- Latest products -->
<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         // Load a limited list of products for the home page.
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <div class="product-top">
         <div class="image-wrap">
      <img class="image" src="<?php echo APP_BASE; ?>/uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         </div>
         <div class="name"><?php echo $fetch_products['name']; ?></div>
      </div>

      <div class="product-bottom">
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </div>
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="<?php echo APP_BASE; ?>/pages/shop.php" class="option-btn">load more</a>
   </div>

</section>

<!-- About preview -->
<section class="about">

   <div class="flex">

      <div class="image">
         <img src="<?php echo APP_BASE; ?>/assets/images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>At Bookly, we believe in the magic of reading—its power to inform, inspire, and transform. Our mission is to make books more accessible to everyone, everywhere. Whether you’re a casual reader or a lifelong bibliophile, we’re here to help you discover your next great read.</p>
         <p>With a thoughtfully curated selection, a user-friendly platform, and a passion for storytelling, we strive to create a space where stories come alive and readers feel at home. Join our growing community and let your reading journey begin with us.</p>
         <a href="<?php echo APP_BASE; ?>/pages/about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<!-- Contact call-to-action -->
<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>We are here to help! Whether you need assistance with your order, recommendations for your next read, or just want to say hello—do not hesitate to reach out.</p>
      <a href="<?php echo APP_BASE; ?>/pages/contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- custom js file link  -->
<script src="<?php echo APP_BASE; ?>/assets/js/script.js"></script>

</body>
</html>
