<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link href="https://fonts.cdnfonts.com/css/dk-headlock" rel="stylesheet">
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <div class="heading">
      <h3>about us</h3>
      <p><a href="home.php">home</a> <span> / about</span></p>
   </div>

   <!-- about section starts  -->

   <section class="about">

      <div class="row">

         <div class="image">
            <img src="images/why-choose.png" alt="">
         </div>

         <div class="content">
            <h3>why choose us?</h3>
            <p>At Old Yorker's, we pride ourselves on offering snacks that are made only with the freshest and real
               ingredients. Unlike many snack bars that use powders and artificial flavorings, we use real coffee beans
               for our coffee, fresh lemons for our lemonades, premium U.S. hotdog for our sandwiches, and only the most
               natural ingredients for our snacks and beverages. We value our commitment to quality, and we believe that
               quality doesn't mean costly. We also offer free delivery for orders within Metro Manila, making it easier
               than ever to enjoy your favorite snacks. With 8 locations and counting, we're excited to expand and bring
               our specialties closer to you!</p>
            <a href="menu.php" class="btn">Our menu</a>
         </div>

      </div>

   </section>

   <!-- about section ends -->

   <section class="franchise">
  <h1 class="title">Work with us!</h1>
  <div class="container">
    <div class="column image-column">
      <img src="images/franchise-poster.png" alt="Franchise Poster">
    </div>
    <div class="column cards-column">
      <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h3 class="my-0 fw-normal">Silver</h3>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">₱34,998</h1>
              <h4 class="text-body-secondary fw-light">one-time payment</h4>
              <ul class="list-unstyled mt-3 mb-4">
                <li>End-to-End Training</li>
                <li>Complete Recipe Modules</li>
                <li>Setup Guide</li>
                <li>Branch Ownership</li>
                <li>Starting Products - ₱15K</li>
                <li>Basic Equipment</li>
                <li>‎ </li>
              </ul>
              <h4>ONLINE-SELLING SETUP</h4>
              <button type="button" class="w-100 btn btn-lg btn-primary">PURCHASE</button>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h3 class="my-0 fw-normal">Gold</h3>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">₱69,998</h1>
              <h4 class="text-body-secondary fw-light">one-time payment</h4>
              <ul class="list-unstyled mt-3 mb-4">
                <li>End-to-End Training</li>
                <li>Complete Recipe Modules</li>
                <li>Setup Guide</li>
                <li>Branch Ownership</li>
                <li>Starting Products - ₱25K</li>
                <li>Complete Equipment</li>
                <li>Cart with Cabinets</li>
              </ul>
              <h4>PHYSICAL CART SETUP</h4>
              <button type="button" class="w-100 btn btn-lg btn-primary">PURCHASE</button>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm border-primary">
            <div class="card-header py-3 text-bg-primary border-primary">
              <h3 class="my-0 fw-normal">Diamond</h3>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">₱149,998</h1>
              <h4 class="text-body-secondary fw-light">one-time payment</h4>
              <ul class="list-unstyled mt-3 mb-4">
                <li>End-to-End Training</li>
                <li>Complete Recipe Modules</li>
                <li>Branch Ownership</li>
                <li>Starting Products - ₱50K</li>
                <li>LED Indoor Logo</li>
                <li>Complete Equipment</li>
                <li>Furnitures</li>
              </ul>
              <h4>PHYSICAL STORE SETUP</h4>
              <button type="button" class="w-100 btn btn-lg btn-primary">PURCHASE</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

   <section class="reviews">

      <h1 class="title">Customer Reviews</h1>

      <div class="swiper reviews-slider">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide">
               <img src="images/review1.jpg" alt="">
               <h3>Kristina Se</h3>
               <p>Love their Cheesy Hotdog Sandwich! Hindi talaga tinipid sa ingredients. The Chicken Poppers are so
                  good with their dip! ✨</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>

            <div class="swiper-slide slide">
               <img src="images/review2.jpg" alt="">
               <h3>Jaji Santillan</h3>
               <p>yum ang food & budget-friendly! also, good din ang service, very responsive sila. would definitely try
                  again and reco this 🤍</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>

            <div class="swiper-slide slide">
               <img src="images/review3.jpg" alt="">
               <h3>Rodolfo Montoya</h3>
               <p>Would recommend! Masarap yung food and friendly mga staff. A must try yung chicken poppers and mojos!
               </p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>

            <div class="swiper-slide slide">
               <img src="images/review4.jpg" alt="">
               <h3>Lovely Ubaldo</h3>
               <p>Highly recommended po mojos, sandwich at lemon yakult ninyo✨👌 Definitely, will order again🫶</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>

            <div class="swiper-slide slide">
               <img src="images/review5.jpg" alt="">
               <h3>Trina Martin</h3>
               <p>Super duper sulit sa price! Sobrang sarap! Ang bilis pang mag deliver ❤️ Ang laki pa ng serving.
                  Thankyou super satisfied!</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>

            <div class="swiper-slide slide">
               <img src="images/review6.png" alt="">
               <h3>Catlin Creeper</h3>
               <p>If only this was close to our place- I will definitely buy so often if so! Definitely worth the wait!
                  Highly recommend this place!</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>

   <!-- reviews section ends -->



















   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->






   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <script>

      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            700: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });

   </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>

</html>