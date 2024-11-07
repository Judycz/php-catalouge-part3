<?php

// Begin a new session. 
session_start();

// If the user is NOT logged in, we should kick them out.



// Set the title and bring in the header.
$title = "Profile | Welcome Back, " . $_SESSION['first_name'];
include('includes/header.php');
include('includes/admin-buttons.php');
// Establish a connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

?>

<main class="container">
  <section class="row text-center">
    <h2 class="display-4 brand">Cocktail Gallery</h2>
    <p class="lead">Welcome back,
      <?php echo $_SESSION['first_name']; ?>!
    </p>
    <p>It's good to see you.</p>
  </section>
</main>

<?php

include('includes/footer.php');

?>