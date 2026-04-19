<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Secure user dashboard listing personalized profile details and past order history.
 */
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
$welcomeType = $_SESSION["welcome_type"] ?? "old";

if (!empty($_SESSION["is_admin"])) {
    header("Location: ../admin/dashboard.php");
    exit;
}

if ($welcomeType === "new") {
    $welcomeMessage = "Welcome to our website!";
    $redirectPage = "login.php";
} else {
    $welcomeMessage = "Welcome back!";
    $redirectPage = "../menu.php";
}

unset($_SESSION["welcome_type"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <meta http-equiv="refresh" content="3;url=<?php echo $redirectPage; ?>">
</head>

<body>
    <main class="main">
        <div class="form-box">
            <h2><?php echo htmlspecialchars($welcomeMessage); ?></h2>
            <p class="switch-text" style="margin-top: 0;">Hello, <?php echo htmlspecialchars($username); ?>.</p>

            <?php if ($welcomeType === "new"): ?>
                <p class="switch-text">Registration successful. Redirecting to login page...</p>
            <?php else: ?>
                <p class="switch-text">Login successful. Redirecting to menu...</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>