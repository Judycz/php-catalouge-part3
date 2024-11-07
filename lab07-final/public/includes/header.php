<?php

// Make sure the functions are included on every page.
include("../private/functions.php");

// Check to see if the user clicked 'log out'.
if (isset($_POST['logout'])) {
  log_out();
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>
    <?php echo $title; ?>
  </title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

  <!-- BS Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="css/styles.css">
</head>

<body class="d-flex flex-column justify-content-between min-vh-100">
  <header>
    <nav class="navbar bg-dark" bs-data-theme="dark">
      <div class="container-fluid">
        <a href="index.php" class="brand navbar-brand text-light">Zhu's Cocktail Gallery</a>

        <!-- We'll have to come back to this little guy later. -->
        <div class="text-end">
          <!-- Our big 'if logged in' goes here. -->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" id="logout" name="logout" class="btn btn-warning btn-sm" value="Log Out">
          </form>
        </div>
      </div>
    </nav>
  </header>