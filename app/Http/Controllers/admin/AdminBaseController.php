<?php

namespace App\Http\Controllers\admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use View;
use Illuminate\Support\Facades\Session;

class AdminBaseController extends BaseController
{
    public function __construct(Request $request)
	{
	   View::share('adminName', $request->session()->get('admin'));
	}
}
