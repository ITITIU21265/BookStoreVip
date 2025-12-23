<?php

require_once __DIR__ . '/../includes/config.php';

session_start();

// Handle login submission.
if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   // Password hash (legacy md5).
   $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); 

   // Check credentials against the database.
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      // Redirect based on user role.
      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:' . APP_BASE . '/admin/admin_page.php');
         exit; 

      }elseif($row['user_type'] == 'user'){
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:' . APP_BASE . '/pages/home.php');
         exit; 
      }

   } else {
      // Invalid credentials.
      $message[] = 'Incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="<?php echo APP_BASE; ?>/assets/css/style.css">
</head>
<body>

<?php

// Flash messages.
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

<div class="form-container">
   <!-- Login form -->
   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="submit" value="Login Now" class="btn">
      <p>Don't have an account? <a href="<?php echo APP_BASE; ?>/pages/register.php">Register now</a></p>
   </form>
</div>

</body>
</html>
