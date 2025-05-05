<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recipe Page</title>
  <link rel="stylesheet" href="recipepage.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">



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



  <!-- Trending Recipes -->
  <section class="section">
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
  </section>

  <!-- Gujarati Dishes -->
  <section class="section">
    <h1>Gujarati Dishes</h1>
    <div class="recipe-section">
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/khaman.jpg" alt="Khaman Dhokla" />
          <h3>Khaman Dhokla</h3>
          <p>Steamed savory snack made from gram flour, fluffy and light in texture.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/fada.jpg" alt="Fafda Jalebi" />
          <h3>Fafda-Jalebi</h3>
          <p>A classic combo with crispy fafda and syrup-soaked jalebi.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/thepla2.jpg" alt="Thepla" />
          <h3>Thepla</h3>
          <p>Spicy Gujarati flatbread made from wheat flour, methi, and spices.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- Punjabi Dishes -->
  <section class="section">
    <h1>Punjabi Dishes</h1>
    <div class="recipe-section">
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/chole3.jpg" alt="Chole Bhature" />
          <h3>Chole Bhature</h3>
          <p>Spicy chickpeas served with fluffy fried bread.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/amrit.jpg" alt="Amritsari Kulcha" />
          <h3>Amritsari Kulcha</h3>
          <p>Stuffed flatbread baked in a tandoor and brushed with butter.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/ptm1.jpg" alt="Paneer Tikka Masala" />
          <h3>Paneer Tikka Masala</h3>
          <p>Grilled paneer cubes in a spicy, rich tomato-based gravy.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- South Indian Dishes -->
  <section class="section">
    <h1>South Indian Dishes</h1>
    <div class="recipe-section">
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/dhosa.jpg" alt="Dosa" />
          <h3>Dosa</h3>
          <p>Thin, crispy crepe made from fermented rice and urad dal batter.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/idli.jpg" alt="Idli" />
          <h3>Idli</h3>
          <p>Soft, fluffy steamed cakes made from rice and black gram.</p>
        </a>
      </div>
      <div class="recipe-box">
        <a href="#" target="_blank">
          <img src="images/utpm.jpg" alt="Uttapam" />
          <h3>Uttapam</h3>
          <p>Thick pancake with toppings like onion, tomato, and coriander.</p>
        </a>
      </div>
    </div>
  </section>


  <?php
  require_once "./controls/functions.php";

  $recipes = fetchAll("
  SELECT recipes.*, users.first_name, users.last_name 
  FROM recipes 
  JOIN users ON recipes.user_id = users.id 
  ORDER BY recipes.id DESC
");
  ?>


  <section class="section">
    <h1>Community Recipes</h1>
    <div class="recipe-section">
      <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-box">
          <a href="<?= htmlspecialchars($recipe['youtube_link']) ?: '#' ?>" target="_blank">
            <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" />
            <h3><?= htmlspecialchars($recipe['title']) ?></h3>
            <p><?= htmlspecialchars($recipe['description']) ?></p>
          </a>
          <p><strong>👨‍🍳 Submitted by:</strong> <?= htmlspecialchars($recipe['first_name'] . ' ' . $recipe['last_name']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>


</body>

</html>