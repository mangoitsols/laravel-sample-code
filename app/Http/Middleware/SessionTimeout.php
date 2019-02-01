<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Session\Store;

class SessionTimeout {

    protected $session;
    /*protected $timeout = 1500;*/
    protected $timeout = 5000;
    public function __construct(Store $session){        
        $this->session = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {  
        $isLoggedIn = $request->path() != 'dashboard/logout';

        if(! session('lastActivityTime'))
            $this->session->put('lastActivityTime', time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
            $this->session->forget('lastActivityTime');
            $email = $request->user()->email;
            Auth::logout();
            $this->session->flush();
            echo 'You had not activity in '.$this->timeout/60 .' minutes ago.';
            return redirect('/login');
        }        
        $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');
        
        return $next($request);
    }

}