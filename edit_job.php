<?php
// Database connection
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'job_portal';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch job details for editing
$jobId = intval($_GET['id']);
$jobData = $conn->query("SELECT * FROM job_details WHERE id = $jobId");

if ($jobData->num_rows === 0) {
    echo "Job not found.";
    exit();
}

$job = $jobData->fetch_assoc();

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $workType = $_POST['work_type'];
    $field = $_POST['field'];
    $skill = $_POST['skill'];
    $companyName = $_POST['company_name'];
    $jobType = $_POST['job_type'];
    $position = $_POST['position'];
    $closingDate = $_POST['closing_date'];
    $description = $_POST['description'];

    // Handle file uploads
    $jobAdvertisement = $_FILES['job_advertisement']['name'];
    $jobAdvertisementTmpName = $_FILES['job_advertisement']['tmp_name'];
    $jobAdvertisementFolder = 'uploads/' . $jobAdvertisement;
    move_uploaded_file($jobAdvertisementTmpName, $jobAdvertisementFolder);

    $imagePath = $_FILES['image_path']['name'];
    $imagePathTmpName = $_FILES['image_path']['tmp_name'];
    $imagePathFolder = 'uploads/' . $imagePath;
    move_uploaded_file($imagePathTmpName, $imagePathFolder);

    $stmt = $conn->prepare("UPDATE job_details SET work_type = ?, field = ?, skill = ?, company_name = ?, job_type = ?, position = ?, closing_date = ?, description = ?, job_advertisement = ?, image_path = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssi", $workType, $field, $skill, $companyName, $jobType, $position, $closingDate, $description, $jobAdvertisementFolder, $imagePathFolder, $jobId);

    if ($stmt->execute()) {
        header("Location: job_list.php");
        exit();
    } else {
        echo "Error updating job: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <style>
        form {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #f9f9f9;
            border: 2px solid #ddd;
        }
        h1{
            text-align:center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .image-preview {
            margin-top: 10px;
        }
        .image-preview img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Edit Job</h1>

    <form method="POST" enctype="multipart/form-data">
        <label for="work_type">Work Type:</label>
        <select name="work_type" id="work_type" required>
            <option value="">Select Type</option>
            <option value="Full-time" <?php echo ($job['work_type'] == 'Full-time') ? 'selected' : ''; ?>>Full-time</option>
            <option value="Part-time" <?php echo ($job['work_type'] == 'Part-time') ? 'selected' : ''; ?>>Part-time</option>
        </select>

        <label for="field">Field:</label>
        <select name="field" id="field" required>
            <option value="">Select Field</option>
            <option value="Information Technology" <?php echo ($job['field'] == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
            <option value="Finance" <?php echo ($job['field'] == 'Finance') ? 'selected' : ''; ?>>Finance and Insurance</option>
            <option value="Management" <?php echo ($job['field'] == 'Management') ? 'selected' : ''; ?>>Management</option>
            <option value="Hospitality" <?php echo ($job['field'] == 'Hospitality') ? 'selected' : ''; ?>>Hospitality and Catering</option>
            <option value="Education" <?php echo ($job['field'] == 'Education') ? 'selected' : ''; ?>>Education</option>
            <option value="Construction" <?php echo ($job['field'] == 'Construction') ? 'selected' : ''; ?>>Construction and Building</option>
            <option value="Engineering" <?php echo ($job['field'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
            <option value="Health Care" <?php echo ($job['field'] == 'Health Care') ? 'selected' : ''; ?>>Health Care</option>
            <option value="Media" <?php echo ($job['field'] == 'Media') ? 'selected' : ''; ?>>Media</option>
            <option value="Sales" <?php echo ($job['field'] == 'Sales') ? 'selected' : ''; ?>>Sales and Marketing</option>
            <option value="Research/Science and Technology" <?php echo ($job['field'] == 'Research/Science and Technology') ? 'selected' : ''; ?>>Research/Science and Technology</option>
            <option value="Human Resource" <?php echo ($job['field'] == 'Human Resource') ? 'selected' : ''; ?>>Human Resource</option>
        </select>

        <label for="skill">Skill</label>
        <input type="text" name="skill" id="skill" value="<?php echo htmlspecialchars($job['skill']); ?>" required>

        <label for="company_name">Company Name</label>
        <input type="text" name="company_name" id="company_name" value="<?php echo htmlspecialchars($job['company_name']); ?>" required>

        <label for="job_type">Job Type</label>
        <input type="text" name="job_type" id="job_type" value="<?php echo htmlspecialchars($job['job_type']); ?>" required>

        <label for="position">Position</label>
        <input type="text" name="position" id="position" value="<?php echo htmlspecialchars($job['position']); ?>" required>

        <label for="closing_date">Closing Date</label>
        <input type="date" name="closing_date" id="closing_date" value="<?php echo htmlspecialchars($job['closing_date']); ?>" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($job['description']); ?></textarea>

        <label for="job_advertisement">Job Advertisement</label>
        <input type="file" name="job_advertisement" id="job_advertisement" required>
        <div class="image-preview">
            <img src="<?php echo htmlspecialchars($job['job_advertisement']); ?>" alt="Job Advertisement">
        </div>

        <label for="image_path">Image Path</label>
        <input type="file" name="image_path" id="image_path" required>
        <div class="image-preview">
            <img src="<?php echo htmlspecialchars($job['image_path']); ?>" alt="Job Image">
        </div>

        <button type="submit">Update Job</button>
    </form>
</body>
</html>
