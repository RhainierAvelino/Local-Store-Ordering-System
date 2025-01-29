<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

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

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styles.css">

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
         <p>At Old Yorker's, we pride ourselves on offering snacks that are made only with the freshest and real ingredients. Unlike many snack bars that use powders and artificial flavorings, we use real coffee beans for our coffee, fresh lemons for our lemonades, premium U.S. hotdog for our sandwiches, and only the most natural ingredients for our snacks and beverages. We value our commitment to quality, and we believe that quality doesn't mean costly. We also offer free delivery for orders within Metro Manila, making it easier than ever to enjoy your favorite snacks. With 8 locations and counting, we're excited to expand and bring our specialties closer to you!</p>
         <a href="menu.php" class="btn">Our menu</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<section class="franchise">
   <h1 class="title">Work with us!</h1>
      <div class="container">
         <div class="column">
            <img src="images/franchise-poster.png" alt="Franchise Poster">
         </div>
         <div class="column">
            <img src="images/franchise-details.png" alt="Franchise Details">
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
            <p>Love their Cheesy Hotdog Sandwich! Hindi talaga tinipid sa ingredients. The Chicken Poppers are so good with their dip! ✨</p>
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
            <p>yum ang food & budget-friendly! also, good din ang service, very responsive sila. would definitely try again and reco this 🤍</p>
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
            <p>Would recommend! Masarap yung food and friendly mga staff. A must try yung chicken poppers and mojos!</p>
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
            <p>Super duper sulit sa price! Sobrang sarap! Ang bilis pang mag deliver ❤️ Ang laki pa ng serving. Thankyou super satisfied!</p>
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
            <p>If only this was close to our place- I will definitely buy so often if so! Definitely worth the wait! Highly recommend this place!</p>
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
<!-- footer section ends -->=






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
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

</body>
</html>