<?php
// Connect to the database
include 'db/connect.php';

// Define the number of results per page
$results_per_page = 10;

// Find out the number of results stored in the database
$sql = "SELECT COUNT(*) AS total FROM package_pds";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_results = $row['total'];

// Determine the total number of pages available
$total_pages = ceil($total_results / $results_per_page);

// Determine which page number visitor is currently on
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// Determine the SQL LIMIT starting number for the results on the displaying page
$starting_limit_number = ($page - 1) * $results_per_page;

// Retrieve selected results from the database and display them on the page
$sql = "SELECT * FROM package_pds LIMIT " . $starting_limit_number . ',' . $results_per_page;
$result = $conn->query($sql);
?>

<!-- Display data in a table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mbps</th>
            <th>Price</th>
            <th>Type</th>
            <th>Period</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['mbps']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['period']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Pagination controls -->
<div>
    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
        <a href="package.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
    <?php endfor; ?>
</div>

<?php
$conn->close();
?>
