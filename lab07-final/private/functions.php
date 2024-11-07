<?php

// AUTHENTICATION FUNCTIONS //

function log_out()
{
  unset($_SESSION['first_name']);
  unset($_SESSION['user_id']);
  unset($_SESSION['last_login']);
  unset($_SESSION['login_expires']);

  session_destroy();

  header('Location: index.php?m=logout');
}

function count_records()
{
  global $connection;
  $sql = "SELECT COUNT(*) FROM cocktails;";
  $results = mysqli_query($connection, $sql);
  $count = mysqli_fetch_row($results);
  return $count[0];
}


/*function get_all_cocktails()
{
  global $connection;
  global $select_statement;

  if (!$select_statement->execute()) {
    handle_database_error("fetching items");
  } else {
    $result = $select_statement->get_result();
    $cocktails = [];
    while ($row = $result->fetch_assoc()) {
      $cocktails[] = $row;
    } // end of while
    return $cocktails;
  } // end of else
}
function select_cocktail_by_id($image_id)
{
  global $connection;
  global $specific_select_statement;

  $specific_select_statement->bind_param("i", $image_id);

  if (!$specific_select_statement->execute()) {
    handle_database_error("selecting cocktail by ID");
  }

  $result = $specific_select_statement->get_result();
  $specific_cocktail = $result->fetch_assoc();

  return $specific_cocktail;
}

//edit item
$update_statement = $connection->prepare("UPDATE lab06_cocktail_prep SET title = ?, flavour = ?, filename = ?, uploaded_on = ? where image_id = ?;");

//delete item
$delete_statement = $connection->prepare("DELETE FROM lab06_cocktail_prep WHERE image_id = ?;");


// Function to update an existing one
function update_cocktail($image_id, $title, $flavour, $filename, $uploaded_on)
{
  global $connection;
  global $update_statement;

  $update_statement->bind_param("issss", $image_id, $title, $flavour, $filename, $uploaded_on);
  $update_statement->execute();
}

// Function to delete a specific one by primary key
function delete_cocktail($image_id)
{
  global $connection;
  global $delete_statement;

  $delete_statement->bind_param("i", $image_id);

  if (!$delete_statement->execute()) {
    handle_database_error("deleting item");
  }
}
*/
?>