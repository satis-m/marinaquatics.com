<?php

namespace App\Http\Middleware;

use App\Models\ApplicationInfo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
    public function version(Request $request): ?string
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
        if ($request->is('admin/*')) {
            $this->rootView = 'adminApp';

            $flashMessage = $pageException = [];

            if (Session::get('pageException')) {
                $pageException = [
                    'token' => md5(date('Y-m-d H:i:s')),
                    'statusCode' => Session::get('pageException'),
                ];
            }

            if ($message = Session::get('success')) {
                $flashMessage = ['message' => '', 'type' => 'success', 'title' => 'Success', 'hasHtML' => false];
                if (\is_array($message)) {
                    $flashMessage = [...$flashMessage, ...$message];
                } else {
                    $flashMessage['message'] = $message;
                    $flashMessage['type'] = 'success';
                    $flashMessage['title'] = 'Success';
                    $flashMessage['hasHTML'] = false;
                }
            } elseif ($message = Session::get('info')) {
                $flashMessage = ['token' => md5(date('Y-m-d H:i:s')), 'message' => '', 'type' => 'info', 'title' => 'Info', 'hasHTML' => false];
                if (\is_array($message)) {
                    $flashMessage = [...$flashMessage, ...$message];
                } else {
                    $flashMessage['message'] = $message;
                    $flashMessage['type'] = 'info';
                    $flashMessage['title'] = 'Info';
                    $flashMessage['hasHTML'] = false;
                }
            } elseif ($message = Session::get('warning')) {
                $flashMessage = ['message' => '', 'type' => 'warning', 'title' => 'Warning', 'hasHtML' => false];
                if (\is_array($message)) {
                    $flashMessage = [...$flashMessage, ...$message];
                } else {
                    $flashMessage['message'] = $message;
                    $flashMessage['type'] = 'warning';
                    $flashMessage['title'] = 'Warning';
                    $flashMessage['hasHTML'] = false;
                }
            } elseif ($message = Session::get('error')) {
                $flashMessage = ['message' => '', 'type' => 'error', 'title' => 'Error', 'hasHtML' => false];
                if (\is_array($message)) {
                    $flashMessage = [...$flashMessage, ...$message];
                } else {
                    $flashMessage['message'] = $message;
                    $flashMessage['type'] = 'error';
                    $flashMessage['title'] = 'Error';
                    $flashMessage['hasHTML'] = false;
                }
            }

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
                'auth' => fn () => $request->user('admin')
                    ?
                    [
                        'user' => $request->user('admin') ?? null,
                        'user_role' => $request->user('admin')->getRoleNames()->first(),
                    ] : null,
                'flash' => $flashMessage,
                'page_exception' => $pageException,
            ]);
        } else {
            $this->rootView = 'siteApp';

            return array_merge(parent::share($request), [
                'categories' => Category::all()->groupBy(['name'])->toArray(),
                'app_info' => ApplicationInfo::first(),
                'portal_menu' => fn () => $request->user('client')
                    ? json_decode(getPortalMenu('client'))
                    : null,
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy)->toArray(), [
                        'location' => $request->url(),
                    ]);
                },
                'auth' => fn () => $request->user('client')
                    ?
                    [
                        'user' => $request->user('client') ?? null,
                        'user_role' => $request->user('admin')->getRoleNames()->first(),
                    ] : null,

            ]);
        }
    }
}
