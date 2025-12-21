<?php

require_once __DIR__ . '/../includes/config.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Guard: redirect guests to login.
if(!$user_id){
   header('location:' . APP_BASE . '/pages/login.php');
   exit;
}

$user_id = (int)$user_id;

// Load profile basics.
$user_query = mysqli_query($conn, "SELECT id, name, email FROM `users` WHERE id = $user_id LIMIT 1") or die('query failed');
$user = mysqli_fetch_assoc($user_query);

// Load order stats for the dashboard summary.
$stats_query = mysqli_query($conn, "
   SELECT
      COUNT(*) AS total_orders,
      SUM(CASE WHEN payment_status = 'pending' THEN 1 ELSE 0 END) AS pending_orders,
      SUM(CASE WHEN payment_status != 'pending' THEN 1 ELSE 0 END) AS completed_orders,
      COALESCE(SUM(total_price), 0) AS total_spent
   FROM `orders`
   WHERE user_id = $user_id
") or die('query failed');
$stats = mysqli_fetch_assoc($stats_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="<?php echo APP_BASE; ?>/assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Page heading -->
<div class="heading">
   <h3>dashboard</h3>
   <p> <a href="<?php echo APP_BASE; ?>/pages/home.php">home</a> / dashboard </p>
</div>

<!-- Profile and summary cards -->
<section class="user-dashboard">

   <h1 class="title">your account</h1>

   <div class="dash-grid">
      <div class="box">
         <h3>profile</h3>
         <p> user id : <span><?php echo htmlspecialchars((string)($user['id'] ?? '')); ?></span> </p>
         <p> username : <span><?php echo htmlspecialchars($user['name'] ?? ''); ?></span> </p>
         <p> email : <span><?php echo htmlspecialchars($user['email'] ?? ''); ?></span> </p>
      </div>

      <div class="box">
         <h3>orders summary</h3>
         <p> total orders : <span><?php echo (int)($stats['total_orders'] ?? 0); ?></span> </p>
         <p> pending : <span><?php echo (int)($stats['pending_orders'] ?? 0); ?></span> </p>
         <p> completed : <span><?php echo (int)($stats['completed_orders'] ?? 0); ?></span> </p>
         <p> total spent : <span>$<?php echo (int)($stats['total_spent'] ?? 0); ?>/-</span> </p>
         <a href="<?php echo APP_BASE; ?>/pages/orders.php" class="option-btn">view all orders</a>
      </div>
   </div>

</section>

<!-- Recent order history -->
<section class="placed-orders">

   <h1 class="title">order history</h1>

   <div class="box-container">
      <?php
         // Load all orders for this user.
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = $user_id ORDER BY id DESC") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> placed on : <span><?php echo htmlspecialchars($fetch_orders['placed_on']); ?></span> </p>
         <p> name : <span><?php echo htmlspecialchars($fetch_orders['name']); ?></span> </p>
         <p> number : <span><?php echo htmlspecialchars($fetch_orders['number']); ?></span> </p>
         <p> email : <span><?php echo htmlspecialchars($fetch_orders['email']); ?></span> </p>
         <p> address : <span><?php echo htmlspecialchars($fetch_orders['address']); ?></span> </p>
         <p> payment method : <span><?php echo htmlspecialchars($fetch_orders['method']); ?></span> </p>
         <p> your orders : <span><?php echo htmlspecialchars($fetch_orders['total_products']); ?></span> </p>
         <p> total price : <span>$<?php echo (int)$fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment status :
            <span style="color:<?php echo ($fetch_orders['payment_status'] === 'pending') ? 'red' : 'green'; ?>;">
               <?php echo htmlspecialchars($fetch_orders['payment_status']); ?>
            </span>
         </p>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">no orders placed yet!</p>';
         }
      ?>
   </div>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="<?php echo APP_BASE; ?>/assets/js/script.js"></script>

</body>
</html>
