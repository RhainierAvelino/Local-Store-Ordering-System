<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts.php');
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users Accounts</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Search Form -->
<form action="" method="GET" class="search-form">
   <input type="text" name="search" placeholder="Search by User ID or Username" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="search-input">
   <button type="submit" class="search-btn">Search</button>
</form>

<!-- User Accounts Section Starts -->
<section class="accounts">
   <h1 class="heading">Users Account</h1>

<div class="user-accounts">
      <?php
         // Prepare SQL query with search filter
         $select_account = $conn->prepare("SELECT * FROM `users` WHERE `id` LIKE ? OR `name` LIKE ?");
         $select_account->execute(['%' . $search . '%', '%' . $search . '%']);
         if($select_account->rowCount() > 0){
            while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
      ?>
      <div class="box">
         <p> User ID : <span><?= $fetch_accounts['id']; ?></span> </p>
         <p> Username : <span><?= $fetch_accounts['name']; ?></span> </p>
         <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No accounts available</p>';
      }
      ?>
   </div>
</section>
<!-- User Accounts Section Ends -->

<!-- Custom JS File Link -->
<script src="../js/admin_script.js"></script>

</body>
</html>
