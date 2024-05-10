<?php
// Include the database connection script
include 'connection.php';

function deleteUser($id) {
    global $conn; // Using the $conn variable from connection.php

    // SQL query to delete the specified user record from the database
    $sql = "DELETE FROM users WHERE id=$id";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        return true; // Record deleted successfully
    } else {
        return false; // Error deleting record
    }
}

// Check if the id parameter is set in the POST request
if(isset($_POST['id'])) {
    // Get the id parameter
    $id = $_POST['id'];

    // Call the deleteUser function to delete the user with the specified id
    if(deleteUser($id)) {
        // If deletion is successful, return a success message or updated user list
        echo "<script>
                Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'User deleted successfully',
                showConfirmButton: false,
                timer: 1500
                });
            </script>";
    } else {
        // If deletion fails, return an error message
        echo "Failed to delete user";
    }
} else {
    // If id parameter is not set in the POST request, return an error message
    echo "No user ID provided";
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

