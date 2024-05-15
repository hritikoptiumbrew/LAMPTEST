<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles, $permissions, $validateAll = false)
    {
//        if(!request()->headers->get('origin') == 'http://192.168.0.109'){
//            abort(404);
//        }

        //$token = $request->bearerToken();
        $token = JWTAuth::getToken();

        if (!$token) {
            return Response::json(array('code' => 201, 'message' => 'Required field token is missing or empty.', 'cause' => '', 'data' => json_decode("{}")));
        }

        try {
            $user = JWTAuth::toUser($token);

            if (!$user) {
                return Response::json(array('code' => 404, 'message' => 'User not found.', 'cause' => '', 'data' => json_decode("{}")));
            }

        } catch (TokenInvalidException $e) {
            return Response::json(array('code' => 400, 'message' => 'Invalid token.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (TokenExpiredException $e) {

            try {
                $new_token = JWTAuth::refresh($token);

            } catch (TokenExpiredException $e) {
                return Response::json(array('code' => 400, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode('{}')));

            } catch (TokenBlacklistedException $e) {
                return Response::json(array('code' => 400, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));

            } catch (JWTException $e) {
                return Response::json(array('code' => 400, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            }

            return Response::json(array('code' => 401, 'message' => $e->getMessage(), 'cause' => '', 'data' => ['new_token' => $new_token]));

        } catch (JWTException $e) {
            return Response::json(array('code' => 400, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));

        }

        if (!$user) {
            return Response::json(array('code' => 404, 'message' => 'User not found.', 'cause' => '', 'data' => json_decode("{}")));
        }

        //if (!($request->user()->hasAnyRole(explode('|', $roles)) || $request->user()->hasAnyPermission(explode('|', $permissions)))) {
            //return Response::json(array('code' => 201, 'message' => 'Unauthorized user.', 'cause' => '', 'data' => json_decode("{}")));
        //}

        if ((app('auth')->guard(null)->user()->hasAnyPermission(explode('|', $permissions))) || Auth::guard(null)->user()->hasAnyRole(explode('|', $roles))) {
            return $next($request);
        } else {
            return Response::json(array('code' => 201, 'message' => 'Unauthorized user.', 'cause' => '', 'data' => json_decode("{}")));
        }

        //Event::listen('tymon.jwt.valid');

        return $next($request);
    }
}
