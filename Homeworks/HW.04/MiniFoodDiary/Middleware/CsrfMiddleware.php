<!-- <?php 
// include_once 'IMiddleware.php';
// class CsrfMiddleware implements IMiddleware {
//     public function handle($request, $next) {
//         if ($request->method === 'POST') {
//             $token = $request->post['csrf_token'] ?? null;
//             $storedToken = $request->session['csrf_token'] ?? null;
            
//             if (!$storedToken || $token !== $storedToken) {
//                 http_response_code(403);
//                 echo "CSRF token validation failed";
//                 exit;
//             }
            
//             unset($request->session['csrf_token']);
//         }
//         else if ($request->method === 'GET') {
//             $this->generateToken($request);
//         }
        
//         return $next($request);
//     }
    
//     public function generateToken($request) {
//         $token = bin2hex(random_bytes(32)); 
//         $request->session['csrf_token'] = $token;
//         return;
//     }

//     public function getToken($request) {
//         return $request->getAttribute('csrf_token');
//     }
// }
// ?> -->


<?php
// Middleware/CsrfMiddleware.php

class CsrfMiddleware implements IMiddleware {
    public function handle($request, $next) {
        if ($request->method === 'POST') {
            $token = $request->post['csrf_token'] ?? null;
            $storedToken = $request->session['csrf_token'] ?? null;
            
            error_log("=== POST CSRF ===");
            error_log("Received token: " . $token);
            error_log("Stored token: " . $storedToken);
            
            if (!$storedToken || $token !== $storedToken) {
                unset($request->session['csrf_token']);
                http_response_code(403);
                echo "<h1>CSRF token validation failed</h1>";
                echo "<p>Received: " . htmlspecialchars($token) . "</p>";
                echo "<p>Stored: " . htmlspecialchars($storedToken) . "</p>";
                exit;
            }
            
            unset($request->session['csrf_token']);
            error_log("CSRF OK - token removed");
        } 
        // Middleware/CsrfMiddleware.php - в блоке GET
        else if ($request->method === 'GET') {
        error_log("=== GET CSRF ===");
        error_log("Session ID: " . session_id());
        
        $token = bin2hex(random_bytes(32));
        $request->session['csrf_token'] = $token;
        $request->setAttribute('csrf_token', $token);
        
        error_log("Generated token: " . $token);
        error_log("Saved to session: " . ($request->session['csrf_token'] ?? 'NULL'));
        error_log("Session data: " . print_r($_SESSION, true));
    }
        
        return $next($request);
    }
}
?>