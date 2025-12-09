<?php
session_start();
session_unset();
session_destroy();
header('Location: /perpus/pages/auth.php');
exit;
?>