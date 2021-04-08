<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMenu;
use App\Models\ListMenu;
use Illuminate\Support\Facades\Route;

class UserAccess
{
    const CONTROLLER_ACCESS_MENU = [
        ListMenu::monitoring => 'MonitoringController',
        ListMenu::dashboard => 'FleetController',
        ListMenu::driver => 'DriverController',
        ListMenu::fleet_car => 'CarController',
        ListMenu::card => 'CardController',
        ListMenu::cost => 'CostController',
    ];

    private function checkControllerAccessFree($seeksFreeAccess)
    {

        if (
            \str_contains($seeksFreeAccess, 'UserController')
            || \str_contains($seeksFreeAccess, 'HomeController')
        ) {
            return true;
        }
    }


    private function allowedMenu($user, $control)
    {
        $seeksFreeAccess = Route::currentRouteAction();
        if ($this->checkControllerAccessFree($seeksFreeAccess)) return true;

        $userMenu = UserMenu::where('user_id', $user->id)->get();

        foreach ($userMenu as $menus) {

            $nameMenu = $menus->listMenu->name;
            $accessController = isset(UserAccess::CONTROLLER_ACCESS_MENU[$nameMenu]) ? UserAccess::CONTROLLER_ACCESS_MENU[$nameMenu] : null;

            if ($accessController && \str_contains($seeksFreeAccess, $accessController)) return true;
        }
        
        return false;
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
        $user = auth()->user();
        if (!$user) {
            return redirect('/');
        }

        if (!$this->allowedMenu($user, $request->route()->controller)) {
            return redirect('access_denied');
        }

        return $next($request);
    }
}
