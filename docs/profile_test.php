<!DOCTYPE html>
<html>
<head>
    <title>Profile Test - Mismatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
        .test-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: 30px auto;
        }
        
        .test-link {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .test-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div style="text-align: center; padding: 40px 20px; color: white;">
        <h1 style="font-size: 3em; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">🧪 Profile Test</h1>
        <p style="font-size: 1.2em; opacity: 0.9;">Click any link below to test profile viewing with a valid user ID</p>
    </div>

    <div class="test-links">
        <a href="viewprofile.php?user_id=1" class="test-link">👤 View Sidney's Profile (ID: 1)</a>
        <a href="viewprofile.php?user_id=2" class="test-link">👤 View Nevil's Profile (ID: 2)</a>
        <a href="viewprofile.php?user_id=3" class="test-link">👤 View Alex's Profile (ID: 3)</a>
        <a href="viewprofile.php?user_id=4" class="test-link">👤 View Susannah's Profile (ID: 4)</a>
        <a href="viewprofile.php?user_id=5" class="test-link">👤 View Ethel's Profile (ID: 5)</a>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="test_profiles.php" style="background: rgba(255,255,255,0.2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; border: 2px solid white; transition: all 0.3s ease; display: inline-block;">📋 View All Profiles</a>
        <a href="index.php" style="background: rgba(255,255,255,0.2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; border: 2px solid white; transition: all 0.3s ease; display: inline-block; margin-left: 10px;">🏠 Back to Home</a>
    </div>

    <div class="footer">
        <p>Copyright &copy; 2024 Mismatch Enterprises, Inc. | Profile Testing</p>
    </div>
</body>
</html> 