<?php

/*

On the server, there will also be the following directories: 

    /images
        /full
        /thumbs

*/

// Establish a connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

// Initialise all of our variables.
$message = $message ?? '';
$cocktail_name = $_POST['cocktail-name'] ?? '';
$origin_place = $_POST['origin-place'] ?? '';
$invention_year = $_POST['invention-year'] ?? '';
//$base_spirit = $_POST['base-spirit'] ?? '';
$selected_spirits = $_POST['base-spirit'] ?? [];
$mixer = $_POST['mixer'] ?? '';
$serving_style = $_POST['serving-style'] ?? '';
$flavour = $_POST['flavour'] ?? '';
$story = $_POST['story'] ?? '';

include('includes/header.php');
include('includes/admin-buttons.php');

// This script will process the files.
include('includes/upload.php');


?>
<main class="container">
  <section class="row justify-content-center py-5 my-5">
    <div class="col-6">
      <h1 class="fw-light mb-5">Upload Image Files</h1>

      <!-- Error Message -->
      <?php if ($message != ''): ?>
        <div class="alert alert-secondary my-3">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <!-- Preview: if there's a newly created image, we'll show a preview of it to the user. -->

      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <!-- cocktail name -->
        <div class="mb-3">
          <label for="cocktail-name">Cocktail Name</label>
          <input type="text" id="cocktail-name" name="cocktail-name" maxlength="50" class="form-control" value="<?php if (isset($cocktail_name))
            echo $cocktail_name; ?>" required>
        </div>

        <!-- origin_place	 -->
        <div class="mb-3">
          <label for="origin-place">Origin Place</label>
          <select name="origin-place" id="origin-place" class="form-select form-select-lg">

            <option value="Latin America" <?php if (isset($origin_place) && $origin_place == "Latin America") {
              echo "selected";
            } ?>>Latin America</option>

            <option value="North America & Oceania" <?php if (isset($origin_place) && $origin_place == "North America & Oceania") {
              echo "selected";
            } ?>>North America & Oceania</option>

            <option value="Western Europe" <?php if (isset($origin_place) && $origin_place == "Western Europe") {
              echo "selected";
            } ?>>Western Europe</option>

            <option value="Middle East" <?php if (isset($origin_place) && $origin_place == "Middle East") {
              echo "selected";
            } ?>>Middle East</option>

            <option value="Africa" <?php if (isset($origin_place) && $origin_place == "Africa") {
              echo "selected";
            } ?>>Africa</option>

            <option value="South Asia" <?php if (isset($origin_place) && $origin_place == "South Asia") {
              echo "selected";
            } ?>>South Asia</option>

            <option value="East Asia" <?php if (isset($origin_place) && $origin_place == "East Asia") {
              echo "selected";
            } ?>>East Asia</option>

            <option value="Eastern Europe & Central Asia" <?php if (isset($origin_place) && $origin_place == "Eastern Europe & Central Asia") {
              echo "selected";
            } ?>>Eastern Europe & Central Asia</option>

          </select>
        </div>
        <!-- invention_year -->
        <div class="mb-3">
          <label for="invention-year" class="form-label">Invention Year</label>
          <input type="int" name="invention-year" class="form-control" required
            value="<?php echo isset($_GET['invention-year']) ? $_GET['invention-year'] : ''; ?>">
        </div>
        <!-- base_spirit -->
        <div class="mb-3">
          <legend>Base Spirit</legend>
          <div class="row justify-content-start">
            <div class="col-4">
              <div class="mb-2">
                <input type="checkbox" id="gin" name="base-spirit[]" value="Gin" <?php if (in_array("gin", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="gin">Gin</label>
              </div>

              <div class="mb-2">
                <input type="checkbox" id="vodka" name="base-spirit[]" value="Vodka" <?php if (in_array("vodka", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="vodka">Vodka</label>
              </div>

              <div class="mb-2">
                <input type="checkbox" id="rum" name="base-spirit[]" value="Rum" <?php if (in_array("rum", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="rum">Rum</label>
              </div>

              <div class="mb-2">
                <input type="checkbox" id="tequila" name="base-spirit[]" value="Tequila" <?php if (in_array("tequila", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="tequila">Tequila</label>
              </div>
            </div>
            <div class="col-4">
              <div class="mb-2">
                <input type="checkbox" id="whiskey" name="base-spirit[]" value="Whiskey" <?php if (in_array("whiskey", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="whiskey">Whiskey</label>
              </div>

              <div class="mb-2">
                <input type="checkbox" id="prosecco" name="base-spirit[]" value="Prosecco" <?php if (in_array("prosecco", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="prosecco">Prosecco</label>
              </div>

              <div class="mb-2">
                <input type="checkbox" id="aperol" name="base-spirit[]" value="Aperol" <?php if (in_array("aperol", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="aperol">Aperol</label>
              </div>

              <div class="mb-2">
                <input type="checkbox" id="bourbon" name="base-spirit[]" value="Bourbon" <?php if (in_array("bourbon", $selected_spirits)) {
                  echo "checked";
                } ?>>
                <label for="bourbon">Bourbon</label>
              </div>
            </div>
          </div>
          <!-- mixer -->
          <div class="mb-3">
            <label for="mixer">Mixer</label>
            <input type="text" id="mixer" name="mixer" maxlength="255" class="form-control" value="<?php if (isset($mixer))
              echo $mixer; ?>" required>
          </div>
          <!-- serving_style	 -->
          <div class="mb-3">
            <label for="serving-style">Serving Style</label>
            <select name="serving-style" id="serving-style" class="form-select form-select-lg">

              <option value="short" <?php if (isset($serving_style) && $serving_style == "short") {
                echo "selected";
              } ?>>Short Drink</option>

              <option value="long" <?php if (isset($serving_style) && $serving_style == "long") {
                echo "selected";
              } ?>>Long Drink</option>
            </select>
          </div>
          <!-- flavour -->
          <div class="mb-3">
            <label for="flavour">Flavour</label>
            <input type="text" id="flavour" name="flavour" maxlength="255" class="form-control" value="<?php if (isset($flavour))
              echo $flavour; ?>" required>
          </div>

          <!-- story -->
          <div class="mb-3">
            <label for="story" class="form-label">Cocktail Story</label>
            <textarea name="story" id="story" class="form-control">
                        <?php if (isset($_POST['story']))
                          echo $_POST['story']; ?>
          </textarea>
            <p class="fw-6 text-secondary">We can fit a maximum of 255 characters on our storys.</p>
          </div>

          <!-- File Upload -->
          <div class="mb-3">
            <label for="img-file">Image File</label>
            <input type="file" id="img-file" name="img-file" class="form-control" accept=".jpg, .jpeg, .png, .webp"
              required>
          </div>

          <!-- Submit -->
          <div class="my-5">
            <input type="submit" name="submit" id="submit" value="Upload" class="btn btn-primary">
          </div>
      </form>



    </div>
  </section>
</main>

<?php
include('includes/footer.php');

?>