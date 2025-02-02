<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>HOMEPAGE</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link href="https://fonts.cdnfonts.com/css/dk-headlock" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body id="home-body">

   <?php include 'components/user_header.php'; ?>



   <div class="hero-container">
      <section class="hero">

         <div class="swiper hero-slider">

            <div class="swiper-wrapper">

               <div class="swiper-slide slide background">
                  <div class="content">
                     <span>order online</span>
                     <h3>Crispy Twister Fries</h3>
                     <a href="menu.php" class="btn">see menus</a>
                  </div>
                  <div class="image">
                     <img src="images/mojos.png" alt="">
                  </div>
               </div>

               <div class="swiper-slide slide background">
                  <div class="content">
                     <span>order online</span>
                     <h3>Cold Brew Latte</h3>
                     <a href="menu.php" class="btn">see menus</a>
                  </div>
                  <div class="image">
                     <img src="images/coffee.png" alt="">
                  </div>
               </div>

               <div class="swiper-slide slide background">
                  <div class="content">
                     <span>order online</span>
                     <h3>Signature Cheesy Hotdog Sandwich</h3>
                     <a href="menu.html" class="btn">see menus</a>
                  </div>
                  <div class="image">
                     <img src="images/hotdog.png" alt="">
                  </div>
               </div>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Add navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
         </div>
      </section>
   </div>

   <section class="description">
      <div class="black-board">
         <h1 class="title">old yorker's</h1>
         <p>At old yorker's, we pride ourselves on creating a welcoming atmosphere where every dish and drink is crafted
            with care and passion. Join us for a memorable dining experience that combines quality ingredients,
            innovative recipes, and a touch of nostalgia.</p>
      </div>
   </section>



   <section class="category">

      <h1 class="title">food category</h1>

      <div class="box-container">

         <a href="category.php?category=Hotdogs" class="box">
            <img src="images/cat-1.png" alt="">
            <h3>Hotdogs</h3>
         </a>

         <a href="category.php?category=<?= urlencode('Appetizers-&-Sides'); ?>" class="box">
         <img src="images/cat-2.png" alt="">
            <h3>Appetizers & Sides</h3>
         </a>

         <a href="category.php?category=<?= urlencode('Refreshers-&-Coolers'); ?>" class="box">
            <img src="images/cat-3.png" alt="">
            <h3>Refreshers & Coolers</h3>
         </a>

         <a href="category.php?category=<?= urlencode('Coffee-&-Matcha'); ?>" class="box">
            <img src="images/cat-4.png" alt="">
            <h3>Coffee & Matcha</h3>
         </a>

      </div>

   </section>




   <section class="products">

      <h1 class="title">latest dishes</h1>

      <div class="box-container">

         <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <form action="" method="post" class="box">
                  <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                  <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                  <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                  <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                  <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                  <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                  <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                  <a href="category.php?category=<?= $fetch_products['category']; ?>"
                     class="cat"><?= $fetch_products['category']; ?></a>
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <div class="flex">
                     <div class="price"><span>₱ </span><?= $fetch_products['price']; ?></div>
                     <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                  </div>
               </form>
               <?php
            }
         } else {
            echo '<p class="home-empty empty">no products added yet!</p>';
         }
         ?>

      </div>

      <div class="more-btn">
         <a href="menu.php" class="btn">veiw all</a>
      </div>

   </section>

   <div class="svg-container">
      <img src="./images/designs/smoke-8.svg" alt="" class="bg" id="smoke-1">
      <img src="./images/designs/smoke-4.svg" alt="" class="bg" id="smoke-2">
      <img src="./images/designs/smoke-6.svg" alt="" class="bg" id="smoke-3">
      <img src="./images/designs/potato-2.svg" alt="" class="bg" id="potato">
      <img src="./images/designs/hotdog-3.svg" alt="" class="bg" id="hotdog">
      <img src="./images/designs/lettuce.svg" alt="" class="bg" id="lettuce">
   </div>


   <?php include 'components/footer.php'; ?>


   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <script>

      var swiper = new Swiper(".hero-slider", {
         loop: true,
         grabCursor: true,
         effect: "flip",
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         navigation: {
            nextEl: ".swiper-button-next", // Next button selector
            prevEl: ".swiper-button-prev", // Previous button selector
         },
      });

   </script>

</body>

</html>