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

// Handle deletion
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $conn->query("DELETE FROM job_details WHERE id = $deleteId");
    header("Location: job_list.php");
    exit();
}

// Fetch all jobs
$result = $conn->query("SELECT * FROM job_details");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
    table {
    width: 80%;
    border-collapse: collapse;
    margin: 0 auto; /* This centers the table */

   
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        h1{
            text-align: center;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            background:rgb(51, 143, 242);
            color: #fff;
            border-radius: 5px;
        }
        .actions a.delete {
            background:rgb(243, 78, 95);
        }
    </style>
</head>
<body>
    <h1 >Job Listings</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Field</th>
                <th>Position</th>
                <th>Job Type</th>
                <th>Closing date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['field']); ?></td>
                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                    <td><?php echo htmlspecialchars($row['job_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['closing_date']); ?></td>
                    <td class="actions">
                        <a href="edit_job.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
