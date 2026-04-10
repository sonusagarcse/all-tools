<?php
// API Authentication Endpoint

// 1. Enforce strict JSON output
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
session_start();

// 2. Load Config
require_once dirname(__DIR__) . '/config.php';

// 3. Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$action = $_POST['action'] ?? '';

// --- ROUTER ---
if ($action === 'login') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email and password required']);
        exit;
    }

    try {
        // Example secure DB query
        // $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        // $stmt->execute([$email]);
        // $user = $stmt->fetch();
        
        // Mock success for demo assuming no real DB schema exists yet
        if ($email === 'demo@bulktools.com' && $password === 'password') {
            session_regenerate_id(true); // Prevent Session Fixation
            $_SESSION['user_id'] = 1;
            
            echo json_encode([
                'success' => true, 
                'message' => 'Login successful',
                'user' => [
                    'id' => 1,
                    'email' => $email
                ]
            ]);
            exit;
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid credentials. Try demo@bulktools.com / password']);
            exit;
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }
}

if ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
    exit;
}

if ($action === 'send_otp') {
    $phone = $_POST['phone'] ?? '';
    if (empty($phone)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Phone number required for OTP']);
        exit;
    }
    
    // OTP Stub Generation
    // $otp = rand(100000, 999999);
    // Send SMS logic here
    
    echo json_encode(['success' => true, 'message' => 'OTP sent successfully (stub)']);
    exit;
}

// Fallback
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid action']);
exit;
