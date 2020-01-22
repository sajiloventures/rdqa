<?php

namespace App\Http\Middleware;

use AppHelper;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Route as LaravelRoute;
use App\Models\Route as AppRoute;
use Log;
use Flash;
use AppExceptionHandler;
use Zizaco\Entrust\Entrust;

class AuthorizeRoute
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $authorized = false;    // Default to protect all routes.
        $errorCode = 0;        // Default to something bogus...
        $method = null;
        $path = null;
        $actionName = null;
        $user = null;
        $username = null;
        $guest = false;

        // Get current route from Laravel.
        $laravelRoute = LaravelRoute::current();

        // If not set we will fallback to error HTTP 500. This should never occur. TODO: remove this check...
        if (isset($laravelRoute)) {
            // Get route info.
            // old methods replaced to run code smoothly.
            // Get route info.
            $method = $laravelRoute->methods()[0];
            $path = $laravelRoute->uri();
            $actionName = $laravelRoute->getActionName();
            $prefix = AppHelper::getRoutePrefixName($laravelRoute->getPrefix());
            // Get current user or set guest to true for unauthenticated users.
            if ($this->auth->check()) {
                $user = $this->auth->user();
                $username = $user->username;
            } elseif ($this->auth->guest()) {
                $guest = true;
            }

            // AuthController and PasswordController are exempt from authorization.
            // TODO: Get list of controllers exempt from config.
            if (str_contains($actionName, 'AuthController@') ||
                str_contains($actionName, 'PasswordController@')
            ) {
                $authorized = true;
            }
            // User is 'root', all is authorized.
            // TODO: Get super user name from config, and replace all occurrences.
            elseif (!$guest && isset($user) && 'root' == $user->username) {

                $authorized = true;
            }
            // User has the role 'admins', all is authorized.
            // TODO: Get 'admin' role name from config, and replace all occurrences.
            elseif (!$guest && isset($user) && $user->hasRole('super-admin')) {
                $authorized = true;
            } else {

                // Get application route based on info from Laravel route.
                $appRoute = AppRoute::ofMethod($method)
                    ->ofActionName($actionName)
                    ->ofPath($path)
                    ->enabled()
                    ->with('permission')
                    ->first();
                // If found, proceed with authorization
                if (isset($appRoute)) {

                    // Permission set for route.
                    if (isset($appRoute->permission)) {

                        // Route is open to all.
                        // TODO: Get 'open-to-all' role name from config, and replace all occurrences.
                        if ('open-to-all' == $appRoute->permission->name) {
                            $authorized = true;
                        }
                        elseif ('admin!GET' == $appRoute->permission->name || 'admin/dashboard!GET' == $appRoute->permission->name) {

                            $authorized = true;
                        }
                        // TODO: Get 'guest-only' role name from config, and replace all occurrences.
                        // User is guest/unauthenticated and the route is restricted to guests.
                        elseif ($guest && 'guest-only' == $appRoute->permission->name) {
                            $authorized = true;
                        }
                        // TODO: Get 'basic-authenticated' role name from config, and replace all occurrences.

                        // The route is available to any authenticated user.
                        elseif (!$guest && isset($user) && ($user->enabled) && 'basic-authenticated' == $appRoute->permission->name) {

                            $authorized = true;
                        } // The user has the permission required by the route.
                        elseif (!$guest && isset($user) && ($user->enabled) && $user->can($appRoute->permission->name)) {
                            $authorized = true;
                        } // If all checks fail, abort with an HTTP 403 error.
                        else {

                            AppExceptionHandler::logMessage('error', "Authorization denied for request path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "], guest [" . $guest . "], username [" . $username . "].", 1);
                            $errorCode = 403;
                        }
                    } // If all checks fail, abort with an HTTP 403 error.
                    else {
                        AppExceptionHandler::logMessage('error', "No permission set for the requested route, path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "], guest [" . $guest . "], username [" . $username . "].", 1);
                        $errorCode = 403;
                    }
                } // If application route is not found
                else {
                    AppExceptionHandler::logMessage('error', "No application route found in AuthorizeRoute module for request path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "].", 1);
                    $errorCode = 403;
                }
            }
        }

        // If authorize, proceed
        if ($authorized) {
            return $next($request);

        } elseif (0 != $errorCode) {

            if (!$guest && isset($user) && (!$user->enabled)) {
                AppExceptionHandler::logMessage('error', "User [" . $user->username . "] disabled, forcing logout.", 1);

                return redirect(route('admin.logout'));
            } else {


                // Detect ajax request
                if (request()->ajax()) {

                    return response()->json([
                        'error' => 'Trying to access unauthorized resource.',
                    ], 401);

                } else {

                    // conditions to redirect / show error page

                    /**
                     * If trying to access admin panel routes without login
                     * Helps to redirect back to requested admin panel url
                     * after login using Laravel redirect with intended()
                     */
                    if ($prefix == 'admin' && !isset($user)) {
                        return redirect()->guest(route('login'));
                    }
                    /**
                     * If Authenticated as Admin type User and trying to access route
                     * only accessable by Customer type User
                     */
                    elseif ($prefix == 'customer' && isset($user) && !$user->hasRole('customer')) {
                        Flash::warning('Trying to access unauthorized resource.');
                        return redirect()->route('admin_home');
                    }
                    /**
                     * If trying to access customer panel routes without login
                     * Helps to redirect back to requested customer panel url
                     * after login using Laravel redirect with intended()
                     */
                    elseif ($prefix == 'customer' && !isset($user)) {
                        return redirect()->guest('customer/login');
                    } /**
                     * If Authenticated as Admin type User and trying to access route
                     * only accessable by Customer type User
                     */
                    elseif ($prefix == 'guest' && isset($user)) {
                        Flash::info('Sorry, you must Log Out first to checkout as guest.');
                        return redirect()->route('home');
                    }
                    // Else if error code was set abort with that.
                    else{

                        return redirect('admin/error/'.$errorCode);

                        abort($errorCode);
                    }


                }

            }

            // Lastly Fallback to error HTTP 500: Internal server error. We should not get to this!
        } else {
            AppExceptionHandler::logMessage('error', "Server error while trying to authorize route, request path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "].", 1);
            abort(500);
        }
    }

}
