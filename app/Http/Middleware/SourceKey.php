<?php

namespace App\Http\Middleware;
use App\Traits\HandleApiJsonResponseTrait;
use App\Models\MaximumNumberOfMessage;
use Carbon\Carbon;
use Closure;

class SourceKey
{
    use HandleApiJsonResponseTrait;
    
    
    public function handle($request, Closure $next)
    {
        // $formattedDate = Carbon::now()->format('d-F-Y');
        // $yesterday = Carbon::yesterday();

        if ($request->header('sourcekey')) {
            $sourcekey = $request->header('sourcekey');
            $dayOfMonth = Carbon::now()->day;
            $key = $dayOfMonth * 4 + $dayOfMonth + 3;
            
            if($sourcekey == $key)
            {
                $countOfday = MaximumNumberOfMessage::where('created_at', Carbon::now()->format('d-F-Y'))->count();
                if($countOfday >= 100){
                    return $this->error( __('api.not Active') );
                }else{
                    MaximumNumberOfMessage::create([
                        'ip_address'   => $request->ip()
                    ]);

                    MaximumNumberOfMessage::where('created_at', Carbon::yesterday())->delete();
                }
                return $next($request);
            }else 
                return $this->errorNotFound();
 
        } else {
            return $this->error( __('api.Unauthorized') );
        }

        // return $next($request);
    }

}
