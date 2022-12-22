<?php

namespace App\Http\Middleware;

use App\Services\Notification\LogNotificationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class CheckLocale
{
    public const DEFAULT_LOCALE = 'ru';

    public LogNotificationService $logNotificationService;

    public function __construct(LogNotificationService $logNotificationService)
    {
        $this->logNotificationService = $logNotificationService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route()->parameter('locale') ?? 'ru';

        $this->locale($locale);

        $request->route()->forgetParameter('locale');

        return $next($request);
    }

    private function locale(string $locale)
    {
        if (!in_array($locale, ['ru', 'en'], true)) {
            $locale = self::DEFAULT_LOCALE;
        }
        App::setLocale($locale);
        //\Illuminate\Support\Facades\View::share('locale', $locale);
    }
}
