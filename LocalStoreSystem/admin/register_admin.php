<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit();
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $cpass = $_POST['cpass'];

   // Password validation
   if (strlen($pass) < 8 || 
       !preg_match('/[A-Z]/', $pass) || 
       !preg_match('/[a-z]/', $pass) || 
       !preg_match('/[0-9]/', $pass) || 
       !preg_match('/[\W]/', $pass)) {
       $message[] = 'Password must be at least 8 characters long and include an uppercase letter, lowercase letter, a number, and a special character!';
   } elseif ($pass !== $cpass) {
       $message[] = 'Confirm password not matched!';
   } else {
       // Hash the password before storing it
       $hashed_pass = sha1($pass); 
       $hashed_pass = filter_var($hashed_pass, FILTER_SANITIZE_STRING);

       $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
       $select_admin->execute([$name]);
       
       if($select_admin->rowCount() > 0){
          $message[] = 'Username already exists!';
       } else {
          $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
          $insert_admin->execute([$name, $hashed_pass]);
          $message[] = 'New admin registered!';
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
   <title>Register</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <script>
   function validatePassword() {
       let pass = document.querySelector('input[name="pass"]').value;
       let cpass = document.querySelector('input[name="cpass"]').value;
       let errorMessage = "";

       if (pass.length < 8 || 
           !/[A-Z]/.test(pass) || 
           !/[a-z]/.test(pass) || 
           !/[0-9]/.test(pass) || 
           !/[\W]/.test(pass)) {
           errorMessage = "Password must be at least 8 characters long and include an uppercase letter, lowercase letter, a number, and a special character!";
       } else if (pass !== cpass) {
           errorMessage = "Confirm password not matched!";
       }

       if (errorMessage) {
           alert(errorMessage);
           return false;
       }

       return true;
   }
   </script>
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Register Admin Section Starts -->

<section class="form-container">
   <form action="" method="POST" onsubmit="return validatePassword()">
      <h3>Register New</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="Confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Register Now" name="submit" class="btn">
   </form>
</section>

<!-- Register Admin Section Ends -->

<!-- Custom JS File Link -->
<script src="../js/admin_script.js"></script>

</body>
</html>
