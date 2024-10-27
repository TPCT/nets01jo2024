<?php

namespace App\Http\Middleware;
use App\Traits\HandleApiJsonResponseTrait;
use Closure;

class AssignGuard
{
    use HandleApiJsonResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $guard = null )
    {
        if ($guard != null) {
            auth()->shouldUse($guard);
        }
        $token = $request->header('token');
        $request->headers->set('token', (string) $token, true);
        $request->headers->set('Authorization', 'Bearer ' . $token, true);

        if (auth($guard)->check() ) {

            if( auth($guard)->user()->status === 1){

                return $next($request);

            }else if( auth($guard)->user()->status === 0 ){
                return $this->error( __('api.not Active') );
            }else if( auth($guard)->user()->status === -1 ){
                return $this->error( __('api.account deleted') );
            }
        } else {
            return $this->error( __('api.Unauthorized') );
        }
    }
}
