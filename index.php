<!DOCTYPE html>
<?php
include_once "includes/config.php";
require 'includes/db.php';
?>

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
        <section>
            <h2>How Many Versions of macOS Have Been Released?</h2>
            <div>
                <p>There have been <b><?php echo countOperatingSystemVersions(); ?></b> versions of macOS released thus far.</p>
            </div>
        </section>

        <!-- macOS Version Details Table -->
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

                        $macos_versions = fetchOperatingSystems();
                        foreach ($macos_versions as $version) {
                            echo "<tr>";
                            echo "<td>{$version['version_name']}</td>";
                            echo "<td>{$version['release_name']}</td>";
                            echo "<td>{$version['darwin']}</td>";
                            echo "<td>{$version['announced']}</td>";
                            echo "<td>{$version['released']}</td>";
                            echo "<td>{$version['last_release']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- macOS Version and Release Year Table -->
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

                        $macos_version_years = fetchOsVersionAndRelease();
                        foreach ($macos_version_years as $version) {
                            echo "<tr>";
                            echo "<td>{$version['name']}</td>";
                            echo "<td>{$version['released']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Current Inventory Table -->
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

                        $inventory = fetchCurrentDeviceInventory();
                        foreach ($inventory as $device) {
                            echo "<tr>";
                            echo "<td>{$device['model']}</td>";
                            echo "<td>{$device['model_id']}</td>";
                            echo "<td>{$device['model_number']}</td>";
                            echo "<td>{$device['part_number']}</td>";
                            echo "<td>{$device['serial_number']}</td>";
                            echo "<td>{$device['current_darwin']}</td>";
                            echo "<td>{$device['last_darwin']}</td>";
                            echo "<td><a href='{$device['url']}' target='_blank' rel='noopener'>Link</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Model OS Support Table -->
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

                        $model_os_support = fetchCurrentInventoryWithOs();
                        foreach ($model_os_support as $model) {
                            echo "<tr>";
                            echo "<td>{$model['model']}</td>";
                            echo "<td>{$model['device_release']}</td>";
                            echo "<td>{$model['model_release']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
