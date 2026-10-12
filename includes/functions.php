<?php
session_start();
define('DATA_DIR', __DIR__ . '/../data/');

function loadData($file) {
    $path = DATA_DIR . $file;
    if (!file_exists($path)) {
        file_put_contents($path, json_encode([]));
    }
    $raw = file_get_contents($path);
    $arr = json_decode($raw ?: '[]', true);
    return is_array($arr) ? $arr : [];
}

function saveData($file, array $data) {
    file_put_contents(DATA_DIR . $file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isLoggedIn() && (($_SESSION['user']['role'] ?? '') === 'admin');
}

function redirectTo($url) {
    header("Location: $url");
    exit();
}

function getNextId(array $items) {
    if (!$items) return 1;
    return (int) max(array_column($items, 'id')) + 1;
}

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function renderStars($rating) {
    $rating = max(0, min(5, (float)$rating));
    $full = (int) floor($rating);
    $half = (($rating - $full) >= 0.5) ? 1 : 0;
    $empty = 5 - $full - $half;
    $out = '<span class="stars">';
    for ($i = 0; $i < $full; $i++)  $out .= '<span class="star star-full">&#9733;</span>';
    if ($half) $out .= '<span class="star star-half">&#9733;</span>';
    for ($i = 0; $i < $empty; $i++) $out .= '<span class="star star-empty">&#9733;</span>';
    $out .= '<span class="rating-num">' . number_format($rating, 1) . '</span></span>';
    return $out;
}

function avatar($name, $size = 36) {
    $name = trim((string)$name);
    if ($name === '') $name = '?';
    $parts = preg_split('/\s+/', $name);
    $initials = '';
    if (!empty($parts[0][0])) $initials .= mb_strtoupper($parts[0][0]);
    if (!empty($parts[1][0])) $initials .= mb_strtoupper($parts[1][0]);
    $size = (int)$size;
    return '<span class="avatar" style="width:' . $size . 'px;height:' . $size . 'px;font-size:' .
        (int)($size * 0.42) . 'px;line-height:' . $size . 'px;">' . e($initials) . '</span>';
}

function statusBadge($status) {
    $status = strtolower((string)$status);
    return '<span class="badge badge-' . e($status) . '">' . e(ucfirst($status)) . '</span>';
}

function stockBadge($stock) {
    $stock = (int)$stock;
    if ($stock <= 0) return '<span class="badge badge-outstock">Out of stock</span>';
    if ($stock < 10) return '<span class="badge badge-lowstock">Only ' . $stock . ' left</span>';
    return '<span class="badge badge-instock">In stock</span>';
}
