<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Authentication endpoint rendering the dual login and registration form portal.
 */
session_start();

require "../includes/connect.php";

$message = "";
$messageClass = "message";
$activeForm = "login";

/**
 * Sanitizes and enforces deep email string validation securely resolving raw payloads
 */
function isValidEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Safely filters out special characters universally preventing direct SQL injection syntax disruptions
 */
function isValidUsername($username)
{
  return preg_match('/^[A-Za-z0-9_]{3,30}$/', $username);
}

/**
 * Mandates system cryptographic strength requiring complex Symbols, Numbers, and mixed Cases explicitly
 */
function isValidPassword($password)
{
  return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{6,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = $_POST["action"] ?? "";

  // ---- USER AUTHENTICATION / LOGIN ALGORITHM ---- //
  // Queries DB against stored BCRYPT hashes validating state completely
  if ($action === "login") {
    $activeForm = "login";

    $username = trim($_POST["loginUsername"] ?? "");
    $password = $_POST["loginPassword"] ?? "";

    if ($username === "" || $password === "") {
      $message = "Please enter both username and password.";
      $messageClass = "error-message";
    } else {
      $stmt = $pdo->prepare("SELECT * FROM login_details WHERE username = ?");
      $stmt->execute([$username]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
        $message = "This user does not exist. Please register first.";
        $messageClass = "error-message";
      } elseif (!password_verify($password, $user["password"])) {
        $message = "Incorrect password.";
        $messageClass = "error-message";
      } else {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["welcome_type"] = "old";
        $_SESSION["is_admin"] = !empty((int) ($user["is_admin"] ?? 0));

        if (!empty($_SESSION["is_admin"])) {
          header("Location: ../admin/admin.php");
        } else {
          header("Location: dashboard.php");
        }
        exit;
      }
    }
  }

  // ---- NEW USER REGISTRATION ALGORITHM ---- //
  // Enforces rigorous unique constraints recursively before salting payloads securely
  if ($action === "register") {
    $activeForm = "register";

    $email = trim($_POST["registerEmail"] ?? "");
    $username = trim($_POST["registerUsername"] ?? "");
    $password = $_POST["registerPassword"] ?? "";
    $confirmPassword = $_POST["registerConfirmPassword"] ?? "";

    if (!isValidEmail($email)) {
      $message = "Please enter a valid email such as a@b.com.";
      $messageClass = "error-message";
    } elseif (!isValidUsername($username)) {
      $message = "Username must be 3 to 30 characters and use only letters, numbers, or underscores.";
      $messageClass = "error-message";
    } elseif (!isValidPassword($password)) {
      $message = "Password must be at least 6 characters and include uppercase, lowercase, number, and symbol.";
      $messageClass = "error-message";
    } elseif ($password !== $confirmPassword) {
      $message = "Passwords do not match.";
      $messageClass = "error-message";
    } else {
      $check = $pdo->prepare("SELECT * FROM login_details WHERE username = ? OR email = ?");
      $check->execute([$username, $email]);
      $existing = $check->fetch(PDO::FETCH_ASSOC);

      if ($existing) {
        if ($existing["username"] === $username) {
          $message = "This username is already taken.";
        } else {
          $message = "This email is already registered.";
        }
        $messageClass = "error-message";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO login_details (email, username, password, is_admin) VALUES (?, ?, ?, 0)");
        $insert->execute([$email, $username, $hashedPassword]);

        $_SESSION["user_id"] = $pdo->lastInsertId();
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["welcome_type"] = "new";
        $_SESSION["is_admin"] = false;
        header("Location: dashboard.php");
        exit;
      }
    }
  }

  if ($action === "reset") {
    $activeForm = "reset";

    $email = trim($_POST["resetEmail"] ?? "");
    $newUsername = trim($_POST["newUsername"] ?? "");
    $newPassword = $_POST["newPassword"] ?? "";
    $confirmNewPassword = $_POST["confirmNewPassword"] ?? "";

    if (!isValidEmail($email)) {
      $message = "Please enter a valid email such as a@b.com.";
      $messageClass = "error-message";
    } elseif (!isValidUsername($newUsername)) {
      $message = "New username must be 3 to 30 characters and use only letters, numbers, or underscores.";
      $messageClass = "error-message";
    } elseif (!isValidPassword($newPassword)) {
      $message = "New password must be at least 6 characters and include uppercase, lowercase, number, and symbol.";
      $messageClass = "error-message";
    } elseif ($newPassword !== $confirmNewPassword) {
      $message = "New passwords do not match.";
      $messageClass = "error-message";
    } else {
      $findUser = $pdo->prepare("SELECT * FROM login_details WHERE email = ?");
      $findUser->execute([$email]);
      $user = $findUser->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
        $message = "No account was found with this email.";
        $messageClass = "error-message";
      } else {
        $checkUsername = $pdo->prepare("SELECT * FROM login_details WHERE username = ? AND email <> ?");
        $checkUsername->execute([$newUsername, $email]);
        $usernameExists = $checkUsername->fetch(PDO::FETCH_ASSOC);

        if ($usernameExists) {
          $message = "This username is already taken by another user.";
          $messageClass = "error-message";
        } else {
          $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
          $update = $pdo->prepare("UPDATE login_details SET username = ?, password = ? WHERE email = ?");
          $update->execute([$newUsername, $hashedPassword, $email]);

          $message = "Your username and password have been reset successfully. Please log in.";
          $messageClass = "message";
          $activeForm = "login";
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

  <?php include '../includes/header.php'; ?>

  <main class="main">
    <div class="form-box">

      <form id="loginForm" method="post" <?= $activeForm === "login" ? "" : 'class="hidden"' ?>>
        <h2>Login</h2>

        <input type="hidden" name="action" value="login">

        <div class="input-group">
          <label for="loginUsername">Username</label>
          <input type="text" id="loginUsername" name="loginUsername" placeholder="Enter username" required />
        </div>

        <div class="input-group">
          <label for="loginPassword">Password</label>
          <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter password" required />
        </div>

        <button type="submit" class="btn">Login</button>

        <p class="switch-text">
          No account?
          <a href="#" id="showRegister">Register</a>
          <br>
          Forgot your account?
          <a href="#" id="showReset">Reset username / password</a>
        </p>
      </form>

      <form id="registerForm" method="post" <?= $activeForm === "register" ? "" : 'class="hidden"' ?>>
        <h2>Register</h2>

        <input type="hidden" name="action" value="register">

        <div class="input-group">
          <label for="registerEmail">Email</label>
          <input type="email" id="registerEmail" name="registerEmail" placeholder="Enter email" required />
        </div>

        <div class="input-group">
          <label for="registerUsername">Username</label>
          <input type="text" id="registerUsername" name="registerUsername" placeholder="Create username" required />
        </div>

        <div class="input-group">
          <label for="registerPassword">Password</label>
          <input type="password" id="registerPassword" name="registerPassword" placeholder="Create password" required />
        </div>

        <div class="input-group">
          <label for="registerConfirmPassword">Confirm Password</label>
          <input type="password" id="registerConfirmPassword" name="registerConfirmPassword"
            placeholder="Confirm password" required />
        </div>

        <button type="submit" class="btn">Register</button>

        <p class="switch-text">
          Already have an account?
          <a href="#" id="showLoginFromRegister">Login</a>
          <br>

        </p>
      </form>

      <form id="resetForm" method="post" <?= $activeForm === "reset" ? "" : 'class="hidden"' ?>>
        <h2>Reset Account</h2>

        <input type="hidden" name="action" value="reset">

        <div class="input-group">
          <label for="resetEmail">Registered Email</label>
          <input type="email" id="resetEmail" name="resetEmail" placeholder="Enter your email" required />
        </div>

        <div class="input-group">
          <label for="newUsername">New Username</label>
          <input type="text" id="newUsername" name="newUsername" placeholder="Enter new username" required />
        </div>

        <div class="input-group">
          <label for="newPassword">New Password</label>
          <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password" required />
        </div>

        <div class="input-group">
          <label for="confirmNewPassword">Confirm New Password</label>
          <input type="password" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm new password"
            required />
        </div>

        <button type="submit" class="btn">Reset Account</button>

        <p class="switch-text">
          Back to
          <a href="#" id="showLoginFromReset">Login</a>
          <br>
          Use your registered email to reset both username and password.
        </p>
      </form>

      <?php if ($message !== ""): ?>
        <p class="<?= htmlspecialchars($messageClass) ?>" id="message"><?= htmlspecialchars($message) ?></p>
      <?php else: ?>
        <p class="message" id="message"></p>
      <?php endif; ?>

    </div>
  </main>

  <script src="../js/auth.js"></script>


</body>

</html>