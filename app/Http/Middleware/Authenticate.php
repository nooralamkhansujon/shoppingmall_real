<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if($request->is('admin/*')){
            session()->flash('flash_message_error','Please Login To Access');
            return route('admin');
        }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

}
