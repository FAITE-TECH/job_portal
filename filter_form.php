<?php
include 'connect.php'; // Connect to the database

function getDropdownOptions($conn, $column) {
    $query = "SELECT DISTINCT $column FROM job_details";
    $result = mysqli_query($conn, $query);
    $options = "";

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $value = htmlspecialchars($row[$column]);
            $options .= "<option value='$value'>$value</option>";
        }
    }

    return $options;
}

// Fetch data for each dropdown
$fieldOptions = getDropdownOptions($conn, 'field');
$jobTypeOptions = getDropdownOptions($conn, 'job_type');
$countryOptions = getDropdownOptions($conn, 'country');

mysqli_close($conn);
?>

<script>
    document.getElementById('field').innerHTML += `<?php echo $fieldOptions; ?>`;
    document.getElementById('job_type').innerHTML += `<?php echo $jobTypeOptions; ?>`;
    document.getElementById('country').innerHTML += `<?php echo $countryOptions; ?>`;
</script>
