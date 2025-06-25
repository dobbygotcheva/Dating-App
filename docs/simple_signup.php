<!DOCTYPE html>
<html>
<head>
    <title>Simple Signup Test</title>
</head>
<body>
    <h1>Simple Signup Test</h1>
    
    <p>Please enter your username and desired password to sign up to Mismatch.</p>
    
    <form method="post" action="">
        <fieldset>
            <legend>Registration Info</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required /><br />
            <label for="password1">Password:</label>
            <input type="password" id="password1" name="password1" required /><br />
            <label for="password2">Password (retype):</label>
            <input type="password" id="password2" name="password2" required /><br />
        </fieldset>
        <input type="submit" value="Sign Up" name="submit" />
    </form>
    
    <?php
    if (isset($_POST['submit'])) {
        echo "<p>Form submitted! Username: " . htmlspecialchars($_POST['username']) . "</p>";
    }
    ?>
</body>
</html> 