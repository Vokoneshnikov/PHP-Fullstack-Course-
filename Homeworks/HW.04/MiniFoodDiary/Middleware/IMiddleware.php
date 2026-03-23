<?php
interface IMiddleware {
    public function handle($request, $next);
    
}

?>