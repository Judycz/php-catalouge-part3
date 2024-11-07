<?php

// Establish a connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

include('includes/header.php');
include('includes/admin-buttons.php');


//page
// include('../private/functions.php');
// $per_page = 10;
// $total_count = count_records();
// $total_pages = ceil($total_count / $per_page);
// $current_page = (int) ($_GET['page'] ?? 1);
// if ($current_page < 1 || $current_page > $total_pages || !is_int($current_page)) {
//   $current_page = 1;
// }
// $offset = $per_page * ($current_page - 1);


?>

<main class="container">
  <section class="row justify-content-center py-5 my-5">
    <div class="col-6">
      <h1 class="fw-light mb-5">Image Gallery</h1>
      <p class="lead">Welcome to Cocktail gallery, uploaded by users just like you.</p>

      <a href="add.php" class="btn btn-primary">Upload More Cocktail Images</a>

      <hr class="my-5">

      <!-- Gallery Thumbs -->
      <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-2">
        <?php

        $query = "SELECT * FROM cocktails ORDER BY uploaded_on DESC;";

        $result = mysqli_query($connection, $query);


        // $query = "SELECT * FROM cocktails ORDER BY uploaded_on DESC LIMIT $per_page OFFSET $offset;";
        // $result = mysqli_query($connection, $query);
        

        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['cid'];
          $title = $row['cocktail_name'];
          $origin_place = $row['origin_place'];
          $invention_year = $row['invention_year'];
          $base_spirit = $row['base_spirit'];
          $mixer = $row['mixer'];
          $serving_style = $row['serving_style'];
          $flavour = $row['flavour'];
          $story = $row['story'];

          $filename = $row['filename'];
          $uploaded_on = $row['uploaded_on'];



          echo "
                        <div class=\"col\">
                        <div class=\"card p-0 shadow-sm\">

                            <img src=\"images/thumbs/$filename\" alt=\"$flavour\" class=\"card-img-top\">

                            <div class=\"card-body\">

                                <h2 class=\"card-text fs-4\">$title</h2>
                                <p class=\"card-text text-muted\">Added on $uploaded_on</p>

                                <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#modal$id\">
                                    View
                                </button>

                            </div>
                        </div>
                        </div>

                    ";

          ?>


          <!-- Modal -->
          <div class="modal fade" id="modal<?php echo $id; ?>" tabindex="-1"
            aria-labelledby="modal-title<?php echo $id; ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title fs-5" id="modal-title<?php echo $id; ?>">
                    <?php echo $title; ?>
                  </h3>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <?php
                  echo "<img src=\"images/full/$filename\" alt=\"$flavour\" class=\"img-fluid\" title=\"$flavour\">";
                  echo "<p class=\"mt-4\">Flavour:  $flavour </p>";
                  echo "<p class=\"mt-4\">Base Spirit:  $base_spirit </p>";
                  echo "<p class=\"mt-4\">Mixer:  $mixer </p>";
                  echo "<p class=\"mt-4\">Invention Year:  $invention_year </p>";
                  echo "<p class=\"mt-4\">Origin Place:  $origin_place </p>";
                  echo "<p class=\"mt-4\">History Story:  $story </p>";

                  ?>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <?php

        } // end of while loop
        ?>
      </div>
    </div>
  </section>
</main>

<!-- BS JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>

<?php

db_disconnect($connection);

?>