<?php
require 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apple Macintosh Computer Inventory</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,200;0,500;1,200;1,500&display=swap">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <h1>Apple Macintosh Computer Inventory</h1>

  <!-- Show how many versions of macOS have been released -->
  <h3>How Many Versions of macOS Have Been Released?</h3>
  <?php
  $sql = "SELECT COUNT(*) as version_count FROM macos_version";
  $stmt = $conn->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $num_versions = $row['version_count'];
  echo "<p>There have been $num_versions versions of macOS released thus far.</p>";
  ?>

  <!-- Show all macOS Versions, Listed by Date Order -->
  <h3>Show the Version Name, Release Name, Official Darwin OS Number, Date Announced, Date Released, and Date of Latest Release of All macOS Versions, Listed by Date Order</h3>
  <?php
  $sql_versions = "SELECT v.version_name, v.release_name, v.darwin, d.announced, d.released, d.last_release, v.url
                   FROM macos_version v
                   JOIN macos_dates d ON v.darwin = d.darwin
                   ORDER BY d.announced";
  $stmt_versions = $conn->query($sql_versions);
  $results_versions = $stmt_versions->fetchAll(PDO::FETCH_ASSOC);

  if ($results_versions) {
      echo "<table border='1'>
              <tr>
                <th>Version Name</th>
                <th>Release Name</th>
                <th>Official Darwin OS Number</th>
                <th>Date Announced</th>
                <th>Date Released</th>
                <th>Date of Latest Release</th>
                <th>URL</th>
              </tr>";

      foreach ($results_versions as $row) {
          echo "<tr>
                  <td>" . $row['version_name'] . "</td>
                  <td>" . $row['release_name'] . "</td>
                  <td>" . $row['darwin'] . "</td>
                  <td>" . $row['announced'] . "</td>
                  <td>" . $row['released'] . "</td>
                  <td>" . $row['last_release'] . "</td>
                  <td><a href='" . $row['url'] . "' target='_blank'>Link</a></td>
                </tr>";
      }
      echo "</table>";
  }
  ?>

  <!-- Show the Version Name (Release Name) and Year Released of all macOS Versions -->
  <h3>Show the Version Name (Release Name) and Year Released of all macOS Versions, Listed by Date Released</h3>
  <?php
  $sql_versions_year = "SELECT version_name, release_name, released FROM macos_version ORDER BY released";
  $stmt_versions_year = $conn->query($sql_versions_year);
  $results_versions_year = $stmt_versions_year->fetchAll(PDO::FETCH_ASSOC);

  if ($results_versions_year) {
      echo "<table border='1'>
              <tr>
                <th>Version Name (Release Name)</th>
                <th>Year Released</th>
              </tr>";

      foreach ($results_versions_year as $row) {
          $release_year = substr($row['released'], 0, 4); // Extract year from the release date
          echo "<tr>
                  <td>" . $row['version_name'] . " (" . $row['release_name'] . ")</td>
                  <td>" . $release_year . "</td>
                </tr>";
      }
      echo "</table>";
  }
  ?>

  <!-- Show the Current Inventory (Model Information) -->
  <h3>Show the Current Inventory (Excluding Comments)</h3>
  <?php
  $sql_inventory = "SELECT model, model_id, model_number, part_number, serial_number, darwin, url FROM macos_model";
  $stmt_inventory = $conn->query($sql_inventory);
  $results_inventory = $stmt_inventory->fetchAll(PDO::FETCH_ASSOC);

  if ($results_inventory) {
      echo "<table border='1'>
              <tr>
                <th>Model Name</th>
                <th>Model Identifier</th>
                <th>Model Number</th>
                <th>Part Number</th>
                <th>Serial Number</th>
                <th>Darwin OS Number</th>
                <th>Latest Supporting Darwin OS Number</th>
                <th>URL</th>
              </tr>";

      foreach ($results_inventory as $row) {
          echo "<tr>
                  <td>" . $row['model'] . "</td>
                  <td>" . $row['model_id'] . "</td>
                  <td>" . $row['model_number'] . "</td>
                  <td>" . $row['part_number'] . "</td>
                  <td>" . $row['serial_number'] . "</td>
                  <td>" . $row['darwin'] . "</td>
                  <td>20</td> <!-- Assume 20 is the latest Darwin version. Adjust as necessary -->
                  <td><a href='" . $row['url'] . "' target='_blank'>Link</a></td>
                </tr>";
      }
      echo "</table>";
  }
  ?>

  <!-- Show Model, Installed/Original OS, and Last Supported OS -->
  <h3>Show the Model, Installed/Original OS, and the Last Supported OS For the Current Inventory</h3>
  <?php
  $sql_os = "SELECT model, version_name, release_name FROM macos_version";
  $stmt_os = $conn->query($sql_os);
  $results_os = $stmt_os->fetchAll(PDO::FETCH_ASSOC);

  if ($results_os) {
      echo "<table border='1'>
              <tr>
                <th>Model</th>
                <th>Installed/Original OS</th>
                <th>Last Supported OS</th>
              </tr>";

      foreach ($results_os as $row) {
          echo "<tr>
                  <td>" . $row['model'] . "</td>
                  <td>" . $row['version_name'] . "</td>
                  <td>" . $row['release_name'] . "</td>
                </tr>";
      }
      echo "</table>";
  }
  ?>

</body>
</html>

<?php
// Close the PDO connection (optional as it will be closed when the script ends)
$conn = null;
?>
