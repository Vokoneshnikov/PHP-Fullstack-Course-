<?php 
include_once 'IMiddleware.php';
class CsrfMiddleware implements IMiddleware {
    public function handle($request, $next) {
        if ($request->method === 'POST') {
            $token = $request->post['csrf_token'] ?? null;
            $storedToken = $request->session['csrf_token'] ?? null;
            
            if (!$storedToken || $token !== $storedToken) {
                http_response_code(403);
                echo "CSRF token validation failed";
                exit;
            }
            
            unset($request->session['csrf_token']);
        }
        else if ($request->method === 'GET') {
            $this->generateToken($request);
        }
        
        return $next($request);
    }
    
    public function generateToken($request) {
        $token = bin2hex(random_bytes(32)); 
        $request->session['csrf_token'] = $token;
        return;
    }

    public function getToken($request) {
        return $request->getAttribute('csrf_token');
    }
}
?>