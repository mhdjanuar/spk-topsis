<?php
    session_start();
    include "../../koneksi.php"; // Include your database connection file

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and execute the query
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Debugging: Print the entered password and the hashed password from the database
            // echo "Entered Password: " . htmlspecialchars($password) . "<br>";
            // echo "Hashed Password from DB: " . htmlspecialchars($user['password']) . "<br>";
            // echo "Test :>> " . password_verify(htmlspecialchars($password), htmlspecialchars($user['password'])) . "<br>";
            
            // Verify the password
            if (htmlspecialchars($password) === htmlspecialchars($user['password'])) {
                // Password is correct, start the session
                $_SESSION['username'] = $username;
                header("Location: ../../index.php"); // Redirect to the main page
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }

        $stmt->close();
    }
?>