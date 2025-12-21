<?php

require_once __DIR__ . '/../includes/config.php';



session_start();

$admin_id = $_SESSION['admin_id'] ?? null;

// Guard: redirect non-admins to login.
if(!$admin_id){
  header('location:' . APP_BASE . '/pages/login.php');
  exit;
}

$edit_user = null;

// Handle user updates.
if(isset($_POST['update_user'])){
   $update_u_id = (int)($_POST['update_u_id'] ?? 0);
   $update_name = trim($_POST['update_name'] ?? '');
   $update_email = trim($_POST['update_email'] ?? '');
   $requested_user_type = $_POST['update_user_type'] ?? 'user';

   // Sanitize and protect role changes.
   $update_user_type = in_array($requested_user_type, ['user', 'admin'], true) ? $requested_user_type : 'user';

   // Prevent demoting the current admin.
   if($update_u_id === (int)$admin_id && $update_user_type !== 'admin'){
      $update_user_type = 'admin';
      $message[] = 'you cannot change your own user type';
   }

   // Validate inputs.
   if($update_u_id <= 0){
      $message[] = 'invalid user id';
   }elseif($update_name === '' || $update_email === ''){
      $message[] = 'name and email are required';
   }elseif(!filter_var($update_email, FILTER_VALIDATE_EMAIL)){
      $message[] = 'invalid email address';
   }else{
      $safe_name = mysqli_real_escape_string($conn, $update_name);
      $safe_email = mysqli_real_escape_string($conn, $update_email);
      $safe_user_type = mysqli_real_escape_string($conn, $update_user_type);

      // Ensure email uniqueness.
      $check_email = mysqli_query($conn, "SELECT id FROM `users` WHERE email = '$safe_email' AND id != $update_u_id LIMIT 1") or die('query failed');
      if(mysqli_num_rows($check_email) > 0){
         $message[] = 'email already exists';
      }else{
         // Persist the user update.
         mysqli_query($conn, "UPDATE `users` SET name = '$safe_name', email = '$safe_email', user_type = '$safe_user_type' WHERE id = $update_u_id") or die('query failed');

         // Keep current admin session data in sync.
         if($update_u_id === (int)$admin_id){
            $_SESSION['admin_name'] = $update_name;
            $_SESSION['admin_email'] = $update_email;
         }

         $_SESSION['flash_messages'][] = 'user updated successfully!';
         header('location:admin_users.php');
         exit;
      }
   }

   // Preserve form values if validation fails.
   $edit_user = [
      'id' => $update_u_id,
      'name' => $update_name,
      'email' => $update_email,
      'user_type' => $update_user_type,
   ];
}

// Handle user deletion.
if(isset($_GET['delete'])){
   $delete_id = (int)$_GET['delete'];
   // Prevent deleting the current admin account.
   if($delete_id === (int)$admin_id){
      $_SESSION['flash_messages'][] = 'you cannot delete your own account';
      header('location:admin_users.php');
      exit;
   }
   mysqli_query($conn, "DELETE FROM `users` WHERE id = $delete_id") or die('query failed');
   $_SESSION['flash_messages'][] = 'user deleted successfully!';
   header('location:admin_users.php');
   exit;
}

// Load a user into the edit form.
if($edit_user === null && isset($_GET['update'])){
   $update_id = (int)$_GET['update'];
   if($update_id <= 0){
      $_SESSION['flash_messages'][] = 'invalid user id';
      header('location:admin_users.php');
      exit;
   }

   $update_query = mysqli_query($conn, "SELECT id, name, email, user_type FROM `users` WHERE id = $update_id") or die('query failed');
   if(mysqli_num_rows($update_query) === 0){
      $_SESSION['flash_messages'][] = 'user not found';
      header('location:admin_users.php');
      exit;
   }

   $edit_user = mysqli_fetch_assoc($update_query);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="../assets/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/admin_header.php'; ?>

<!-- User list -->
<section class="users">

   <h1 class="title"> user accounts </h1>

   <div class="box-container">
      <?php
         // Load all user accounts.
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <div class="user-top">
            <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
            <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
            <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
            <p> user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         </div>

         <div class="user-bottom actions">
            <a href="admin_users.php?update=<?php echo $fetch_users['id']; ?>" class="option-btn">update user</a>
            <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
         </div>
      </div>
      <?php
         };
      ?>
   </div>

</section>

<?php if($edit_user !== null){ ?>
<!-- Edit user form -->
<section class="edit-user-form">
   <form action="" method="post">
      <h3>update user</h3>
      <input type="hidden" name="update_u_id" value="<?php echo $edit_user['id']; ?>">
      <input type="text" name="update_name" value="<?php echo $edit_user['name']; ?>" class="box" required placeholder="enter username">
      <input type="email" name="update_email" value="<?php echo $edit_user['email']; ?>" class="box" required placeholder="enter email">
      <select name="update_user_type" class="box" required>
         <option value="user" <?php if($edit_user['user_type'] === 'user') echo 'selected'; ?>>user</option>
         <option value="admin" <?php if($edit_user['user_type'] === 'admin') echo 'selected'; ?>>admin</option>
      </select>
      <input type="submit" value="update" name="update_user" class="btn">
      <a href="admin_users.php" class="option-btn">cancel</a>
   </form>
</section>
<?php } ?>








<!-- custom admin js file link  -->
<script src="../assets/js/admin_script.js"></script>

</body>
</html>
