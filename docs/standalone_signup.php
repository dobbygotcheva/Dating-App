<?php
// Standalone signup page - no dependencies
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mismatch - Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
        /* Additional styles for standalone page */
        .hero-section {
            text-align: center;
            padding: 40px 20px;
            color: white;
        }
        
        .hero-section h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-section p {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        
        .feature {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: white;
            min-width: 200px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .feature h3 {
            color: white;
            margin-bottom: 10px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-link a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 25px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .back-link a:hover {
            background: white;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <h1>💕 Mismatch</h1>
        <p>Where opposites attract! Join our community and find your perfect mismatch.</p>
    </div>
    
    <div class="features">
        <div class="feature">
            <h3>🎯 Smart Matching</h3>
            <p>Find people with opposite preferences</p>
        </div>
        <div class="feature">
            <h3>🔒 Secure</h3>
            <p>Your privacy is our priority</p>
        </div>
        <div class="feature">
            <h3>💬 Connect</h3>
            <p>Build meaningful relationships</p>
        </div>
    </div>
    
    <?php
    // Simple signup logic
    if (isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);
        
        if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
            echo '<div class="login">';
            echo '<h3>🎉 Welcome to Mismatch!</h3>';
            echo '<p>Your account has been created successfully!</p>';
            echo '<p>Username: <strong>' . htmlspecialchars($username) . '</strong></p>';
            echo '<p>You can now <a href="login.php" style="color: white; text-decoration: underline;">log in</a> to start your journey.</p>';
            echo '</div>';
        } else {
            echo '<div class="error">';
            echo '<h3>⚠️ Please check your information</h3>';
            echo '<p>Please fill in all fields and make sure your passwords match.</p>';
            echo '</div>';
        }
    }
    ?>
    
    <form method="post" action="">
        <fieldset>
            <legend>🌟 Create Your Account</legend>
            <label for="username">👤 Username:</label>
            <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo htmlspecialchars($username); ?>" required placeholder="Choose a unique username" />
            
            <label for="password1">🔐 Password:</label>
            <input type="password" id="password1" name="password1" required placeholder="Create a strong password" />
            
            <label for="password2">🔐 Confirm Password:</label>
            <input type="password" id="password2" name="password2" required placeholder="Retype your password" />
        </fieldset>
        <input type="submit" value="🚀 Join Mismatch" name="submit" />
    </form>
    
    <div class="back-link">
        <a href="index.php">← Back to Home</a>
    </div>
    
    <div class="footer">
        <p>Copyright &copy; 2024 Mismatch Enterprises, Inc. | Where opposites attract! 💕</p>
    </div>
</body>
</html> 