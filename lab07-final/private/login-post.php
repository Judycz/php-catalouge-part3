<?php

if (isset($_POST['login-btn'])) {
  // In the real world, you'll need a whole lot more validation!
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Check to sees if both fields are filled out.
  if ($email && $password) {
    // We're going to look up the email to see if they are registered.
    $login_sql = "SELECT * FROM cocktail_users WHERE email = ?;";

    // First, let's prepare the statement.
    $statement = $connection->prepare($login_sql);

    // Now, we'll bind our single parameter.
    $statement->bind_param("s", $email);

    // And finally, we do the thing.
    $statement->execute();

    $result = $statement->get_result();

    if ($result->num_rows === 1) {
      $row = $result->fetch_assoc();

      if (password_verify($password, $row['pswd'])) {
        // This is to prevent session fixation attacks.
        session_regenerate_id();

        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['user_id'] = $row['cc_id'];

        // ... and we can store a bunch of time stamps.
        $_SESSION['last_login'] = time();

        header('Location: profile.php');
      } else {
        $message .= "<p>Password incorrect.</p>";
      }
    } else {
      $message .= "<p>Email address not associated with registered account.</p>";
    }
  } else {
    $message .= "<p>Both fields are required.</p>";
  }
}

?>