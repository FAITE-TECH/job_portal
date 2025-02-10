<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Job Upload Form</title>
    
    <style>
       body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], select, textarea, input[type="file"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="date"] {
            background-color: #f9f9f9;
            color: #333;
            font-family: Arial, sans-serif;
        }

        input[type="date"]:focus {
            outline: none;
            border: 1px solid #007BFF;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

       /* New CSS to move the "Job Lists" button to the left */
.center-button-container {
    display: flex;
    margin-top: 20px;
    margin-left: 325px; /* Corrected the margin syntax */
}


    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Job Details Form</h2>
        <form action="process_job_upload.php" method="POST" enctype="multipart/form-data" onsubmit="return handleFormSubmit(event);">
            <label for="work_type">Work Type:</label>
            <select name="work_type" id="work_type" required>
                <option value="">Select Type</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
            </select>

            <label for="field">Field:</label>
            <select name="field" id="field" required>
                <option value="Information Technology">Information Technology</option>
                <option value="Finance">Finance and Insurance</option>
                <option value="Managment">Management</option>
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

            <label for="skill">Skill:</label>
            <textarea id="skill" name="skill" placeholder="Enter required skill" required rows="3" cols="50"></textarea>

            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" placeholder="Enter company name" required>

            <label for="job_type">Job Type:</label>
            <input type="text" id="job_type" name="job_type" placeholder="" required>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" placeholder="Enter job position" required>

            <label for="closing_date">Closing Date:</label>
            <input type="date" id="closing_date" name="closing_date" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter a detailed description" required rows="3" cols="50"></textarea>

            <label for="company_logo">Upload Company Logo:</label>
            <input type="file" id="company_logo" name="company_logo" accept="image/*">

            <label for="job_advertisement">Upload Job Advertisement:</label>
            <input type="file" id="job_advertisement" name="job_advertisement" accept="image/*">

            <button type="submit">Submit Job</button>
            

        </form>
         <!-- Centered "Job Lists" Button with Arrow Mark -->
<div class="center-button-container">
   <button onclick="window.location.href='edit_delete_job.php';">
      Job Lists  &#8594; <!-- Arrow mark -->
   </button>
</div>


    </div>

    <script>
        function handleFormSubmit(event) {
            event.preventDefault();

            // Display SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to submit this job post?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Submitted!',
                        'Your job post has been submitted successfully.',
                        'success'
                    );

                    // Submit form after user confirmation
                    event.target.submit();
                }
            });
        }
    </script>
</body>
</html>
