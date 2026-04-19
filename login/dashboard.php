<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!empty($_SESSION["is_admin"])) {
    header("Location: ../admin/dashboard.php");
    exit;
}

$username = $_SESSION["username"];
$welcomeType = $_SESSION["welcome_type"] ?? "old";

if ($welcomeType === "new") {
    $welcomeMessage = "Welcome to our website!";
} else {
    $welcomeMessage = "Welcome back!";
}

unset($_SESSION["welcome_type"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main class="main">
        <div class="form-box">
            <h2><?php echo htmlspecialchars($welcomeMessage); ?></h2>
            <p class="switch-text" style="margin-top: 0;">Hello, <?php echo htmlspecialchars($username); ?>.</p>
            <p class="switch-text">You have successfully logged in.</p>
            <a href="logout.php" class="btn"
                style="display:inline-block; text-align:center; text-decoration:none; margin-top:20px;">Logout</a>
        </div>
    </main>
</body>

</html>