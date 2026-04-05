<?php
/**
 * Global helper functions for BulkTools
 */

/**
 * Initialize safe JSON response mode for process.php endpoints.
 * This suppresses PHP error/warning HTML output that would corrupt JSON responses.
 * Call this at the top of every process.php file.
 */
function json_safe_start() {
    // Suppress HTML error output - errors will be caught by the exception handler
    ini_set('display_errors', 0);
    // Buffer all output so stray echo/print or warnings don't corrupt JSON
    ob_start();
    // Set JSON content type early
    header('Content-Type: application/json');
    // Set a custom error handler that throws exceptions for warnings
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        // Don't throw for suppressed errors (@operator)
        if (!(error_reporting() & $errno)) return false;
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    });
}

/**
 * Sanitize user input
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a unique session hash for file uploads
 */
function get_session_hash() {
    if (!isset($_SESSION['user_hash'])) {
        $_SESSION['user_hash'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['user_hash'];
}

/**
 * Validate CSRF token
 */
function validate_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Format file size
 */
function format_bytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * Get current tool info from path
 */
function get_current_tool_info($path) {
    global $TOOL_CATEGORIES;
    $parts = explode('/', trim($path, '/'));
    if (count($parts) >= 2) {
        $category = $parts[count($parts) - 2];
        $toolId = $parts[count($parts) - 1];
        if (isset($TOOL_CATEGORIES[$category]['tools'][$toolId])) {
            return array_merge(
                $TOOL_CATEGORIES[$category]['tools'][$toolId],
                ['category_id' => $category, 'tool_id' => $toolId, 'category_name' => $TOOL_CATEGORIES[$category]['name']]
            );
        }
    }
    return null;
}

/**
 * JSON Response for AJAX
 */
function json_response($data, $success = true) {
    // Clean any buffered PHP warnings/output before sending JSON
    if (ob_get_level() > 0) ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => $success], $data));
    exit;
}

/**
 * Error JSON Response
 */
function json_error($message) {
    json_response(['message' => $message], false);
}

/**
 * Rate limiting check (Simulated with session)
 */
function rate_limit_check() {
    $limit = defined('RATE_LIMIT_COUNT') ? RATE_LIMIT_COUNT : 10;
    $time = time();
    $window = defined('RATE_LIMIT_WINDOW') ? RATE_LIMIT_WINDOW : 3600;

    if (!isset($_SESSION['upload_history'])) {
        $_SESSION['upload_history'] = [];
    }

    // Filter old uploads
    $_SESSION['upload_history'] = array_filter($_SESSION['upload_history'], function($timestamp) use ($time, $window) {
        return ($time - $timestamp) < $window;
    });

    if (count($_SESSION['upload_history']) >= $limit) {
        return false;
    }

    return true;
}

/**
 * Mark an upload attempt
 */
function mark_upload_attempt() {
    $_SESSION['upload_history'][] = time();
}
