<?php
// API Dashboard Analytics Endpoint

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
session_start();

require_once dirname(__DIR__) . '/config.php';

// Only accept GET for data retrieval
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// 1. Authorization Check
// In a real app, verify $_SESSION['user_id'] is a valid admin.
if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    // Continuing for demo purposes, but normally we would exit here:
    // echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    // exit;
}

// 2. Fetch Dashboard Analytics (Mocked for now)
try {
    // Example Database Queries:
    // $stmt = $pdo->query("SELECT count(*) as total_users FROM users");
    // $totalUsers = $stmt->fetch()['total_users'];
    
    // $stmt = $pdo->query("SELECT action, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 5");
    // $logs = $stmt->fetchAll();

    $stats = [
        'total_users' => 1250,
        'active_today' => 342,
        'storage_used_gb' => 12.4,
        'tools_used_today' => 845
    ];

    $activity_logs = [
        ['user' => 'Admin', 'action' => 'Server Maintenance', 'time' => '10 mins ago'],
        ['user' => 'User_841', 'action' => 'Compressed 5 images', 'time' => '1 hour ago'],
        ['user' => 'System', 'action' => 'Daily Backup completed', 'time' => '3 hours ago']
    ];

    echo json_encode([
        'success' => true,
        'data' => [
            'stats' => $stats,
            'logs' => $activity_logs
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error fetching analytics.']);
}
