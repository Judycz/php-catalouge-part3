<?php

if (isset($_POST["register-btn"])) {
  $first_name = mysqli_real_escape_string($connection, trim($_POST["first_name"]));
  $last_name = mysqli_real_escape_string($connection, trim($_POST["last_name"]));
  $user_name = mysqli_real_escape_string($connection, trim($_POST["user_name"]));
  $reg_email = mysqli_real_escape_string($connection, trim($_POST["reg_email"]));
  $reg_password = mysqli_real_escape_string($connection, trim($_POST["reg_password"]));

  // Validation Boolean
  $pass_go = TRUE;

  if (!empty($user_name) || !empty($reg_email)) {
    $check_sql = "SELECT * FROM cocktail_users WHERE (email = '$reg_email' OR user_name = '$user_name');";

    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
      // If there are any results, we need to kick the user out and make them fill in the form again.
      $row = mysqli_fetch_assoc($check_result);

      if ($reg_email == isset($row['email'])) {
        $message .= "<p>The provided email address is already associated with a registered account.</p>";
        $pass_go = FALSE;
      } elseif ($user_name == isset($row['user_name'])) {
        $message .= "<p>This username is already taken.</p>";
        $pass_go = FALSE;
      }

    }
  } // This is the end of the username / email check.

  // This is where we'd add a WHOLE LOT MORE validation. 

  // We'll do a null check for all of our form data.
  if (!$first_name || !$last_name || !$user_name || !$reg_email || !$reg_password) {
    $message .= "<p>All fields are required.</p>";
    $pass_go = FALSE;
  }

  if ($pass_go == TRUE) {
    // We need to make sure that the plain text password NEVER goes anywhere near a database.
    $hash = password_hash($reg_password, PASSWORD_DEFAULT);

    // Create prepared statement with placeholders.
    $sql = "INSERT INTO cocktail_users (first_name, last_name, user_name, email, pswd) VALUES (?, ?, ?, ?, ?);";

    $statement = $connection->prepare($sql);

    // Bind the variables to the statement.
    $statement->bind_param("sssss", $first_name, $last_name, $user_name, $reg_email, $hash);

    // Execute the statement.
    if ($statement->execute()) {
      $message .= "<p>You have successfully registered your account!</p>";
      // Blank out the form data so the user can't resubmit.
      $first_name = $last_name = $user_name = $reg_email = $reg_password = $hash = "";
    } else {
      $message .= "<p>An error occured while registering: " . $statement->error . "</p>";
    }

    $statement->close();
  }
}

?>