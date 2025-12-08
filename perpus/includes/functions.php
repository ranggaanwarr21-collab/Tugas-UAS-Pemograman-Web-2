<?php
// includes/functions.php - helper functions
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
function redirect($url) {
    header('Location: ' . $url);
    exit;
}
function alert_and_redirect($msg, $url) {
    echo '<script>alert(' . json_encode($msg) . '); window.location.href=' . json_encode($url) . ';</script>';
    exit;
}
?>