<?php
// insert_feedback.php
// This script receives POST data and inserts feedback into Supabase using REST API

// Supabase project details
$supabase_url = 'https://wqtxlhtecznlfpfipjnt.supabase.co';
$supabase_service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6IndxdHhsaHRlY3pubGZwZmlwam50Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1OTg0Nzk4NSwiZXhwIjoyMDc1NDIzOTg1fQ.jlQH23kJLq1oLVbKpuInVCXrla6MSjBvF93IsS1Nhgc';

// Get POST data
$raw_input = file_get_contents('php://input');
$input = json_decode($raw_input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input: ' . json_last_error_msg()]);
    exit;
}

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Empty JSON input']);
    exit;
}

$first_name = $input['first_name'] ?? null;
$last_name = $input['last_name'] ?? null;
$email = $input['email'] ?? null;
$subject = $input['subject'] ?? null;
$rating = $input['rating'] ?? null;
$message = $input['message'] ?? null;

if (!$first_name || !$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Prepare data for insertion
$data = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'subject' => $subject,
    'rating' => $rating,
    'message' => $message
];

// Insert data using Supabase REST API
$endpoint = $supabase_url . '/rest/v1/feedback_reviews';
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $supabase_service_key,
    'Authorization: Bearer ' . $supabase_service_key,
    'Content-Type: application/json',
    'Prefer: return=representation'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code >= 200 && $http_code < 300) {
    echo $response;
} else {
    http_response_code($http_code);
    echo json_encode(['error' => 'Failed to insert feedback', 'response' => $response]);
}
?>
