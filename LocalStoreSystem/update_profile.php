<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
   exit();
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);

   // Fetch the current password before validation
   $empty_pass = sha1('');
   $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
   $select_prev_pass->execute([$user_id]);
   $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];

   // Hash and sanitize password fields
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   $updated = false; // Track if any update happened

   // Update Username (Independent of Password Change)
   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
      $_SESSION['user_name'] = $name; // Update session
      $updated = true;
   }

   // Update Password (Only if All Fields Are Filled)
   if(!empty($_POST['old_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])){
      if($old_pass != $prev_pass){
         $message[] = 'Old password is incorrect!';
      } elseif($new_pass != $confirm_pass){
         $message[] = 'New passwords do not match!';
      } elseif($new_pass != $empty_pass){
         $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass->execute([$confirm_pass, $user_id]);
         $updated = true;
      } else {
         $message[] = 'Please enter a new password!';
      }
   }

   // Redirect Only If Changes Were Made
   if($updated){
      $message[] = 'Profile updated successfully!';
      header("Location: home.php");
      exit();
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- Header Section -->
<?php include 'components/user_header.php'; ?>
<!-- Header Section Ends -->

<section class="form-container update-form">
   <form action="" method="post">
      <h3>Update Profile</h3>
      <input type="text" name="name" placeholder="<?= htmlspecialchars($fetch_profile['name']); ?>" class="box" maxlength="50">
      <input type="email" name="email" placeholder="<?= htmlspecialchars($fetch_profile['email']); ?>" class="box" maxlength="50" disabled>
      <input type="number" name="number" placeholder="<?= htmlspecialchars($fetch_profile['number']); ?>" class="box" min="0" max="9999999999" maxlength="11" disabled>
      <input type="password" name="old_pass" placeholder="Enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (e) {
      let oldPass = document.querySelector("input[name='old_pass']").value.trim();
      let newPass = document.querySelector("input[name='new_pass']").value.trim();
      let confirmPass = document.querySelector("input[name='confirm_pass']").value.trim();

      let passRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // At least 8 characters, 1 letter, 1 number

      if (newPass && !passRegex.test(newPass)) {
        alert("New password must be at least 8 characters long and include at least one letter and one number.");
        e.preventDefault();
        return;
      }

      if (newPass && newPass !== confirmPass) {
        alert("New passwords do not match.");
        e.preventDefault();
        return;
      }
    });
  });
</script>

<?php include 'components/footer.php'; ?>

<!-- Custom JS -->
<script src="js/script.js"></script>

</body>
</html>
