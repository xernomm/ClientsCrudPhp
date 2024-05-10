<?php
// Include the database connection script
include 'connection.php';

function getUsers() {
    global $conn; // Using the $conn variable from connection.php

    // SQL query to retrieve all user records from the database
    $sql = "SELECT * FROM users";

    // Execute SQL query
    $result = $conn->query($sql);

    // Check if any records were returned
    if ($result->num_rows > 0) {
        $users = array();

        // Fetch each row from the result set
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users; // Return array of user records
    } else {
        return false; // No records found
    }
}

// Usage example:
// $users = getUsers();
// var_dump($users);
?>
