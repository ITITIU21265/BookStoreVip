<section class="footer">

<?php // Ensure a base path is available for links. ?>
<?php if (!defined('APP_BASE')) define('APP_BASE', ''); ?>

   <div class="box-container">

      <!-- Footer: quick links -->
      <div class="box">
         <h3>quick links</h3>
         <a href="<?php echo APP_BASE; ?>/pages/home.php">home</a>
         <a href="<?php echo APP_BASE; ?>/pages/about.php">about</a>
         <a href="<?php echo APP_BASE; ?>/pages/shop.php">shop</a>
         <a href="<?php echo APP_BASE; ?>/pages/contact.php">contact</a>
      </div>

      <!-- Footer: extra links -->
      <div class="box">
         <h3>extra links</h3>
         <a href="<?php echo APP_BASE; ?>/pages/login.php">login</a>
         <a href="<?php echo APP_BASE; ?>/pages/register.php">register</a>
         <a href="<?php echo APP_BASE; ?>/pages/cart.php">cart</a>
         <a href="<?php echo APP_BASE; ?>/pages/orders.php">orders</a>
      </div>

      <!-- Footer: contact info -->
      <div class="box">
         <h3>contact info</h3>
         <p> <i class="fas fa-phone"></i> +123-456-7890 </p>
         <p> <i class="fas fa-phone"></i> +84-2222-3333 </p>
         <p> <i class="fas fa-envelope"></i> thanhvu09816@gmail.com </p>
         <p> <i class="fas fa-map-marker-alt"></i> HCM, VN - 700000 </p>
      </div>

      <!-- Footer: social links -->
      <div class="box">
         <h3>follow us</h3>
         <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
         <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
         <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
         <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
      </div>

   </div>

   <!-- Footer credit with current year -->
   <p class="credit"> &copy; copyright  @ <?php echo date('Y'); ?> by <span>xê sủi</span> </p>

</section>
