<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    if (!isset($_POST['terms'])) {
        $message[] = 'You must accept the Terms and Conditions!';
    } else {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
        $select_user->execute([$email, $number]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            $message[] = 'Email or number already exists!';
        } else {
            if ($pass != $cpass) {
                $message[] = 'Confirm password does not match!';
            } else {
                $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
                $insert_user->execute([$name, $email, $number, $cpass]);

                $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
                $select_user->execute([$email, $pass]);
                $row = $select_user->fetch(PDO::FETCH_ASSOC);

                if ($select_user->rowCount() > 0) {
                    $_SESSION['user_id'] = $row['id'];
                    header('location:home.php');
                }
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
    <title>Register</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- Header Section Starts -->
<?php include 'components/user_header.php'; ?>
<!-- Header Section Ends -->

<section class="form-container">
    <form action="" method="post">
        <h3>Register Now</h3>
        <input type="text" name="name" required placeholder="Enter your name" class="box" maxlength="50">
        <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="number" name="number" required placeholder="Enter your number" class="box" min="0" max="9999999999" maxlength="11">
        <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" required placeholder="Confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">

        <!-- Terms and Conditions Section -->
        <div class="terms-container"> 
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I agree to accept the <a href="#" target="_blank">Terms and Conditions</a></label>
            </div>

        <input type="submit" value="Register Now" name="submit" class="btn">
        <p>Already have an account? <a href="login.php">Login Now</a></p>
    </form>
</section>

<?php include 'components/footer.php'; ?>

<!-- JavaScript Validation -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (e) {
      let name = document.querySelector("input[name='name']").value.trim();
      let email = document.querySelector("input[name='email']").value.trim();
      let number = document.querySelector("input[name='number']").value.trim();
      let pass = document.querySelector("input[name='pass']").value.trim();
      let cpass = document.querySelector("input[name='cpass']").value.trim();
      let termsChecked = document.querySelector("input[name='terms']").checked;

      let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      let phoneRegex = /^(\+63|0)\d{10}$/;
      let passRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

      if (!emailRegex.test(email)) {
        alert("Please enter a valid email.");
        e.preventDefault();
        return;
      }

      if (!phoneRegex.test(number)) {
        alert("Please enter a valid 11-digit phone number (e.g., 09XXXXXXXXX).");
        e.preventDefault();
        return;
      }

      if (!passRegex.test(pass)) {
        alert("Password must be at least 8 characters and include at least one letter and one number.");
        e.preventDefault();
        return;
      }

      if (pass !== cpass) {
        alert("Passwords do not match.");
        e.preventDefault();
        return;
      }

      if (!termsChecked) {
        alert("You must accept the Terms and Conditions.");
        e.preventDefault();
        return;
      }
    });
  });
</script>

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
