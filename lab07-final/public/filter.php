<?php

// Establish a connection handle
require_once('/home/zchen41/data/connect.php');
$connection = db_connect();

$title = "Filters";
include('includes/header.php');
include('includes/admin-buttons.php');

// Here, we're going to define our filters and their options. 
$filters = [
  "base_spirit" => [
    "Gin" => "Gin",
    "Vodka" => "Vodka",
    "Tequila" => "Tequila",
    "Whiskey" => "Whiskey",
    "Rum" => "Rum",
    "Prosecco" => "Prosecco",
    "Aperol" => "Aperol",
    "Bourbon" => "Bourbon",
  ],

  "origin_place" => [
    "Latin America" => "Latin America",
    "North America" => "North America & Oceania",
    "Western Europe" => "Western Europe",
    "Middle East" => "Middle East",
    "Africa" => "Africa",
    "South Asia" => "South Asia",
    "Eastern Europe  Central Asia" => "Eastern Europe & Central Asia",
    "East Asia" => "East Asia",
  ],

  "invention_year" => [
    "0-1800" => "earlier",
    "1800-1899" => "19th century",
    "1900-2000" => "20th century",
    "2000-2023" => "21st century"
  ],

  "serving_style" => [
    "short" => "Short Drink",
    "long" => "Long Drink"
  ]
];

// Retrieve the active filters from the query string (if any).
$active_filters = [];
foreach ($_GET as $filter => $values) {
  if (!is_array($values)) {
    $values = [$values];
  }
  $active_filters[$filter] = array_map("htmlspecialchars", $values);
}

?>

<main class="container">
  <section class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
      <h2 class="display-5">Filter the Data</h2>
      <p class="mb-5">Select any combination of the buttons below to filters the data.</p>

      <?php
      // Generate the filter buttons
      foreach ($filters as $filter => $options) {
        // Replace underscores or dashes with spaces and capitalise the words for the heading
        $heading = ucwords(str_replace(["_", "-"], " ", $filter));
        // Add a heading before each button group
        echo "<h3 class=\"fw-light\">" .
          htmlspecialchars($heading) .
          "</h3>";

        echo '<div class="btn-group mb-3" role="group" aria-label="' .
          htmlspecialchars($filter) .
          ' Filter Group">';
        foreach ($options as $value => $label) {
          $is_active = in_array(
            $value,
            $active_filters[$filter] ?? []
          );
          $updated_filters = $active_filters;

          if ($is_active) {
            $updated_filters[$filter] = array_diff(
              $updated_filters[$filter],
              [$value]
            );
            if (empty($updated_filters[$filter])) {
              unset($updated_filters[$filter]);
            }
          } else {
            $updated_filters[$filter][] = $value;
          }

          $url =
            $_SERVER["PHP_SELF"] .
            "?" .
            http_build_query($updated_filters);
          echo '<a href="' .
            htmlspecialchars($url) .
            '" class="btn ' .
            ($is_active ? "btn-success" : "btn-outline-success") .
            '">' .
            htmlspecialchars($label) .
            "</a>";
        } // end of inner foreach
        echo "</div>";
      }
      // Check if any filters are active; if they are, spit out the results! 
      if (!empty($active_filters)): ?>
        <hr>
        <div class="row">
          <?php include("includes/filter_results.php"); ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php

include('includes/footer.php');

db_disconnect($connection);

?>