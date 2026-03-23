<?php

// Middleware/SessionMiddleware.php
class SessionMiddleware implements IMiddleware {
    public function handle($request, $next) {
        $this->startSession();
        
        error_log("=== SessionMiddleware ===");
        error_log("Session ID after start: " . session_id());
        error_log("Session data: " . print_r($_SESSION, true));
        
        return $next($request);
    }
    
    public function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            error_log("Session started, ID: " . session_id());
        } else {
            error_log("Session already active, ID: " . session_id());
        }
    }
}

?>