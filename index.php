<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs.LK</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function resetFormAndPage() {
            document.querySelector("form").reset(); // Reset the form fields
            window.location.href = window.location.pathname; // Reload the page without parameters
        }
    </script>
  
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">Jobs.LK</div>
        </div>
    </header>

    <main>
        <form method="POST" action="">
            <aside class="filters">
                <h2>Filters</h2>
                <div class="filter-group">
                    <h3>Type</h3>
                    <select name="work_type">
                        <option value="">Select Type</option>
                        <option value="Full-Time">Full-Time</option>
                        <option value="Part-Time">Part-Time</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>
                <div class="filter-group">
                    <h3>Field</h3>
                    <select name="Field">
                    <option value="">Select Type</option>
            <option value="it">Information Technology</option>
            <option value="Finance">Finance and Insurance</option>
            <option value="Managment">Managment</option>
            <option value="Hospitality">Hospitality and Catering</option>
            <option value="Education">Education</option>
            <option value="Construction">Construction and Building</option>
            <option value="Engineering">Engineering</option>
            <option value="Health care">Health Care</option>
            <option value="Media">Media</option>
            <option value="Sales">Sales and Marketing</option>
            <option value="Managment">Research/Science and Technology</option>
            <option value="human resource">Human Resource</option>
        </select>
                </div>
                <div class="filter-group">
                    <h3>Job Type</h3>
                    <input type="text" name="job_type" placeholder="Job Type">
                </div>
               
                <div class="buttons">
                    <button type="button" onclick="resetFormAndPage()" class="reset">Reset All</button>
                    <button type="submit" class="search">Search</button>
                </div>
            </aside>
        </form>

        <?php
        include 'connect.php'; // Ensure this connects to your database

        // Default query
        $query = "SELECT * FROM job_details WHERE 1";

        // Add filters if set
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['work_type'])) {
                $work_type = mysqli_real_escape_string($conn, $_POST['work_type']);
                $query .= " AND work_type = '$work_type'";
            }
            if (!empty($_POST['field'])) {
                $field = mysqli_real_escape_string($conn, $_POST['field']);
                $query .= " AND field LIKE '%$field%'";
            }
            if (!empty($_POST['job_type'])) {
                $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
                $query .= " AND job_type LIKE '%$job_type%'";
            }
           
        }

        // Execute query
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<section class="job-listings">';
            while ($row = mysqli_fetch_assoc($result)) {
                $image_path = !empty($row['image_path']) ? $row['image_path'] : 'uploads/default-image.png'; // Path to default image
                echo '<div class="job-card">';
                echo '<img src="' . htmlspecialchars($image_path) . '" alt="Company Logo">';
                echo '<div class="job-details">';
                echo '<h3>' . htmlspecialchars($row['job_type']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['company_name']) . '</p>';
                echo '<p>Closing Date: ' . htmlspecialchars($row['closing_date']) . '</p>';
                echo '</div>';
                echo '<button class="view-button" onclick="window.open(\'job_details.php?id=' . $row['id'] . '\', \'_blank\')">View</button>';

                echo '</div>';
            }
            echo '</section>';
        } else {
            echo "<p>No results found for the selected filters.</p>";
        }
        ?>
    </main>
    
</body>
</html>
