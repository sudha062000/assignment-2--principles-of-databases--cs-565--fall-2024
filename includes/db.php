<?php


function getMacOSVersionCount() {
    try {
        include_once "config.php";  // Include database credentials

        // Create a PDO connection
        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);

        // Prepare the query to count the number of versions
        $statement = $db->prepare("SELECT COUNT(*) FROM macos_version");

        // Execute the query
        $statement->execute();

        // Fetch the result
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Return the count
        return $row['COUNT(*)'];

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>getMacOSVersionCount</code> has generated the following error:</p>" .
             "<pre>$error</pre>" .
             "<p class='highlight'>Exiting…</p>";
        exit;
    }
}

// Function to display macOS version details
function getMacOSVersionsDetails() {
    try {
        include_once "config.php";  // Include database credentials

        // Create a PDO connection
        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);

        // Prepare the query to fetch version details
        $statement = $db->prepare("SELECT v.version_name, v.release_name, v.darwin, d.announced, d.released, d.last_release
                                   FROM macos_version v
                                   JOIN macos_dates d ON v.darwin = d.darwin
                                   ORDER BY d.announced");

        // Execute the query
        $statement->execute();

        // Fetch all results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Output the data in a table
        echo "<table border='1'>
                <tr>
                    <th>Version Name</th>
                    <th>Release Name</th>
                    <th>Official Darwin OS Number</th>
                    <th>Date Announced</th>
                    <th>Date Released</th>
                    <th>Date of Latest Release</th>
                </tr>";

        foreach ($results as $row) {
            echo "<tr>
                    <td>{$row['version_name']}</td>
                    <td>{$row['release_name']}</td>
                    <td>{$row['darwin']}</td>
                    <td>{$row['announced']}</td>
                    <td>{$row['released']}</td>
                    <td>{$row['last_release']}</td>
                  </tr>";
        }

        echo "</table>";

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>getMacOSVersionsDetails</code> has generated the following error:</p>" .
             "<pre>$error</pre>" .
             "<p class='highlight'>Exiting…</p>";
        exit;
    }
}

// Function to get macOS versions with their release years
function getMacOSVersionsWithYears() {
    try {
        include_once "config.php";  // Include database credentials

        // Create a PDO connection
        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);

        // Prepare the query to get version names with release years
        $statement = $db->prepare("SELECT version_name, release_name, YEAR(released) AS year_released
                                   FROM macos_version v
                                   JOIN macos_dates d ON v.darwin = d.darwin
                                   ORDER BY d.released");

        // Execute the query
        $statement->execute();

        // Fetch all results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Output the data in a table
        echo "<table border='1'>
                <tr>
                    <th>Version Name (Release Name)</th>
                    <th>Year Released</th>
                </tr>";

        foreach ($results as $row) {
            echo "<tr>
                    <td>{$row['version_name']} ({$row['release_name']})</td>
                    <td>{$row['year_released']}</td>
                  </tr>";
        }

        echo "</table>";

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>getMacOSVersionsWithYears</code> has generated the following error:</p>" .
             "<pre>$error</pre>" .
             "<p class='highlight'>Exiting…</p>";
        exit;
    }
}

// Function to get the current inventory of Macs
function getCurrentInventory() {
    try {
        include_once "config.php";  // Include database credentials

        // Create a PDO connection
        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS);

        // Prepare the query to fetch current inventory
        $statement = $db->prepare("SELECT model, model_id, model_number, part_number, serial_number, darwin,
                                          (SELECT darwin FROM macos_version WHERE darwin >= m.darwin ORDER BY darwin DESC LIMIT 1) AS latest_supported_darwin,
                                          url
                                   FROM macos_model m
                                   ORDER BY model");

        // Execute the query
        $statement->execute();

        // Fetch all results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Output the data in a table
        echo "<table border='1'>
                <tr>
                    <th>Model Name</th>
                    <th>Model Identifier</th>
                    <th>Model Number</th>
                    <th>Part Number</th>
                    <th>Serial Number</th>
                    <th>Darwin OS Number</th>
                    <th>Latest Supported Darwin OS Number</th>
                    <th>URL</th>
                </tr>";

        foreach ($results as $row) {
            echo "<tr>
                    <td>{$row['model']}</td>
                    <td>{$row['model_id']}</td>
                    <td>{$row['model_number']}</td>
                    <td>{$row['part_number']}</td>
                    <td>{$row['serial_number']}</td>
                    <td>{$row['darwin']}</td>
                    <td>{$row['latest_supported_darwin']}</td>
                    <td><a h
