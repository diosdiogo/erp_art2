<?php

namespace App\Http\Controllers\Behavior;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Behavior\BaseAuthController;

class UpdateBaseDashboardController extends BaseAuthController
{
    protected $inicializarModel = false;
    
    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}