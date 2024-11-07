<?php

//Begin a new session (if one doesn't already exist), else make session data accessible. 
session_start();

// Establish a connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

$title = "Sign Up";
include("includes/header.php");

// Initialise message variable.
$message = (isset($message)) ? $message : "";

// Registration Form Handler
include("../private/register-post.php");
?>

<main class="container">
  <section class="row">
    <!-- Optional Message Block -->
    <?php if (isset($_GET['m']) && $_GET['m'] == 'logout'): ?>
      <p class="text-center text-warning py-3">You have successfully logged out.</p>
    <?php endif; ?>

    <!-- Introductory Copy -->
    <div class="col-md-6 p-4">
      <h2 class="brand display-4">Cocktail gallery</h2>

      <p>Welcome to our Cocktail community! Unlock a world of possibilities by joining us. Simply enter your email,
        name, and password below to kickstart your registration process. </p>


    </div>

    <!-- Registration Form -->
    <div class="col-md-6 p-0 rounded text-center bg-dark text-light">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form p-5">
        <h2 class="display-5 fw-light mb-4">Registration Form</h2>

        <div class="text-warning">
          <?php echo $message; ?>
        </div>

        <!-- First Name -->
        <div class="mb-3">
          <label for="first_name">First Name</label>
          <input type="text" id="first_name" name="first_name" class="form-control" value="<?php if (isset($first_name))
            echo $first_name; ?>">
        </div>

        <!-- Last Name -->
        <div class="mb-3">
          <label for="last_name">Last Name</label>
          <input type="text" id="last_name" name="last_name" class="form-control" value="<?php if (isset($last_name))
            echo $last_name; ?>">
        </div>

        <!-- Username -->
        <div class="mb-3">
          <label for="user_name">Username</label>
          <input type="text" id="user_name" name="user_name" class="form-control" value="<?php if (isset($user_name))
            echo $user_name; ?>">
        </div>

        <!-- Email Address -->
        <div class="mb-3">
          <label for="reg_email">Email Address</label>
          <input type="email" id="reg_email" name="reg_email" class="form-control" value="<?php if (isset($reg_email))
            echo $reg_email; ?>">
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="reg_password">Password</label>
          <input type="password" id="reg_password" name="reg_password" class="form-control" value="<?php if (isset($reg_password))
            echo $reg_password; ?>" aria-describedby="password-help">
          <p id="password-help" class="form-text text-light">Your password must be 8-20 characters in length, contain
            letters and numbers, and must not contain spaces, special characters, or emoji.</p>
        </div>

        <!-- Submit -->
        <div class="d-grid mb-3">
          <input type="submit" id="register-btn" name="register-btn" class="btn btn-warning" value="Register now!">
        </div>
      </form>
    </div>
  </section>
  <section>
    <h2>Log in</h2>
    <a href="index.php" class="btn btn-success">Log In</a>

  </section>
</main>

<?php
include("includes/footer.php");
?>