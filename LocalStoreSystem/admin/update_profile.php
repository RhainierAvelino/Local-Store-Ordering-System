<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['submit'])){

   $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $number = htmlspecialchars($_POST['number'], ENT_QUOTES, 'UTF-8');

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $admin_id]);
   }

   if(!empty($email)){
      $select_email = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
      $select_email->execute([$email]);
      if($select_email->rowCount() > 0){
         $message[] = 'email already taken!';
      }else{
         $update_email = $conn->prepare("UPDATE `admin` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $admin_id]);
      }
   }

   if(!empty($number)){
      $select_number = $conn->prepare("SELECT * FROM `admin` WHERE number = ?");
      $select_number->execute([$number]);
      if($select_number->rowCount() > 0){
         $message[] = 'number already taken!';
      }else{
         $update_number = $conn->prepare("UPDATE `admin` SET number = ? WHERE id = ?");
         $update_number->execute([$number, $admin_id]);
      }
   }
   
   $empty_pass = '';
   $select_prev_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
   $select_prev_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = htmlspecialchars($_POST['old_pass'], ENT_QUOTES, 'UTF-8');
   $new_pass = htmlspecialchars($_POST['new_pass'], ENT_QUOTES, 'UTF-8');
   $confirm_pass = htmlspecialchars($_POST['confirm_pass'], ENT_QUOTES, 'UTF-8');

   if($old_pass != $empty_pass){
      if(!password_verify($old_pass, $prev_pass)){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $new_pass_hashed = password_hash($new_pass, PASSWORD_BCRYPT);
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$new_pass_hashed, $admin_id]);
            $message[] = 'password updated successfully!';
         }else{
            $message[] = 'please enter a new password!';
         }
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
   <title>profile update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<section class="form-container update-form">

   <form action="" method="post">
      <h3>update profile</h3>
      <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
      <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>" class="box" min="0" max="9999999999" maxlength="11">
      <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" name="submit" class="btn">
   </form>

</section>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>