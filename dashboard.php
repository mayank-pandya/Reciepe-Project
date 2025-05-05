<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="recipepage.css">
  <title>Kitchen Notes Dashboard</title>



  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const user = JSON.parse(localStorage.getItem("user"));
      const loginLink = document.getElementById("loginLink");
      const logoutLink = document.getElementById("logoutLink");

      if (user && user.id) {
        // Hide login, show logout
        loginLink.style.display = "none";
        logoutLink.style.display = "inline";

        logoutLink.addEventListener("click", (e) => {
          e.preventDefault();
          localStorage.removeItem("user");
          // Optional: you can call logout.php here to destroy session if needed
          window.location.href = "login.php";
        });
      }
    });
  </script>



</head>

<body>

  <!-- Navbar -->
  <nav>
    <div class="top">
      <div class="logo">Kitchen Notes</div>
      <div class="nav">
        <a href="index.html">Home</a>
        <a href="recipepage.php">Recipes</a>

        <a href="login.php" id="loginLink">Login</a>
        <a href="#" id="logoutLink" style="display: none;">Logout</a>

        <a href="add-reciepe.php">Add Recipe</a>
        <a href="about.html">About Us</a>
      </div>
      <div class="search"></div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="home" style="background: none;">
    <div class="heading">
      <div class="left">
        <p>Are You Hungry?</p>
        <h1>Don't Wait</h1>
        <p>Let's Make Food Now</p>
        <button><a href="recipepage.html">Check Out Recipe</a></button>
      </div>
      <div class="right" id="food"></div>

      <div class="socialmedia">
        <i class="fa-brands fa-facebook"></i>
        <i class="fa-brands fa-instagram"></i>
        <i class="fa-brands fa-whatsapp"></i>
      </div>
    </div>
  </section>


  <!-- Trending Recipes -->
  <section class="section" style="background: none;">
    <h1>Trending Recipes</h1>
    <div class="recipe-section">
      <div class="recipe-box">
        <a href="https://www.youtube.com/watch?v=G3-EASdBTOU" target="_blank">
          <img src="images/malaikofta.jpg" alt="Malai Kofta" />
          <h3>Malai Kofta</h3>
          <p>Deep-fried balls made from mashed potatoes and paneer in creamy tomato gravy.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="https://www.youtube.com/watch?v=G3-EASdBTOU" target="_blank">
          <img src="images/shahi.jpg" alt="Shahi Paneer" />
          <h3>Shahi Paneer</h3>
          <p>Paneer cubes in a rich, creamy cashew-based gravy—perfect for special occasions.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/ghevar.jpg" alt="Ghevar" />
          <h3>Ghevar</h3>
          <p>A Rajasthani dessert with chocolate, rabri, and fruit toppings.</p>
        </a>
      </div>
    </div>

    <a href="recipepage.html"><button>View More</button></a>

  </section>

</body>

</html>