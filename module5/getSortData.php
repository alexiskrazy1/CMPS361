<?php
// API URL
$apiURL = "[API]"; // implement own API

// Fetch the data
$response = @file_get_contents($apiURL);

// Decode JSON
$data = json_decode($response, true);

// Validate if data exists
if ($data && is_array($data)){
    // Pagination
    $limit = 10;
    $totalRecords = count($data);
    $totalPages = ceil($totalRecords / $limit);

    // Capture the current page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Capture the starting index of the current page
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    // Sorting logic
    $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'restaurantid'; // Default sort by 'id'
    $sortOrder = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc'; // Default order is 'asc'

    // Sort the data based on the column and order
    usort($data, function($a, $b) use ($sortColumn, $sortOrder) {
        if ($sortOrder == 'asc') {
            return strcmp($a[$sortColumn], $b[$sortColumn]);
        } else {
            return strcmp($b[$sortColumn], $a[$sortColumn]);
        }
    });

    // Calculate the starting index of the current page
    $startIndex = ($currentPage - 1) * $limit;

    // Get the subset of data for the current page
    $pageData = array_slice($data, $startIndex, $limit);

    // Function to toggle sort order
    function toggleOrder($currentOrder) {
        return $currentOrder == 'asc' ? 'desc' : 'asc';
    }

    // Display data in a GridView (HTML Table)
    echo "<table border='1' cellpadding='10'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th><a href='?page=$currentPage&sort=id&order=" . toggleOrder($sortOrder) . "'>id</a></th>";
    echo "<th><a href='?page=$currentPage&sort=restaurant_name&order=" . toggleOrder($sortOrder) . "'>restaurant_name</a></th>";
    echo "<th><a href='?page=$currentPage&sort=rating&order=" . toggleOrder($sortOrder) . "'>rating</a></th>";
    echo "<th><a href='?page=$currentPage&sort=location&order=" . toggleOrder($sortOrder) . "'>location</a></th>";
    echo "<th><a href='?page=$currentPage&sort=type&order=" . toggleOrder($sortOrder) . "'>type</a></th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop through the data and display each post
    foreach ($pageData as $post) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['id']) . "</td>";
        echo "<td>" . htmlspecialchars($post['restaurant_name']) . "</td>";
        echo "<td>" . htmlspecialchars($post['rating']) . "</td>";
        echo "<td>" . htmlspecialchars($post['location']) . "</td>";
        echo "<td>" . htmlspecialchars($post['type']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // Pagination links
    echo "<div style='margin-top: 20px;'>";

    // Display previous link if not on first page
    if ($currentPage > 1) {
        echo '<a href="?page=' . ($currentPage - 1) . '&sort=' . $sortColumn . '&order=' . $sortOrder . '">Previous</a> ';
    }

    // Display page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo "<strong>$i</strong> ";
        } else {
            echo '<a href="?page=' . $i . '&sort=' . $sortColumn . '&order=' . $sortOrder . '">' . $i . '</a> ';
        }
    }

    // Next page
    if ($currentPage < $totalPages) {
        echo '<a href="?page=' . ($currentPage + 1) . '&sort=' . $sortColumn . '&order=' . $sortOrder . '">Next</a>';
    }

    echo "</div>";

    // Display total number of records at the bottom
    echo "<div style='margin-top: 20px; '>";
    echo "<strong>Total Records : $totalRecords </strong>";
    echo "</div>";

} else {
    // No data available
    echo "No data available.";
}
?>