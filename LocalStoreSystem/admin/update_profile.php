<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit();
}

$fetch_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
$fetch_profile->execute([$admin_id]);
$profile_data = $fetch_profile->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
   $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
   $old_pass = htmlspecialchars($_POST['old_pass'], ENT_QUOTES, 'UTF-8');
   $new_pass = htmlspecialchars($_POST['new_pass'], ENT_QUOTES, 'UTF-8');
   $confirm_pass = htmlspecialchars($_POST['confirm_pass'], ENT_QUOTES, 'UTF-8');

   // Check if at least one field is filled
   if (!empty($name) || !empty($email) || !empty($number) || !empty($old_pass) || !empty($new_pass) || !empty($confirm_pass)) {
      
      if(!empty($name)){
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }

      if(!empty($email)){
         $select_email = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
         $select_email->execute([$email]);
         if($select_email->rowCount() > 0){
            $message[] = 'Email already taken!';
         } else {
            $update_email = $conn->prepare("UPDATE `admin` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $admin_id]);
         }
      }

      if(!empty($number)){
         $select_number = $conn->prepare("SELECT * FROM `admin` WHERE number = ?");
         $select_number->execute([$number]);
         if($select_number->rowCount() > 0){
            $message[] = 'Number already taken!';
         } else {
            $update_number = $conn->prepare("UPDATE `admin` SET number = ? WHERE id = ?");
            $update_number->execute([$number, $admin_id]);
         }
      }
      
      // Password Update Logic
      if(!empty($old_pass)){
         $select_prev_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
         $select_prev_pass->execute([$admin_id]);
         $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
         $prev_pass = $fetch_prev_pass['password'];

         if(!password_verify($old_pass, $prev_pass)){
            $message[] = 'Old password not matched!';
         } elseif($new_pass !== $confirm_pass){
            $message[] = 'Confirm password not matched!';
         } elseif(!empty($new_pass)) {
            $new_pass_hashed = password_hash($new_pass, PASSWORD_BCRYPT);
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$new_pass_hashed, $admin_id]);
            $message[] = 'Password updated successfully!';
         } else {
            $message[] = 'Please enter a new password!';
         }
      }

   } else {
      $message[] = 'Please fill in at least one field!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile Update</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php include '../components/admin_header.php'; ?>

<section class="form-container update-form">

   <form action="" method="post" onsubmit="return validateForm()">
      <h3>Update Profile</h3>
      <input type="text" name="name" placeholder="<?= htmlspecialchars($profile_data['name'], ENT_QUOTES, 'UTF-8'); ?>" class="box" maxlength="50">
      <input type="password" name="old_pass" placeholder="Enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>

</section>

<?php include '../components/footer.php'; ?>

<!-- Custom JavaScript -->
<script>
function validateForm() {
    let name = document.querySelector('input[name="name"]').value.trim();
    let email = document.querySelector('input[name="email"]').value.trim();
    let number = document.querySelector('input[name="number"]').value.trim();
    let oldPass = document.querySelector('input[name="old_pass"]').value.trim();
    let newPass = document.querySelector('input[name="new_pass"]').value.trim();
    let confirmPass = document.querySelector('input[name="confirm_pass"]').value.trim();

    if (name === "" && email === "" && number === "" && oldPass === "" && newPass === "" && confirmPass === "") {
        alert("Please fill in at least one field before submitting.");
        return false;
    }

    return true;
}
</script>

</body>
</html>
