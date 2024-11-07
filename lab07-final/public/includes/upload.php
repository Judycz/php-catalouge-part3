<?php

if (isset($_POST['submit']) && !empty($_FILES['img-file']['name'])) {

  $cocktail_name = $_POST['cocktail-name'];
  $origin_place = $_POST['origin-place'];
  $invention_year = $_POST['invention-year'];
  $mixer = $_POST['mixer'];
  //$base_spirit = $_POST['base-spirit'];
  $base_spirits = isset($_POST['base-spirit']) ? $_POST['base-spirit'] : [];
  $base_spirit = implode(', ', $base_spirits);

  $serving_style = $_POST['serving-style'];
  $flavour = $_POST['flavour'];
  $story = $_POST['story'];

  $file = $_FILES['img-file'];
  $file_name = $_FILES['img-file']['name'];
  $file_temp_name = $_FILES['img-file']['tmp_name'];
  $file_size = $_FILES['img-file']['size'];
  $file_error = $_FILES['img-file']['error'];

  // Let's grab the uploaded file's extension.
  $file_extension = explode('.', $file_name);
  $file_extension = strtolower(end($file_extension));

  $allowed = array('jpg', 'jpeg', 'png', 'webp');

  if (in_array($file_extension, $allowed) && $file_error === 0 && $file_size < 2000000) {
    $file_name_new = uniqid('', true) . "." . $file_extension;
    $file_destination = 'images/full/' . $file_name_new;

    // Check to see if the directory exists; if not, make it.
    if (!is_dir('images/full/')) {
      mkdir('images/full/', 0777, true);
    }
    if (!is_dir('images/thumbs')) {
      mkdir('images/thumbs/', 0777, true);
    }

    // Check if the file already exists
    if (!file_exists($file_destination)) {
      // Move the uploaded file to the directory.
      move_uploaded_file($file_temp_name, $file_destination);

      // Check the image dimensions. 
      list($width_original, $height_original) = getimagesize($file_destination);

      // Creates an empty canvas that is 256px x 256px.
      $thumb = imagecreatetruecolor(256, 256);

      // Calculate the shorter side / smaller size between width and height.
      $smaller_size = min($width_original, $height_original);

      // Calculate the starting point for cropping the image.
      $x_coordinate = ($width_original > $smaller_size) ? ($width_original - $smaller_size) / 2 : 0;
      $y_coordinate = ($height_original > $smaller_size) ? ($height_original - $smaller_size) / 2 : 0;

      // Create image based on the filetype we grabbed earlier.
      switch ($file_extension) {
        case 'jpeg':
        case 'jpg':
          $src_image = imagecreatefromjpeg($file_destination);
          break;
        case 'png':
          $src_image = imagecreatefrompng($file_destination);
          break;
        case 'webp':
          $src_image = imagecreatefromwebp($file_destination);
          break;
        default:
          // Invalid Type
          $message .= "<p>This file type is not supported.</p>";
          exit;
      }

      // Crop and resize the user-uploaded image.
      imagecopyresampled($thumb, $src_image, 0, 0, $x_coordinate, $y_coordinate, 256, 256, $smaller_size, $smaller_size);

      // Save the thumbnail to the server.
      imagejpeg($thumb, 'images/thumbs/' . $file_name_new, 100);

      // Free up some server resources by destroying the working object.
      imagedestroy($thumb);
      imagedestroy($src_image);

      // Insert the image metadata to the database.
      $sql = "INSERT INTO cocktails (filename, cocktail_name, origin_place, invention_year,	base_spirit,	mixer,	serving_style,	flavour, story, uploaded_on) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

      $statement = $connection->prepare($sql);
      $statement->bind_param("sssisssss", $file_name_new, $cocktail_name, $origin_place, $invention_year, $base_spirit, $mixer, $serving_style, $flavour, $story);
      $statement->execute();

      $message .= "<p>Image uploaded successfully!</p>";
    } else {
      $message .= "<p>Your file is too big!</p>";
    }
  } else {
    $message .= "<p>There was an error with this file.</p>";
  }
}

?>