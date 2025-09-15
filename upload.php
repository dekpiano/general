<?php
header('Content-Type: application/json');

// Basic security check - you might want something more robust
// For example, check a secret token passed in headers
// if (!isset($_SERVER['HTTP_X_AUTH_TOKEN']) || $_SERVER['HTTP_X_AUTH_TOKEN'] !== 'YOUR_SECRET_TOKEN') {
//     http_response_code(403);
//     echo json_encode(['status' => 'error', 'message' => 'Forbidden']);
//     exit;
// }

$response = [];

try {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // ***IMPORTANT***: Set your base upload directory here on your other server
        $uploadDir = '/var/www/html/uploads/'; 
        
        // Read the path sent from the client to create a subfolder
        $subDir = isset($_POST['path']) ? trim($_POST['path'], '/') : '';
        $targetDir = $uploadDir . $subDir;

        // Create directory if it doesn't exist
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                throw new Exception('Failed to create directory.');
            }
        }

        // Create a new unique filename to prevent overwrites
        $fileInfo = pathinfo($_FILES['file']['name']);
        $fileExtension = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
        $newFileName = uniqid('file_', true) . $fileExtension;
        $targetPath = $targetDir . '/' . $newFileName;

        // Move the uploaded file to the target location
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $response = [
                'status' => 'success',
                'message' => 'File uploaded successfully.',
                'filename' => $newFileName // Send the new filename back
            ];
            http_response_code(200);
        } else {
            throw new Exception('Failed to move uploaded file.');
        }
    } else {
        throw new Exception('No file uploaded or an error occurred.');
    }
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    http_response_code(500);
}

echo json_encode($response);
