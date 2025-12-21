<?php
// Kiểm tra nếu có thông báo lỗi
// Session bootstrap and shared flash messages.
if (session_status() === PHP_SESSION_NONE) session_start();
if (!defined('APP_BASE')) define('APP_BASE', '');
$user_id = $_SESSION['user_id'] ?? null;

// Render flash messages, if any.
if(isset($message)){
   foreach($message as $msg){
      $type = 'success';
      if (stripos($msg, 'delete') !== false) $type = 'delete';
      elseif (stripos($msg, 'update') !== false) $type = 'update';
      echo '
      <div class="message message--'.$type.'">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<?php
// Khởi tạo session nếu chưa có

?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <!-- Social links -->
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>

         <!-- Kiểm tra nếu người dùng đã đăng nhập, nếu chưa hiển thị login/register -->
         <!-- Guest links vs logged-in greeting -->
         <?php if (!$user_id) { ?>
            <p> new <a href="<?php echo APP_BASE; ?>/pages/login.php">login</a> | <a href="<?php echo APP_BASE; ?>/pages/register.php">register</a> </p>
         <?php } else { ?>
            <p>hi, <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'user'); ?></span> | <a href="<?php echo APP_BASE; ?>/pages/logout.php" onclick="return confirm('logout now?');">logout</a></p>
         <?php } ?>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="<?php echo APP_BASE; ?>/pages/home.php" class="logo">Bookly.</a>

         <!-- Primary navigation -->
         <nav class="navbar">
            <a href="<?php echo APP_BASE; ?>/pages/home.php">home</a>
            <a href="<?php echo APP_BASE; ?>/pages/about.php">about</a>
            <a href="<?php echo APP_BASE; ?>/pages/shop.php">shop</a>
            <a href="<?php echo APP_BASE; ?>/pages/contact.php">contact</a>
            <a href="<?php echo APP_BASE; ?>/pages/orders.php">orders</a>
         </nav>

         <!-- Header action icons -->
         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="<?php echo APP_BASE; ?>/pages/search_page.php" class="fas fa-search"></a>
            <a href="<?php echo APP_BASE; ?>/pages/user_dashboard.php" id="user-btn" class="fas fa-user"></a>
            <?php
               // Load cart count for the current user.
               // Kiểm tra số lượng sản phẩm trong giỏ hàng
               if ($user_id) {
                  $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                  $cart_rows_number = mysqli_num_rows($select_cart_number);
               } else {
                  $cart_rows_number = 0;
               }
            ?>
            <a href="<?php echo APP_BASE; ?>/pages/cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <!-- Kiểm tra nếu người dùng đã đăng nhập, nếu chưa hiển thị thông tin login -->
         <!-- Logged-in user dropdown -->
         <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="user-box">
               <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
               <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
               <!-- Nút logout chỉ hiển thị khi đã đăng nhập -->
               <!-- Logout action -->
               <a href="<?php echo APP_BASE; ?>/pages/logout.php" class="delete-btn">logout</a>
            </div>
         <?php } ?>
      </div>
   </div>

</header>
