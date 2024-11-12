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
  <header>
    <h1>Apple Macintosh Computer Inventory</h1>
  </header>
  <main>

    <!-- How Many Versions of macOS Have Been Released? -->
    <section>
      <h2>How Many Versions of macOS Have Been Released?</h2>
      <div>
        <?php
        $sql = "SELECT COUNT(*) as total_versions FROM macos_version";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            echo "<p>There have been <b>{$row['total_versions']}</b> versions of macOS released thus far.</p>";
        }
        ?>
      </div>
    </section>

    <!-- List of macOS Versions -->
    <section>
      <h2>Show the Version Name, Release Name, Official Darwin OS Number, Date Announced, Date Released, and Date of Latest Release of All macOS Versions, Listed by Date Order</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Version Name</th>
              <th>Release Name</th>
              <th>Official Darwin OS Number</th>
              <th>Date Announced</th>
              <th>Date Released</th>
              <th>Date of Latest Release</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_versions = "SELECT v.version_name, v.release_name, v.darwin, d.announced, d.released, d.last_release
                             FROM macos_version v
                             JOIN macos_dates d ON v.darwin = d.darwin
                             ORDER BY d.announced";
            $result_versions = $conn->query($sql_versions);

            if ($result_versions) {
                while($row = $result_versions->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['version_name']) . "</td>
                            <td>" . htmlspecialchars($row['release_name']) . "</td>
                            <td>" . htmlspecialchars($row['darwin']) . "</td>
                            <td>" . htmlspecialchars($row['announced']) . "</td>
                            <td>" . htmlspecialchars($row['released']) . "</td>
                            <td>" . htmlspecialchars($row['last_release']) . "</td>
                          </tr>";
                }
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Version Name and Year Released -->
    <section>
      <h2>Show the Version Name (Release Name) and Year Released of all macOS Versions, Listed by Date Released</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Version Name (Release Name)</th>
              <th>Year Released</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_versions_year = "SELECT version_name, release_name, YEAR(released) as year_released FROM macos_version ORDER BY released";
            $result_versions_year = $conn->query($sql_versions_year);

            if ($result_versions_year) {
                while($row = $result_versions_year->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['version_name']) . " (" . htmlspecialchars($row['release_name']) . ")</td>
                            <td>" . htmlspecialchars($row['year_released']) . "</td>
                          </tr>";
                }
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Current Inventory (Excluding Comments) -->
    <section>
      <h2>Show the Current Inventory (Excluding Comments)</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Model Name</th>
              <th>Model Identifier</th>
              <th>Model Number</th>
              <th>Part Number</th>
              <th>Serial Number</th>
              <th>Darwin OS Number</th>
              <th>Latest Supporting Darwin OS Number</th>
              <th>URL</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_inventory = "SELECT model, model_id, model_number, part_number, serial_number, darwin, url FROM macos_model";
            $result_inventory = $conn->query($sql_inventory);

            if ($result_inventory) {
                while($row = $result_inventory->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['model']) . "</td>
                            <td>" . htmlspecialchars($row['model_id']) . "</td>
                            <td>" . htmlspecialchars($row['model_number']) . "</td>
                            <td>" . htmlspecialchars($row['part_number']) . "</td>
                            <td>" . htmlspecialchars($row['serial_number']) . "</td>
                            <td>" . htmlspecialchars($row['darwin']) . "</td>
                            <td>20</td> <!-- Assume 20 is the latest Darwin version. Adjust as necessary -->
                            <td><a href='" . htmlspecialchars($row['url']) . "' target='_blank' rel='noopener'>Link</a></td>
                          </tr>";
                }
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Model, Installed OS, and Last Supported OS -->
    <section>
      <h2>Show the Model, Installed/Original OS, and the Last Supported OS For the Current Inventory</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Model</th>
              <th>Installed/Original OS</th>
              <th>Last Supported OS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_os = "SELECT m.model, v.version_name AS installed_os, v.release_name AS last_supported_os
                       FROM macos_model m
                       JOIN macos_version v ON m.darwin = v.darwin";
            $result_os = $conn->query($sql_os);

            if ($result_os) {
                while($row = $result_os->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['model']) . "</td>
                            <td>" . htmlspecialchars($row['installed_os']) . "</td>
                            <td>" . htmlspecialchars($row['last_supported_os']) . "</td>
                          </tr>";
                }
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>

<?php
$conn->close();
?>
