<?php
ob_start(); // Output buffering
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $workType = $_POST['work_type'];
    $field = $_POST['field'];
    $skill = $_POST['skill'];
    $companyName = $_POST['company_name'];
    $jobType = $_POST['job_type'];
    $position = $_POST['position'];
    $closingDate = $_POST['closing_date'];
    $description = $_POST['description'];

    $companyLogo = $_FILES['company_logo'];
    $jobAd = $_FILES['job_advertisement'];

    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $logoPath = '';
    $adPath = '';

    if (!empty($companyLogo['name'])) {
        $logoPath = $uploadDir . basename($companyLogo['name']);
        move_uploaded_file($companyLogo['tmp_name'], $logoPath);
    }

    if (!empty($jobAd['name'])) {
        $adPath = $uploadDir . basename($jobAd['name']);
        move_uploaded_file($jobAd['tmp_name'], $adPath);
    }

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'job_portal';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO job_details (work_type, field, skill, company_name, job_type, position, closing_date, description, image_path, job_advertisement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $workType, $field, $skill, $companyName, $jobType, $position, $closingDate, $description, $logoPath, $adPath);

    if ($stmt->execute()) {
        // Redirect to job_details.php after successful form submission
        header("Location: job_form.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
