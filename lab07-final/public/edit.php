<?php

// Establishing connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

// Importing our prepared statements.
require_once('../private/prepared.php');

// We need to define a unique title for this page.
$title = "Edit a cocktail | Zhu's Cocktail Gallery";
include("includes/header.php");

include('includes/admin-buttons.php');
// If the user isn't logged in, kick them out!

if (isset($_GET['cocktail_id'])) {
  $cocktail_id = $_GET['cocktail_id'];
} elseif (isset($_POST['cocktail_id'])) {
  $cocktail_id = $_POST['cocktail_id'];
} else {
  $cocktail_id = "";
}

$message = "";
$update_message = "";

$user_name = isset($_POST['submit']) ? trim($_POST['cocktail_name']) : "";
$user_place = isset($_POST['submit']) ? trim($_POST['origin_place']) : "";
$user_year = isset($_POST['submit']) ? trim($_POST['invention_year']) : "";
$user_siprit = isset($_POST['submit']) ? trim($_POST['base_spirit']) : "";

$user_mixer = isset($_POST['submit']) ? trim($_POST['mixer']) : "";
$user_style = isset($_POST['submit']) ? trim($_POST['serving_style']) : "";
$user_flavour = isset($_POST['submit']) ? trim($_POST['flavour']) : "";
$user_story = isset($_POST['submit']) ? trim($_POST['story']) : "";

if (isset($cocktail_id)) {
  if (is_numeric($cocktail_id) && $cocktail_id > 0) {
    $cocktail = select_cocktail_by_id($cocktail_id);
    if ($cocktail) {
      $existing_name = $cocktail['cocktail_name'];
      $existing_place = $cocktail['origin_place'];
      $existing_year = $cocktail['invention_year'];
      $existing_spirit = $cocktail['base_spirit'];

      $existing_mixer = $cocktail['mixer'];
      $existing_style = $cocktail['serving_style'];
      $existing_flavour = $cocktail['flavour'];
      $existing_story = $cocktail['story'];


    } else {
      $message .= "Sorry, there are no records available that match your query.";

    }
  }
}

if (isset($_POST['submit'])) {
  $do_i_proceed = TRUE;
  // name
  $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
  $user_name = mysqli_real_escape_string($connection, $user_name);
  if (strlen($user_name) < 0 || strlen($user_name) > 255) {
    $do_i_proceed = FALSE;
    $update_message .= "<p>Please enter a cocktail name that is shorter than 50 characters.</p>";
  }

  // //year
  // $user_year = filter_var($user_year, FILTER_SANITIZE_NUMBER_INT);
  // if (!is_numeric($user_year) || $user_year == FALSE) {
  //   $do_i_proceed = FALSE;
  //   $update_message .= "<p>Invention Year Must before 2023.</p>";
  // }

  //mixer
  $user_mixer = filter_var($user_mixer, FILTER_SANITIZE_STRING);
  $user_mixer = mysqli_real_escape_string($connection, $user_mixer);
  if (strlen($user_mixer) < 2 || strlen($user_mixer) > 255) {
    $do_i_proceed = FALSE;
    $update_message .= "<p>Please enter a cocktail mixer that is shorter than 50 characters.</p>";
  }

  //flavour
  $user_flavour = filter_var($user_flavour, FILTER_SANITIZE_STRING);
  $user_flavour = mysqli_real_escape_string($connection, $user_flavour);
  if (strlen($user_flavour) < 2 || strlen($user_flavour) > 255) {
    $do_i_proceed = FALSE;
    $update_message .= "<p>Please enter a cocktail flavour that is shorter than 255 characters.</p>";
  }
  //story
  $user_story = filter_var($user_story, FILTER_SANITIZE_STRING);
  $user_story = mysqli_real_escape_string($connection, $user_story);
  if (strlen($user_story) < 2 || strlen($user_story) > 255) {
    $do_i_proceed = FALSE;
    $update_message .= "<p>Please enter a cocktail story that is shorter than 50 characters.</p>";
  }

  if ($do_i_proceed == TRUE) {
    update_cocktail($user_name, $user_place, $user_year, $user_siprit, $user_mixer, $user_style, $user_flavour, $user_story, $cocktail_id);
    $message .= "<p>" . $user_name . " updated successfully!</p>";

    // Now, let's blank out some variables, which should close the modal window.
    $cocktail_id = "";
  }
}

?>

