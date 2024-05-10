<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./src/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-5 px-5">
            <h1 class="display-4 fw-bold">
                User Management
            </h1>
            <hr>
            <p class="lead">
                Click here to add a new user
            </p>
            <a href="create.php" class="btn btn-success col-12" >Add new user</a>
        </div>
        <div class="col-7 px-5">
            <h1 class="display-6">
                List of users
            </h1>
            <hr>
            <div class="overflowTable">
            <table class="table table-hover table-dark table-striped col-12 border rounded rounded-5">
            <thead>
                <tr>
                    <th class="border">ID</th>
                    <th class="border">Username</th>
                    <th class="border">Email</th>
                    <th class="border">Action</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- User data will be populated here -->
                <?php
                // Include the read.php file to fetch users from the database
                include 'read.php';

                // Fetch users
                $users = getUsers();

                // Display users in the table
                if ($users !== false) {
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>
                                <div class='d-flex justify-content-center p-3'>
                                    {$user['id']}
                                </div>
                              </td>";
                        echo "<td>
                                <div class='d-flex justify-content-center p-3'>
                                {$user['username']}
                                </div>
                            </td>";
                        echo "<td>
                                    <div class='d-flex justify-content-center p-3'>
                                        {$user['email']}
                                    </div>
                                </td>";
                        echo "<td>

                            <div class='d-flex justify-content-center p-3'>
                                <a class='btn btn-primary col-6 me-2' href='update.php?id={$user['id']}'>Edit</a>
                                <a class='btn btn-danger col-6' href='#' onclick='deleteUser({$user['id']})'>Delete</a>
                            </div>
                         
                         </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                ?>

                
            </tbody>
            </table>
            </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    // Function to delete a user
    function deleteUser(id) {
        Swal.fire({  // Show SweetAlert confirmation dialog
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {  // If user confirms deletion
                // Send AJAX request to delete.php with the user's ID
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Reload the table data after successful deletion
                        document.getElementById('userTableBody').innerHTML = xhr.responseText;
                    } else {
                        // Handle error
                        console.error('Failed to delete user.');
                    }
                };
                xhr.send('id=' + id); // Pass the user's ID as a parameter
                window.location.reload()
            }
        })
    }
</script>
</body>
</html>
