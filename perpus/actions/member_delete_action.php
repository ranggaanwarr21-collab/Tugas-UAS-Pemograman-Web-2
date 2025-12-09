<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id'])) {
    redirect('/perpus/pages/member.php');
}

$id = intval($_GET['id']);

$conn->query("DELETE FROM members WHERE id = $id");

alert_and_redirect("Member berhasil dihapus!", "/perpus/pages/member.php");
