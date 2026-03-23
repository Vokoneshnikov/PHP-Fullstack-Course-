<?php
// Middleware/FlashMiddleware.php

class FlashMiddleware implements IMiddleware {
    public function handle($request, $next) {
        // Получаем flash из сессии и удаляем
        $flash = $request->session['_flash'] ?? null;
        unset($request->session['_flash']);
        
        // Кладем flash в request для контроллера
        $request->setAttribute('flash', $flash);
        
        $response = $next($request);
        
        // Если контроллер установил новый flash, сохраняем в сессию
        $newFlash = $request->getAttribute('_new_flash');
        if ($newFlash) {
            $request->session['_flash'] = $newFlash;
        }
        
        return $response;
    }
    
    public function setFlash($request, $type, $message) {
        $request->setAttribute('_new_flash', ['type' => $type, 'message' => $message]);
    }
    
    public function getFlash($request) {
        return $request->getAttribute('flash');
    }
}