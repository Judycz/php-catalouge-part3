<?php

// Initialise our SQL query and parameters.
$sql = "SELECT * FROM cocktails WHERE 1=1";

// This string will hold the data types of everything we're looking for so that we can bind our parameters to our prepared statement. 
$types = "";

// This array will hold all of the values that we're actually going to bind.
$values = [];

// And this is just an empty array for parameters because we don't know how many ?'s we'll have in our prepared statement.
$parameters = [];

foreach ($active_filters as $filter => $filter_values) {
    // Check to see if this filter should be treated as a decimal range. 
    if (in_array($filter, ["invention_year"])) {
        foreach ($filter_values as $value) {
            // Here, we're splitting the numbers on the button into a minimum and maximum number to use in our range / BETWEEN query.
            list($min, $max) = explode("-", $value, 2);
            $range_queries[] = "$filter BETWEEN ? AND ?";
            // We're adding some data types (double or decimal values)
            $types .= "dd";
            $parameters[] = $min;
            $parameters[] = $max;
        }
        // Combine the range queries with OR and enclose in parenthesis. 
        if (count($range_queries) > 0) {
            $sql .= " AND (" . implode(" OR ", $range_queries) . ")";
        }
    } elseif (in_array($filter, ["base_spirit", "origin_place", "serving_style"])) {
        // Handle other filters
        $filter_queries = [];
        foreach ($filter_values as $value) {
            $filter_queries[] = "$filter = ?";
            $types .= "s";
            $parameters[] = $value;
        }
        // Combine the filter queries with OR and enclose in parenthesis.
        if (count($filter_queries) > 0) {
            $sql .= " AND (" . implode(" OR ", $filter_queries) . ")";
        }
    }
}



// Let's prepare and execute the query we built.
$statement = $connection->prepare($sql);
if ($statement === FALSE) {
    echo "Failed to prepare the statement: (" . $connection->errno . ") " . $connection->error;
    exit();
}

$statement->bind_param($types, ...$parameters);

// If there's an error when executing the statement, we'll print it out;
if (!$statement->execute()) {
    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
}

$result = $statement->get_result();

if ($result->num_rows > 0) {
    echo "<div class=\"row\">";
    while ($row = $result->fetch_assoc()) { ?>
        <div class="col-md-6 col-xl-4 mb-3">
            <div class="card px-0">
                <div class="card-header text-bg-dark">
                    <?php echo $row['cocktail_name']; ?>
                </div>
                <div class="card-body">
                    <p>Invention:
                        <?php echo $row['invention_year']; ?>
                    </p>
                    <p>Flavour:
                        <?php echo $row['flavour']; ?>
                    </p>
                </div>
            </div>
        </div>
    <?php }
    echo "</div>"; // end of .row, after all cards have been generated
} else {
    echo "<p>No results found.</p>";
}

?>