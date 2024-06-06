<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize{

    /**
     * Check is user is Authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return Session::has('user');
    }

    /**
     * Handle the user's request
     * @param string $role
     * @return void
     */
    public function handle($role)
    {

//        inspectAndDie($role);

        if($role === 'guest' && $this->isAuthenticated()){
            return redirect('/');
        }

        elseif ($role === 'auth' && !$this->isAuthenticated()){
            return redirect('/auth/login');
        }
    }
}



//$roles = ['superAdmin' ,  'agent' , 'user' , 'guest'];


