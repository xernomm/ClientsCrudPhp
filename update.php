<?php
// Include the database connection script
include 'connection.php';

function updateUser($id, $newUsername, $newEmail) {
    global $conn; // Using the $conn variable from connection.php

    // Sanitize input to prevent SQL injection
    $newUsername = mysqli_real_escape_string($conn, $newUsername);
    $newEmail = mysqli_real_escape_string($conn, $newEmail);

    // SQL query to update the specified user record in the database
    $sql = "UPDATE users SET username='$newUsername', email='$newEmail' WHERE id=$id";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        return true; // Record updated successfully
    } else {
        return false; // Error updating record
    }
}

// Check if ID is provided
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data based on ID
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, retrieve data
        $user = $result->fetch_assoc();
        $username = $user['username'];
        $email = $user['email'];
    } else {
        // No user found with the given ID
        echo "User not found";
        exit;
    }
} else {
    // No ID provided
    echo "No user ID provided";
    exit;
}

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve new values from form submission
    $newUsername = $_POST["newUsername"];
    $newEmail = $_POST["newEmail"];

    // Update user
    if(updateUser($id, $newUsername, $newEmail)) {
        // Redirect to index.php or display success message
        header("Location: index.php");
        exit;
    } else {
        // Handle error
        echo "Failed to update user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container">
            <div class="d-flex col-12 justify-content-center vh-100 align-items-center">
            <div class="col-10 border rounded rounded-5 p-4 bg-white">
                <h1 class="mt-5 mb-3">Update User</h1>
                <hr>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id={$id}"; ?>" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="newUsername" name="newUsername" placeholder="New Username:" value="<?php echo $username; ?>" required>
                            <label for="newUsername">New Username:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="New Email:" value="<?php echo $email; ?>" required>
                            <label for="newEmail">New Email:</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
        </div>
            </div>

    </div>
</body>
</html>

