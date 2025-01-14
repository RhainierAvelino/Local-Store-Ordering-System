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

   // Collect all fields and trim whitespace
   $house_lot_no = trim($_POST['house_lot_no'] ?? '');
   $building_name_no = trim($_POST['building_name_no'] ?? '');
   $street_road_avenue = trim($_POST['street_road_avenue'] ?? '');
   $barangay = trim($_POST['barangay'] ?? '');
   $city_municipality = trim($_POST['city_municipality'] ?? '');
   $province = trim($_POST['province'] ?? '');
   $region = trim($_POST['region'] ?? '');
   $postal_code_zip = trim($_POST['postal_code_zip'] ?? '');

   // Array to store non-empty address components
   $address_components = [];

   if (!empty($house_lot_no)) $address_components[] = $house_lot_no;
   if (!empty($building_name_no)) $address_components[] = $building_name_no;
   if (!empty($street_road_avenue)) $address_components[] = $street_road_avenue;
   if (!empty($barangay)) $address_components[] = $barangay;
   if (!empty($city_municipality)) $address_components[] = $city_municipality;
   if (!empty($province)) $address_components[] = $province;
   if (!empty($region)) $address_components[] = $region;
   if (!empty($postal_code_zip)) $address_components[] = $postal_code_zip;

   // Combine non-empty components into a single address string
   $address = implode(', ', $address_components);

   // Sanitize the final address
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   // Update the database
   $update_address = $conn->prepare("UPDATE `users` SET address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'Address saved!';
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update address</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Your Address</h3>
      <input type="text" class="box" placeholder="House/Lot No." maxlength="50" name="house_lot_no">
      <input type="text" class="box" placeholder="Building Name/No." maxlength="50" name="building_name_no">
      <input type="text" class="box" placeholder="Street/Road/Avenue" required maxlength="50" name="street_road_avenue">
      <input type="text" class="box" placeholder="Barangay" required maxlength="50" name="barangay">
      <input type="text" class="box" placeholder="City/Municipality" required maxlength="50" name="city_municipality">
      <input type="text" class="box" placeholder="Province" required maxlength="50" name="province">
      <input type="text" class="box" placeholder="Region" maxlength="50" name="region">
      <input type="text" class="box" placeholder="Postal Code/ZIP Code" required maxlength="6" name="postal_code_zip">
      <input type="submit" value="Save Address" name="submit" class="btn">
   </form>



</section>










<?php include 'components/footer.php' ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>