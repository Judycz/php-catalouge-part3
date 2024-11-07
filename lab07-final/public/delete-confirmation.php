<?php

// Establishing connection to the database.
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

// Importing our prepared statements.
require_once('../private/prepared.php');

// We need to define a unique title for this page.
$title = "Deletion Confirmation | Zhu's Cocktail Gallery";
include("includes/header.php");

// $city is our `cid`, the primary key; $city_name is the name of the city, which we will show the user.

$title = isset($_GET["cocktail_name"]) ? $_GET["cocktail_name"] : "";
$message = '';

if (isset($_GET['cocktail']) && is_numeric($_GET['cocktail']) && $_GET['cocktail'] > 0) {
    $cocktail_id = $_GET['cocktail'];
} else {
    $message = "<p>Please return to the 'delete' page and select an option from the table.</p>";
    $cocktail_id = NULL;
}

if (isset($_POST['confirm'])) {
    $hidden_id = $_POST['hidden_id'];
    // Call the function to delete the city
    delete_cocktail($hidden_id);

    $message = "<p>Your cocktail was deleted from the database.</p>";

    echo "<a href=\"gallery.php\" class=\"btn btn-primary mx-2\">Back to gallery</a>";
}

?>

<main>
    <section>
        <h1 class="fw-light text-center">Deletion Confirmation</h1>

        <?php if ($message): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif;

        if ($cocktail_id != NULL): ?>
            <p class="text-danger lead mb-5 text-center">Are you sure that you want to delete
                <?php echo $title; ?>?
            </p>


            <form action="<?php echo ($_SERVER['PHP_SELF']); ?>" method="POST">
                <!-- Hidden Value -->
                <input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo $cocktail_id; ?>">

                <!-- Submit -->
                <input type="submit" class="btn btn-danger d-block mx-auto" name="confirm" id="confirm"
                    value="Yes, I'm sure.">
            </form>

        <?php endif; ?>

    </section>
</main>

<?php

include('includes/footer.php');

?>