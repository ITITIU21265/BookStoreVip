<?php
// Khởi tạo session nếu chưa có
// Session bootstrap and flash message merge.
if (session_status() === PHP_SESSION_NONE) session_start();
if (!defined('APP_BASE')) define('APP_BASE', '');

// Collect flash messages from session and current page.
$flash_messages = $_SESSION['flash_messages'] ?? [];
unset($_SESSION['flash_messages']);

$all_messages = [];
if (isset($message) && is_array($message)) $all_messages = array_merge($all_messages, $message);
if (is_array($flash_messages)) $all_messages = array_merge($all_messages, $flash_messages);

// Render flash messages in the admin header.
if (!empty($all_messages)) {
   foreach ($all_messages as $msg) {
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

<header class="header">
   <div class="flex">
      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>
      <!-- Admin navigation -->
      <nav class="navbar">
         <a href="admin_page.php">home</a>
         <a href="admin_products.php">products</a>
         <a href="admin_orders.php">orders</a>
         <a href="admin_users.php">users</a>
         <a href="admin_contacts.php">messages</a>
      </nav>

      <!-- Header actions -->
      <div class="header-actions">
         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
         </div>
         <?php if (isset($_SESSION['admin_id'])) { ?>
            <a href="<?php echo APP_BASE; ?>/pages/logout.php" class="nav-link logout-link" onclick="return confirm('logout now?');">logout</a>
         <?php } ?>
      </div>

      <!-- Admin account dropdown -->
      <div class="account-box">
         <!-- check session admin_id -->
         <?php if (isset($_SESSION['admin_id'])) { ?>
            <p>username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="<?php echo APP_BASE; ?>/pages/logout.php" class="delete-btn">logout</a>
         <?php } else { ?>
            <div>new <a href="<?php echo APP_BASE; ?>/pages/login.php">login</a> | <a href="<?php echo APP_BASE; ?>/pages/register.php">register</a></div>
         <?php } ?>
      </div>
   </div>
</header>
