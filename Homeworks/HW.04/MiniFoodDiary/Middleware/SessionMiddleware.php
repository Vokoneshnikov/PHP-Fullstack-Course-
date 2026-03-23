<?php

class SessionMiddleware implements IMiddleware {
    public function handle($request, $next) {
        $this->startSession();
        return $next($request);
    }
    
    public function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

?>