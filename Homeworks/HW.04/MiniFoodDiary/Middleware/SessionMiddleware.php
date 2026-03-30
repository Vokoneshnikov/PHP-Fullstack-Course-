<?php
require_once __DIR__ . '/IMiddleware.php';
class SessionMiddleware implements IMiddleware {
    public function handle($request, $next) {
        $this->startSession();

        $request->session = &$_SESSION;
        $response = $next($request);
        return $response;
    }

    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            error_log("SessionMiddleware: session started, ID: " . session_id());
        } else {
            error_log("SessionMiddleware: session already active, ID: " . session_id());
        }
    } 
}