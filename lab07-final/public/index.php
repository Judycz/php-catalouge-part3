<?php

//Begin a new session (if one doesn't already exist), else make session data accessible. 
session_start();

// Establish a connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

// Initialise message variable.
$message = isset($message) ?? "";

// Include everything necessary to log in.
include('../private/login-post.php');

$title = "Log In";
include("includes/header.php");
?>

<main class="container">
  <section class="row">
    <!-- Optional Message Block -->
    <?php if (isset($_GET['m']) && $_GET['m'] == 'logout'): ?>
      <p class="text-center text-warning py-3">You have successfully logged out.</p>
    <?php endif; ?>

    <!-- Introductory Copy -->
    <div class="col-md-6 p-4">
      <h2 class="brand display-4">Zhu's Cocktail Gallery</h2>

      <h2 class="display-4">Welcome to our cocktail haven! </h2>
      <p class="text-success">Immerse yourself in the art of mixology on our gallery page, showcasing a delightful array
        of cocktails. Explore, add, edit, and savor the experience as you contribute to our diverse collection. Craft
        your own concoctions, celebrate classics, and enjoy the freedom to shape our cocktail community. Cheers to the
        journey of flavors, where every sip tells a story. Embark on your cocktail adventure now!</p>



      <a href="register.php" class="btn btn-outline-dark">Sign Up Now</a>
    </div>

    <!-- Log In Form -->
    <div class="col-md-6 p-0 rounded text-center form-bg">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="login-form p-4">
        <!-- Heading -->
        <div class="mb-3">
          <h2 class="display-4 fw-light text-light">Welcome back.</h2>
          <p class="text-light">Please login below to access you account and enjoy the freshest cocktail.
            around.</p>
        </div>

        <!-- Warning -->
        <div class="text-warning my-5">
          <?php echo $message; ?>
        </div>

        <!-- Email -->
        <div class="mb-3 form-floating">
          <input type="email" id="email" name="email" class="form-control" placeholder="hello@example.ca">
          <label for="email">Email Address</label>
        </div>

        <!-- Password -->
        <div class="mb-3 form-floating">
          <input type="password" id="password" name="password" class="form-control" placeholder="SecretPassword">
          <label for="password">Password</label>
        </div>

        <!-- Submit -->
        <div class="mb-5 d-grid">
          <input type="submit" id="login-btn" name="login-btn" value="Sign In" class="btn btn-warning">
        </div>

        <!-- Not signed up? -->
        <p class="text-light mb-1">Don't have an account?</p>
        <a href="register.php" class="link-light">Sign Up Now</a>
      </form>
    </div>
  </section>
</main>

<?php
include("includes/footer.php");
?>