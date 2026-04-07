<?php
namespace App\Controllers;

use App\RequestInfo;

class AuthController extends BaseController {
    protected RequestInfo $requestInfo;

    public function setRequestInfo(RequestInfo $requestInfo) {}
}