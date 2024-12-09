<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/userprofile_style.css">
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <img src="images/profile.jpg" alt="Profile Picture" class="profile-pic">
        <h2 class="username">John Doe</h2>
        <p class="email">johndoe@example.com</p>
    </div>

    <div class="profile-bio">
        <h3>About Me</h3>
        <p>Hello! I'm John, a web developer based in the Philippines. I love creating beautiful and functional websites.</p>
    </div>

    <div class="profile-details">
        <h3>Details</h3>
        <ul>
            <li><strong>Location:</strong> Manila, Philippines</li>
            <li><strong>Phone:</strong> +639XXXXXXXXX</li>
            <li><strong>Joined:</strong> January 2022</li>
        </ul>
    </div>

    <div class="profile-settings">
        <h3>Settings</h3>

        <div class="setting-item">
            <label for="address">Address:</label>
            <input type="text" id="address" placeholder="Enter your address" required>
        </div>

        <div class="setting-item">
            <label for="password">Change Password:</label>
            <input type="password" id="password" placeholder="Enter new password" required>
        </div>

        <div class="setting-item">
            <label for="payment-method">Add Payment Method:</label>
            <select id="payment-method">
                <option value="gcash">GCash</option>
                <option value="credit-card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>

        <button class="btn">Save Changes</button>
    </div>
</div>

</body>
</html>