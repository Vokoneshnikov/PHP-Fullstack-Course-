<?php
class CsrfMiddleware implements IMiddleware {
    public function handle($request, $next) {
        if ($request->method === 'POST') {
            $token = $request->post['csrf_token'] ?? null;
            $storedToken = $request->session['csrf_token'] ?? null;
            
            if (!$storedToken || $token !== $storedToken) {
                unset($request->session['csrf_token']);
                http_response_code(403);
                echo "<h1>CSRF token validation failed</h1>";
                echo "<p>Received: " . htmlspecialchars($token) . "</p>";
                echo "<p>Stored: " . htmlspecialchars($storedToken) . "</p>";
                exit;
            }
            
            unset($request->session['csrf_token']);
        } 
        else if ($request->method === 'GET') {
            $token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $token;
            
            $request->session['csrf_token'] = $token;
            $request->setAttribute('csrf_token', $token);
        }
        
        return $next($request);
    }
}
?>