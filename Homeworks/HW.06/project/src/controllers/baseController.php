<?php
namespace App\Controllers;

use App\RequestInfo;

abstract class BaseController {
    protected RequestInfo $requestInfo;

    public abstract function setRequestInfo(RequestInfo $requestInfo);
}