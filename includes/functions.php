<?php
/**
 * Shared helpers (sessions, JSON storage, auth, formatting).
 * NO JavaScript is used in this project. Everything is server-side PHP.
 */
session_start();
define('DATA_DIR', __DIR__ . '/../data/');

/**
 * Load a JSON file from data/ as an array.
 * @param string $file
 * @return array
 */
function loadData($file) {
    $path = DATA_DIR . $file;
    if (!file_exists($path)) {
        file_put_contents($path, json_encode([]));
    }
    $raw = file_get_contents($path);
    $arr = json_decode($raw ?: '[]', true);
    return is_array($arr) ? $arr : [];
}

/**
 * Save an array as pretty-printed JSON.
 * @param string $file
 * @param array  $data
 * @return void
 */
function saveData($file, array $data) {
    file_put_contents(DATA_DIR . $file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/** @return bool */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/** @return bool */
function isAdmin() {
    return isLoggedIn() && (($_SESSION['user']['role'] ?? '') === 'admin');
}

/**
 * Redirect and stop execution.
 * @param string $url
 * @return never
 */
function redirectTo($url) {
    header("Location: $url");
    exit();
}

/**
 * Next auto-increment ID for a collection.
 * @param array $items
 * @return int
 */
function getNextId(array $items) {
    if (!$items) return 1;
    return (int) max(array_column($items, 'id')) + 1;
}

/**
 * Escape output safely.
 * @param string $s
 * @return string
 */
function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

/**
 * Render star rating using plain unicode star characters (rendered via serif font,
 * NOT emoji). Produces filled / empty stars and a numeric rating.
 * @param float|int $rating 0-5
 * @return string HTML
 */
function renderStars($rating) {
    $rating = max(0, min(5, (float)$rating));
    $full  = (int) floor($rating);
    $half  = (($rating - $full) >= 0.5) ? 1 : 0;
    $empty = 5 - $full - $half;
    $html = '<span class="stars" aria-label="Rating ' . $rating . ' of 5">';
    for ($i = 0; $i < $full; $i++)  $html .= '<span class="star star-full">&#9733;</span>';
    if ($half) $html .= '<span class="star star-half">&#9733;</span>';
    for ($i = 0; $i < $empty; $i++) $html .= '<span class="star star-empty">&#9733;</span>';
    $html .= '<span class="rating-num">' . number_format($rating, 1) . '</span>';
    $html .= '</span>';
    return $html;
}

/**
 * Render an initial-based avatar (pure CSS circle, no image, no emoji).
 * @param string $name Full name.
 * @param int    $size Pixel size.
 * @return string HTML
 */
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

/**
 * Detect active top-level navigation item.
 * @param string $file Basename to match, or special tokens like 'admin'/'pages'.
 * @return string CSS class (with leading space) or empty string.
 */
function navActive($file) {
    $current = basename($_SERVER['PHP_SELF']);
    $uri = $_SERVER['PHP_SELF'];
    if ($file === 'admin' && strpos($uri, '/admin/') !== false) return ' active';
    if ($file === 'pages' && strpos($uri, '/pages/') !== false) return ' active';
    return ($current === $file) ? ' active' : '';
}

/**
 * Is any of the given $files the current page? (Helps with highlighting parents.)
 * @param array $files
 * @return string
 */
function navActiveAny(array $files) {
    $current = basename($_SERVER['PHP_SELF']);
    foreach ($files as $f) {
        if ($current === $f) return ' active';
    }
    return '';
}

/**
 * Render a status badge.
 * @param string $status
 * @return string HTML
 */
function statusBadge($status) {
    $status = strtolower((string)$status);
    return '<span class="badge badge-' . e($status) . '">' . e(ucfirst($status)) . '</span>';
}

/**
 * Stock badge.
 * @param int $stock
 * @return string HTML
 */
function stockBadge($stock) {
    $stock = (int)$stock;
    if ($stock <= 0) return '<span class="badge badge-outstock">Out of stock</span>';
    if ($stock < 10) return '<span class="badge badge-lowstock">Only ' . $stock . ' left</span>';
    return '<span class="badge badge-instock">In stock</span>';
}
