<?php
session_start();
require_once "../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['profilePictureFile']) && $_FILES['profilePictureFile']['error'] === UPLOAD_ERR_OK) {
        $userId = $_SESSION["user_id"]; // Replace with the logged-in user's ID (e.g., from session)
        $uploadDir = "../images/profiles/";
        $fileName = "user_" . $userId . "_" . time() . "_" . basename($_FILES['profilePictureFile']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profilePictureFile']['type'], $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit();
        }

        // Fetch the current profile picture from the database
        $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($currentProfilePicture);
        $stmt->fetch();
        $stmt->close();

        // Move uploaded file
        if (move_uploaded_file($_FILES['profilePictureFile']['tmp_name'], $uploadFile)) {
            // Save the relative path to the database
            $relativePath = "images/profiles/" . $fileName;

            // Update the user's profile picture in the database
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $relativePath, $userId);

            if ($stmt->execute()) {
                // Delete the old profile picture if it exists and is not the default picture
                if ($currentProfilePicture && $currentProfilePicture !== "images/profiles/default-profile.png") {
                    $oldFile = "../" . $currentProfilePicture;
                    if (file_exists($oldFile)) {
                        unlink($oldFile); // Delete the old file
                    }
                }

                echo json_encode(['status' => 'success', 'message' => 'Profile picture updated successfully.', 'filePath' => $relativePath]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database update failed: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or upload error.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>