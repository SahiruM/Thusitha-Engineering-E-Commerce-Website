<?php

function saveUploadedImage($fieldName, $targetDir, $required = true) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]["error"] === UPLOAD_ERR_NO_FILE) {
        if ($required) {
            throw new RuntimeException("Please select an image.");
        }

        return null;
    }

    if ($_FILES[$fieldName]["error"] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Image upload failed.");
    }

    if ($_FILES[$fieldName]["size"] > 2 * 1024 * 1024) {
        throw new RuntimeException("Image must be smaller than 2MB.");
    }

    $tmpPath = $_FILES[$fieldName]["tmp_name"];
    $mimeType = mime_content_type($tmpPath);
    $allowedTypes = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
    ];

    if (!isset($allowedTypes[$mimeType])) {
        throw new RuntimeException("Only JPG, PNG, and WebP images are allowed.");
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = bin2hex(random_bytes(16)) . "." . $allowedTypes[$mimeType];
    $destinationPath = rtrim($targetDir, "/\\") . "/" . $fileName;

    if (!move_uploaded_file($tmpPath, $destinationPath)) {
        throw new RuntimeException("Could not save uploaded image.");
    }

    return $destinationPath;
}

