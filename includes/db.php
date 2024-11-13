<?php
// Function to initialize a database connection using PDO
function initializeDatabaseConnection(): PDO {
    include_once "includes/config.php"; // Assuming your config file is in the 'includes' directory

    try {
        // Establish the connection
        $db = new PDO(
            "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8",
            DBUSER, DBPASS
        );
        return $db;
    } catch (PDOException $e) {
        // Handle any errors with the connection
        echo $e->getMessage();
        exit;
    }
}

// Counts the total number of macOS versions
function countOperatingSystemVersions(): int {
    try {
        $db = initializeDatabaseConnection();
        $statement = $db->prepare("SELECT COUNT(*) FROM macos_version");
        $statement->execute();
        $cols = $statement->fetchAll();
        return $cols[0]['COUNT(*)'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// Fetches all macOS version details
function fetchOperatingSystems(): array {
    try {
        $db = initializeDatabaseConnection();
        $statement = $db->prepare("
            SELECT version_name, release_name, darwin, announced, released, last_release
            FROM macos_version
            NATURAL JOIN macos_dates
            ORDER BY announced
        ");
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// Formats the macOS version and release information for display
function formatVersionColumn(array $col): array {
    $colMod["name"] = $col["version_name"] . " (" . $col["release_name"] . ")";
    $colMod["released"] = substr($col["released"], 0, 4); // Just the year part
    return $colMod;
}

// Fetches macOS version and release names with release dates formatted
function fetchOsVersionAndRelease(): array {
    try {
        $db = initializeDatabaseConnection();
        $statement = $db->prepare("
            SELECT version_name, release_name, released
            FROM macos_version
            NATURAL JOIN macos_dates
            ORDER BY released
        ");
        $statement->execute();
        return array_map("formatVersionColumn", $statement->fetchAll());
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// Fetches the current device inventory with macOS compatibility details
function fetchCurrentDeviceInventory(): array {
    try {
        $db = initializeDatabaseConnection();
        $statement = $db->prepare("
            SELECT macos_model.model, macos_model.model_id, macos_model.model_number,
                   macos_model.part_number, macos_id.serial_number, -- Corrected to use macos_id for serial_number
                   macos_model.darwin AS current_darwin,
                   macos_version.darwin AS last_darwin, macos_model.url
            FROM macos_model
            LEFT JOIN macos_id ON macos_model.model_id = macos_id.model_id
            LEFT JOIN macos_version ON macos_model.darwin = macos_version.darwin
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// Fetches current inventory and its macOS version compatibility information
function fetchCurrentInventoryWithOs(): array {
    try {
        $db = initializeDatabaseConnection();
        $statement = $db->prepare("
            SELECT macos_model.model,
                   os_release.release_name AS model_release,
                   installed_release.release_name AS device_release
            FROM macos_model
            JOIN macos_version AS os_release ON macos_model.darwin = os_release.darwin
            JOIN macos_version AS installed_release ON macos_model.darwin = installed_release.darwin
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}
?>
