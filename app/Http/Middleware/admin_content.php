<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Helpers\AdminHelper;
use Auth;

class admin_content
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 'admin-content'){
            return redirect()->route('backend.home')->with('alert',AdminHelper::alert_admin('danger','','Bạn không sử dụng được chức năng này '));

        }
        return $next($request);
    }
}