<main>
  <section>
    <h1 class="fw-light text-center mt-5">Edit A Record</h1>
    <p class="text-muted mb-5">To edit a record in our database, click 'Edit' beside the row you would like to
      change. Next, add your updated values into the form and hit 'Save'.</p>
    <?php if ($message != ""): ?>
      <div class="alert alert-info" role="alert">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-2">
      <!-- same code as home page almost -->
      <?php
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
                <a href=\"edit.php?cocktail_id=$cid\" class=\"btn btn-warning\">Edit</a>            
            </div>
        </div>
        </div>
       
        ";
        }
      } else {
        echo "<p>Sorry there are no records available that match your query</p>";
      }
      ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title fs-5" id="exampleModalLabel">
              Edit
              <?php echo $existing_name; ?>
            </h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- EDIT FORM -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

              <?php if (isset($update_message)): ?>
                <div class="message text-danger">
                  <?php echo $update_message; ?>
                </div>
              <?php endif; ?>
              <!-- name -->
              <div class="mb-3">
                <label for="cocktail-name" class="form-label">Cocktail Name</label>
                <input type="text" id="cocktail-name" name="cocktail-name" class="form-control" value="<?php
                if ($user_name != "") {
                  echo $user_name;
                } else {
                  echo $existing_name;
                }
                ?>">
              </div>
              <!-- place -->
              <div class="mb-3">
                <label for="origin-place" class="form-label">Origin Place</label>
                <select id="origin-place" name="origin-place" class="form-select form-select-lg">
                  <?php
                  $origin_place = [
                    "Latin America" => "Latin America",
                    "North America & Oceania" => "North America & Oceania",
                    "Western Europe" => "Western Europe",
                    "Middle East" => "Middle East",
                    "Africa" => "Africa",
                    "South Asia" => "South Asia",
                    "Eastern Europe & Central Asia" => "Eastern Europe & Central Asia",
                    "East Asia" => "East Asia"
                  ];
                  foreach ($origin_place as $key => $value) {
                    if ($user_place == $key or $existing_place == $key) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }

                    echo "<option value=\"$key\" $selected>$value</option>";
                  }
                  ?>
                </select>
              </div>
              <!-- year -->
              <div class="mb-3">
                <label for="invention-year" class="form-label">Invention Year</label>
                <input type="int" id="invention-year" name="invention-year" class="form-control" value="<?php
                if ($user_year != "") {
                  echo $user_year;
                } else {
                  echo $existing_year;
                }
                ?>">
              </div>
              <!-- spirit -->
              <div class="mb-3">
                <label for="base-spirit" class="form-label">Cocktail Base Spirit</label>
                <select id="base-spirit" name="base-spirit" class="form-select form-select-lg">
                  <?php
                  $base_spirit = [
                    "Gin" => "Gin",
                    "Vodka" => "Vodka",
                    "Tequila" => "Tequila",
                    "Whiskey" => "Whiskey",
                    "Rum" => "Rum",
                    "Prosecco" => "Prosecco",
                    "Aperol" => "Aperol",
                    "Bourbon" => "Bourbon"
                  ];
                  foreach ($base_spirit as $key => $value) {
                    if ($user_spirit == $key or $existing_spirit == $key) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }

                    echo "<option value=\"$key\" $selected>$value</option>";
                  }
                  ?>
                </select>
              </div>
              <!-- mixer -->
              <div class="mb-3">
                <label for="mixer" class="form-label">Cocktail Mixer</label>
                <input type="text" id="mixer" name="mixer" class="form-control" value="<?php
                if ($user_mixer != "") {
                  echo $user_mixer;
                } else {
                  echo $existing_mixer;
                }
                ?>">
              </div>
              <!-- serving style -->
              <div class="mb-3">
                <label for="serving-style" class="form-label">Cocktail Serving Style</label>
                <select id="base-spirit" name="base-spirit" class="form-select form-select-lg">
                  <?php
                  $serving_style = [
                    "Short Drink" => "Short Drink",
                    "Long Drink" => "Long Drink"
                  ];
                  foreach ($serving_style as $key => $value) {
                    if ($user_style == $key or $existing_style == $key) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }

                    echo "<option value=\"$key\" $selected>$value</option>";
                  }
                  ?>
                </select>
              </div>

              <!-- flavour -->
              <div class="mb-3">
                <label for="flavour" class="form-label">Flavour</label>
                <input type="text" id="flavour" name="flavour" class="form-control" value="<?php
                if ($user_flavour != "") {
                  echo $user_flavour;
                } else {
                  echo $existing_flavour;
                }
                ?>">
              </div>
              <!-- story -->
              <div class="mb-3">
                <label for="story" class="form-label">Cocktail Story</label>
                <input type="text" id="story" name="story" class="form-control" value="<?php
                if ($user_story != "") {
                  echo $user_story;
                } else {
                  echo $existing_story;
                }
                ?>">
              </div>
              <!-- Hidden Values -->
              <input type="hidden" name="cocktail_id" value="<?php echo $cocktail_id; ?>">

              <!-- Submit -->
              <input type="submit" value="Save" name="submit" class="btn btn-success">
            </form>
          </div>
        </div>
      </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<?php if ($cocktail_id): ?>

  <script>
    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});

    document.onreadystatechange = function () {
      myModal.show();
    };
  </script>

<?php endif; ?>


<?php

include('includes/footer.php');

?>