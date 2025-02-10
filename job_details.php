<style>
    
    /* General Styling */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 20px;
        box-sizing: border-box;
    }

    /* Poster Container */
    .poster-container {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 90%;
        margin: 40px 0;
    }

    .poster-container img {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
        border: 2px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
    }

    /* Job Details Container */
    .job-details {
        display: block;
        position: relative;
        max-width: 900px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        line-height: 1.6;
        color: #333;
        text-align: left;
    }

    .company-logo {
        max-width: 100px;
        margin-bottom: 15px;
        border-radius: 8px;
        display: block;
    }

    .job-details h1 {
        color: #2b6777;
        font-size: 28px;
        margin-bottom: 15px;
    }

    .job-details p {
        margin: 10px 0;
    }

    .job-details p strong {
        color: #2b6777;
        font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            flex-direction: column;
            padding: 10px;
        }

        .poster-container {
            margin: 20px 0;
        }

        .job-details {
            padding: 15px;
        }
    }
</style>




<?php

// Fetch job data dynamically and check if it's a poster
include 'connect.php';
if (isset($_GET['id'])) {
    $job_id = (int) $_GET['id']; // Sanitize input
    $query = "SELECT * FROM job_details WHERE id = '$job_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $job = mysqli_fetch_assoc($result);

        // Display Poster if Available
        if (!empty($job['job_advertisement'])) {
            echo '<div class="poster-container">';
            echo '<img src="' . htmlspecialchars($job['job_advertisement']) . '" alt="Job Poster">';
            echo '</div>';
        } else {
            // Display Job Details only if poster is not available
            echo '<div class="job-details">';
            $image_path = !empty($job['image_path']) ? $job['image_path'] : 'uploads/default-image.png'; // Path to default image
            echo '<img src="' . htmlspecialchars($image_path) . '" alt="Company Logo" class="company-logo">';
            echo '<h1>' . htmlspecialchars($job['job_type']) . '</h1>';
            echo '<p><strong>Field:</strong> ' . htmlspecialchars($job['field']) . '</p>';
            echo '<p><strong>Work Type:</strong> ' . htmlspecialchars($job['work_type']) . '</p>';
            echo '<p><strong>Job Type:</strong> ' . htmlspecialchars($job['job_type']) . '</p>';
            echo '<p><strong>Position:</strong> ' . htmlspecialchars($job['position']) . '</p>';
            echo '<p><strong>Company Name:</strong> ' . htmlspecialchars($job['company_name']) . '</p>';
            echo '<p><strong>Closing Date:</strong> ' . htmlspecialchars($job['closing_date']) . '</p>';
            echo '<p><strong>Requirements:</strong> ' . htmlspecialchars($job['skill']) . '</p>';
            echo '<p><strong>description:</strong> ' . htmlspecialchars($job['description']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>Job details not available.</p>';
    }
}
?>



