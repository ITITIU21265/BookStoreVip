<?php

require_once __DIR__ . '/../includes/config.php';


session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Guard: redirect guests to login.
if(!$user_id){
   header('location:' . APP_BASE . '/pages/login.php');
   exit;
}


// Update cart item quantity.
if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id' AND user_id = '$user_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

// Delete a single cart item.
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id' AND user_id = '$user_id'") or die('query failed');
   header('location:' . APP_BASE . '/pages/cart.php');
   exit;
}

// Delete all items for the user.
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:' . APP_BASE . '/pages/cart.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="<?php echo APP_BASE; ?>/assets/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Page heading -->
<div class="heading">
   <h3>shopping cart</h3>
   <p> <a href="<?php echo APP_BASE; ?>/pages/home.php">home</a> / cart </p>
</div>

<!-- Cart list and totals -->
<section class="shopping-cart">

   <h1 class="title">products added</h1>

   <div class="box-container">
      <?php
         // Load cart items and compute totals.
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
         <a href="<?php echo APP_BASE; ?>/pages/cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
         <img src="<?php echo APP_BASE; ?>/uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">your cart is empty</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="<?php echo APP_BASE; ?>/pages/cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div>

   <div class="cart-total">
      <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
         <a href="<?php echo APP_BASE; ?>/pages/shop.php" class="option-btn">continue shopping</a>
         <a href="<?php echo APP_BASE; ?>/pages/checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>

</section>








<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- custom js file link  -->
<script src="<?php echo APP_BASE; ?>/assets/js/script.js"></script>

</body>
</html>
