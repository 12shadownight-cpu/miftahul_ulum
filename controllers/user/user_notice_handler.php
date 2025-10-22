<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../pengumuman/PengumumanController.php';

$db = (new Database())->connect();
$controller = new PengumumanController($db);

$announcement = $controller->getAllWithPengurus();

include __DIR__ . '/../../views/user/notice.php';