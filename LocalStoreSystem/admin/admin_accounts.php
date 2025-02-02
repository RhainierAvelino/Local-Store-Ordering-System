<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit();
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Accounts</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Admins Accounts Section -->
<section class="accounts">

   <h1 class="heading">Admins Account</h1>

   <!-- Register Box (Separate from Admin Accounts List) -->
   <div class="box-container">
      <div class="box register-box">
         <strong>      
            <p style="color: brown; font-size: 28px">Register New Admin</p>
         </strong>
         <a href="register_admin.php" class="option-btn">Register</a>
      </div>
   </div>

   <!-- Admin Accounts Grid -->
   <div class="admin-accounts">
      <?php
         $select_account = $conn->prepare("SELECT * FROM `admin`");
         $select_account->execute();
         if($select_account->rowCount() > 0){
            while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
      ?>
      <div class="box">
         <p style="font-size: 24px;"> Admin ID: <span><?= $fetch_accounts['id']; ?></span> </p>
         <p style="font-size: 24px;"> Username: <span><?= $fetch_accounts['name']; ?></span> </p>
         <div class="flex-btn">
            <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
            <?php
               if($fetch_accounts['id'] == $admin_id){
                  echo '<a href="update_profile.php" class="option-btn">Update</a>';
               }
            ?>
         </div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No accounts available</p>';
      }
      ?>
   </div>

</section>

<!-- Custom JS -->
<script src="../js/admin_script.js"></script>

</body>
</html>
