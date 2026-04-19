<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Safely nullifies and destroys the active user's session terminating access.
 */
session_start();
session_destroy();
header("Location: login.php");
exit;