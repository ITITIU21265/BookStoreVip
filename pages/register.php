<?php

require_once __DIR__ . '/../includes/config.php';


// Handle registration submission.
if(isset($_POST['submit'])){

   // Normalize raw input before validation.
   $name_raw = trim($_POST['name'] ?? '');
   $email_raw = trim($_POST['email'] ?? '');
   $password_raw = $_POST['password'] ?? '';
   $cpassword_raw = $_POST['cpassword'] ?? '';
   $user_type = 'user';
   $errors = [];

   // Validate name.
   $name_length = function_exists('mb_strlen') ? mb_strlen($name_raw) : strlen($name_raw);
   if($name_raw === ''){
      $errors[] = 'Name is required.';
   }elseif($name_length < 2 || $name_length > 50){
      $errors[] = 'Name must be 2-50 characters.';
   }elseif(!preg_match("/^[\\p{L}\\p{M}\\p{N}'\\.\\-\\s]+$/u", $name_raw)){
      $errors[] = 'Name contains invalid characters.';
   }

   // Validate email.
   if($email_raw === ''){
      $errors[] = 'Email is required.';
   }elseif(strlen($email_raw) > 254){
      $errors[] = 'Email is too long.';
   }elseif(!filter_var($email_raw, FILTER_VALIDATE_EMAIL)){
      $errors[] = 'Email is invalid.';
   }

   // Validate password rules.
   $password_length = strlen($password_raw);
   if($password_raw === ''){
      $errors[] = 'Password is required.';
   }elseif($password_length < 8 || $password_length > 64){
      $errors[] = 'Password must be 8-64 characters.';
   }elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d).+$/', $password_raw)){
      $errors[] = 'Password must include upper, lower, and number.';
   }

   // Confirm password match.
   if($password_raw !== $cpassword_raw){
      $errors[] = 'Confirm password not matched.';
   }

   // Return errors or create the user.
   if(!empty($errors)){
      foreach($errors as $error){
         $message[] = ['type' => 'delete', 'text' => $error];
      }
   }else{
      // Escape inputs and store the hashed password.
      $name = mysqli_real_escape_string($conn, $name_raw);
      $email = mysqli_real_escape_string($conn, $email_raw);
      $pass = mysqli_real_escape_string($conn, md5($password_raw));

      // Check for duplicate email before insert.
      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

      if(mysqli_num_rows($select_users) > 0){
         $message[] = ['type' => 'delete', 'text' => 'User already exists!'];
      }else{
         // Create account and redirect to login.
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('query failed');
         $message[] = ['type' => 'success', 'text' => 'Registered successfully!'];
         header('location:' . APP_BASE . '/pages/login.php');
         exit;
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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
      $text = $msg;
      if(is_array($msg)){
         $type = $msg['type'] ?? 'success';
         $text = $msg['text'] ?? '';
      }else{
         if (stripos($msg, 'delete') !== false) $type = 'delete';
         elseif (stripos($msg, 'update') !== false) $type = 'update';
      }
      echo '
      <div class="message message--'.$type.'">
         <span>'.$text.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<?php
// Preserve user input after validation errors.
$name_value = isset($name_raw) ? htmlspecialchars($name_raw, ENT_QUOTES, 'UTF-8') : '';
$email_value = isset($email_raw) ? htmlspecialchars($email_raw, ENT_QUOTES, 'UTF-8') : '';
?>
   
<div class="form-container">

   <!-- Registration form -->
   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" value="<?php echo $name_value; ?>" minlength="2" maxlength="50" autocomplete="name" required class="box">
      <input type="email" name="email" placeholder="enter your email" value="<?php echo $email_value; ?>" maxlength="254" autocomplete="email" required class="box">
      <input type="password" name="password" placeholder="enter your password" minlength="8" maxlength="64" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,64}" title="Password must be 8-64 characters and include uppercase, lowercase, and a number." autocomplete="new-password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" minlength="8" maxlength="64" autocomplete="new-password" required class="box">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="<?php echo APP_BASE; ?>/pages/login.php">login now</a></p>
   </form>

</div>

</body>
</html>
