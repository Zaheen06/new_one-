<?php
// fetch_feedback.php
// This script fetches feedback from Supabase using REST API

header('Content-Type: application/json');

// Supabase project details
$supabase_url = 'https://kdcpsqckzfhittwpmobp.supabase.co';
$supabase_service_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImtkY3BzcWNremZoaXR0d3Btb2JwIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc2MDQwMzA4MCwiZXhwIjoyMDc1OTc5MDgwfQ.q1_Mz9zHYSE5gD2ovhd0ZApeXwBamKtPxve-hi5IZZo';

// Fetch data from Supabase REST API
$endpoint = $supabase_url . '/rest/v1/feedback_reviews?order=created_at.desc';
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $supabase_service_key,
    'Authorization: Bearer ' . $supabase_service_key,
    'Accept: application/json'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($http_code >= 200 && $http_code < 300) {
    // Ensure we only output valid JSON
    if (empty($response)) {
        echo json_encode([]);
    } else {
        // Validate JSON before echoing
        $decoded = json_decode($response);
        if (json_last_error() === JSON_ERROR_NONE) {
            echo $response;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Invalid JSON response from Supabase']);
        }
    }
} else {
    http_response_code($http_code);
    echo json_encode(['error' => 'Failed to fetch feedback', 'http_code' => $http_code, 'curl_error' => $curl_error, 'response' => $response]);
}
?>
