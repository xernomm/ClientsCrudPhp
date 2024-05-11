<?php
// Include the database connection script
include 'connection.php';

// Create the 'users' table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$conn->query($sql);

function createUser($username, $email, $password) {
    global $conn; 

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        return false; // Input validation failed
    }

    // Sanitize input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash the password before storing it in the database (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert a new user record into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    // Prepare and execute SQL query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    if ($stmt->execute()) {
        return true; // Record inserted successfully
    } else {
        return false; // Error inserting record
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form submission
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Attempt to create a new user
    if (createUser($username, $email, $password)) {
        // Redirect to success page or user management page
        header("Location: index.php");
        exit;
    } else {
        // Handle error
        echo "Failed to create user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">

    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="col-7 px-5">
            <a class="mb-5 btn btn-primary col-4" href="index.php">Back to User Management</a>
            <h1 class="display-3 fw-bold">
                Add New User
            </h1>
            <hr>
            <form class="col-12 p-5 border rounded rounded-5 bg-white" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p class="display-6 mb-4">
                    New User Form
                </p>
            <!-- <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br> -->

            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder="Password" required>
                <label for="username">Username</label>              
            </div>

            <!-- 
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br> -->

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                <label for="email">Email</label>              
            </div>



            <!-- <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br> -->

            <div class="form-floating">
                <input type="password" class="form-control" id="password"  name="password" placeholder="Password" required>
                <label for="password">Password</label>              
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn mt-3 btn-success col-10">Submit</button>
            </div>

            </form>
        </div>
    </div>
   
</body>
</html>
