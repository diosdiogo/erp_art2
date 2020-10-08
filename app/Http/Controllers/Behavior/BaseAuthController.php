<?php

namespace App\Http\Controllers\Behavior;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Behavior\BaseController;

class BaseAuthController extends BaseController
{
    public function __construct($folder)
    {
        $this->middleware('auth');
        parent::__construct($folder);
    }
}
