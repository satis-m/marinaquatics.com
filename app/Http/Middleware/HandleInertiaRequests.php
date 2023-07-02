<?php

namespace App\Http\Middleware;

use App\Models\ApplicationInfo;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'adminApp';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $guard = get_guard();
        if ($guard == 'admin') {
            $this->rootView = 'adminApp';

            return array_merge(parent::share($request), [
                'app_info' => ApplicationInfo::first(),
                'portal_menu' => fn () => $request->user('admin')
                    ? json_decode(getPortalMenu('admin'))
                    : null,
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy)->toArray(), [
                        'location' => $request->url(),
                    ]);
                },
                'auth' => [
                    'user' => $request->user('admin') ?? null,
                ],
            ]);
        } else {
            $this->rootView = 'app';

            return array_merge(parent::share($request), [
                'app_info' => ApplicationInfo::first(),
                'portal_menu' => fn () => $request->user('client')
                    ? json_decode(getPortalMenu('client'))
                    : null,
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy)->toArray(), [
                        'location' => $request->url(),
                    ]);
                },
                'auth' => [
                    'user' => $request->user('client') ?? null,
                ],
            ]);
        }

    }
}
