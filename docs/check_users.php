<?php
require_once('connectvars.php');

echo "<h2>Users in Database:</h2>";

try {
    $dbc = new SQLite3(DB_PATH);
    
    $query = "SELECT user_id, username, first_name, last_name FROM mismatch_user ORDER BY user_id";
    $data = $dbc->query($query);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 20px;'>";
    echo "<tr><th>User ID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Profile Link</th></tr>";
    
    while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td><a href='viewprofile.php?user_id=" . $row['user_id'] . "'>View Profile</a></td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    $dbc->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 