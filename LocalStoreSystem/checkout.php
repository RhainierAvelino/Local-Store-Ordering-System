<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){
      if($address == ''){
         $message[] = 'please add your address!';
      }else{
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
   }else{
      $message[] = 'your cart is empty';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="home.php">Home</a> <span> / Checkout</span></p>
</div>

<section class="checkout">
   <h1 class="title">Order Summary</h1>

   <form action="" method="post">
      <div class="cart-items">
         <h3>Cart Items</h3>
         <?php
         $grand_total = 0;
         $cart_items = [];
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);

         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' (₱'.$fetch_cart['price'].' x '.$fetch_cart['quantity'].')';
               $total_products = implode(", ", $cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
         ?>
         <p><span class="name"><?= $fetch_cart['name']; ?></span> <span class="price">₱<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
         <?php
            }
         }else{
            echo '<p class="empty">Your cart is empty!</p>';
         }
         ?>
         <p class="grand-total"><span class="name" id="grand-total">Grand Total :</span> <span class="price">₱<?= $grand_total; ?></span></p>
         <a href="cart.php" class="btn">View Cart</a>
      </div>

      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
      <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
      <input type="hidden" name="number" value="<?= $fetch_profile['number']; ?>">
      <input type="hidden" name="email" value="<?= $fetch_profile['email']; ?>">
      <input type="hidden" name="address" value="<?= $fetch_profile['address']; ?>">

      <div class="user-info">
         <h3>Your Info</h3>
         <p><i class="fas fa-user"></i> <span><?= $fetch_profile['name']; ?></span></p>
         <p><i class="fas fa-phone"></i> <span><?= $fetch_profile['number']; ?></span></p>
         <p><i class="fas fa-envelope"></i> <span><?= $fetch_profile['email']; ?></span></p>
         <a href="update_profile.php" class="btn">Update Info</a>

         <h3>Delivery Address</h3>
         <p><i class="fas fa-map-marker-alt"></i> <span><?= ($fetch_profile['address'] == '') ? 'Please enter your address' : $fetch_profile['address']; ?></span></p>
         <a href="update_address.php" class="btn">Update Address</a>

         <select name="method" class="box" required>
            <option value="" disabled selected>Select Payment Method --</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Gcash">Gcash</option>
         </select>

         <!-- Payment Info (Initially Hidden) -->
         <div id="payment-info" style="display: none; margin-top: 10px; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;">
            <p><strong>Send payment to:</strong> <span id="payment-number">0945 680 4666</span></p>
            <button onclick="copyNumber(event)" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight:500">Copy Number</button>
            <p style="text-align:justify;"><small><strong>Note: </strong>If you've chosen GCash or PayMaya, a phone number will appear on the screen.  Please send your payment to this number.  You can show the payment confirmation or receipt to the delivery rider when they arrive.  Alternatively, you can ask the rider for the GCash/PayMaya number when they deliver.</small></p>
         </div>

         <input type="submit" value="Place Order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
      </div>
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
   const paymentMethod = document.querySelector("select[name='method']");
   const paymentInfo = document.getElementById("payment-info");
   const paymentNumber = document.getElementById("payment-number");

   const paymentNumbers = {
      "Gcash": "0945 680 4666",
      "PayMaya": "0945 680 4666"
   };

   paymentMethod.addEventListener("change", function() {
      if (paymentNumbers[this.value]) {
         paymentInfo.style.display = "block";
         paymentNumber.textContent = paymentNumbers[this.value];
      } else {
         paymentInfo.style.display = "none";
      }
   });
});

function copyNumber(event) {
   event.preventDefault(); // Prevents the page from resetting
   const paymentNumber = document.getElementById("payment-number").textContent;
   navigator.clipboard.writeText(paymentNumber).then(() => {
      alert("Payment number copied!");
   });
}

</script>

</body>
</html>
