<?php

// Establishing connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();
require_once('../private/prepared.php');
$title = "Delete a cocktail | Zhu's Cocktail Gallery";

include('includes/header.php');
include('includes/admin-buttons.php');



?>

<main class="container">
  <section>
    <h1 class="fw-light">Current cocktails</h1>
    <p class="text-muted mb-5">To delete it from our system, press the 'Delete' button beside one of the
      entries down below.</p>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-2">

      <?php

      // Execute the select statement to retrieve all attractions
      $cocktails = get_all_cocktails();

      if (count($cocktails) > 0) {
        foreach ($cocktails as $cocktail) {
          extract($cocktail);
          echo "
      <div class=\"col\">
      <div class=\"card p-0 shadow-sm mb-3\">

          <img src=\"images/thumbs/$filename\" alt=\"$flavour\" class=\"card-img-top\">

          <div class=\"card-body\">

              <h2 class=\"card-text fs-4\">$cocktail_name</h2>
              <p class=\"card-text text-muted\">flavour: $flavour</p>
              <p class=\"card-text text-muted\">Added on $uploaded_on</p>
              <a href=\"delete-confirmation.php?cocktail=" . urlencode($cid) . "&cocktail_name=" . urlencode($cocktail_name) . "\" class=\"btn btn-danger\">Delete</a>
          </div>
      </div>
      </div>
      ";
        }



      } else {
        echo "<p>Sorry, there are no records available.</p>";
      }

      ?>
    </div>
  </section>
</main>
<?php

include('includes/footer.php');
db_disconnect($connection);
?>