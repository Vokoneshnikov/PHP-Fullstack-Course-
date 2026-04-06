<?php
namespace App\Controllers;

use App\RequestInfo;

class ProfileController extends BaseController {
    protected RequestInfo $requestInfo;

    public function setRequestInfo(RequestInfo $requestInfo) {}
    public function index() {
        echo "HELLO USER!!!";
    }
}