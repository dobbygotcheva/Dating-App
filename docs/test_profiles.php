<!DOCTYPE html>
<html>
<head>
    <title>Test User Profiles - Mismatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            transition: transform 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
        }
        
        .profile-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #667eea;
            margin-bottom: 15px;
        }
        
        .profile-card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .profile-card p {
            color: #666;
            margin-bottom: 15px;
        }
        
        .profile-link {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .profile-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div style="text-align: center; padding: 40px 20px; color: white;">
        <h1 style="font-size: 3em; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">👥 Test User Profiles</h1>
        <p style="font-size: 1.2em; opacity: 0.9;">Click on any profile to test the view profile functionality</p>
    </div>

    <?php
    require_once('connectvars.php');
    
    try {
        $dbc = new SQLite3(DB_PATH);
        
        $query = "SELECT user_id, username, first_name, last_name, picture FROM mismatch_user WHERE first_name IS NOT NULL ORDER BY user_id LIMIT 10";
        $data = $dbc->query($query);
        
        echo '<div class="profile-grid">';
        
        while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
            echo '<div class="profile-card">';
            
            // Profile picture
            if (!empty($row['picture']) && is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
                echo '<img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '" />';
            } else {
                echo '<img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="Default Profile" />';
            }
            
            echo '<h3>' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . '</h3>';
            echo '<p>@' . htmlspecialchars($row['username']) . '</p>';
            echo '<a href="viewprofile.php?user_id=' . $row['user_id'] . '" class="profile-link">👤 View Profile</a>';
            
            echo '</div>';
        }
        
        echo '</div>';
        
        $dbc->close();
        
    } catch (Exception $e) {
        echo '<div class="error">';
        echo '<h3>⚠️ Database Error</h3>';
        echo '<p>Error: ' . $e->getMessage() . '</p>';
        echo '</div>';
    }
    ?>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="index.php" style="background: rgba(255,255,255,0.2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; border: 2px solid white; transition: all 0.3s ease; display: inline-block;">← Back to Home</a>
    </div>
    
    <div class="footer">
        <p>Copyright &copy; 2024 Mismatch Enterprises, Inc. | Test Profile Navigation</p>
    </div>
</body>
</html> 