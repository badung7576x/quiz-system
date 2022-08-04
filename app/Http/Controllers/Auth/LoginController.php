<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended($this->redirectAfterLogin());
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    protected function redirectAfterLogin()
    {
        $user = auth()->user();
        switch($user->role) {
            case ROLE_ADMIN:
                return route('admin.teacher.index');
            case ROLE_PRO_CHIEF:
                return route('admin.dashboard.index');
            case ROLE_SPECIALIST_TEACHER:
            case ROLE_SUBJECT_TEACHER:
            case ROLE_TEACHER:
                return route('admin.exam-set.index');
                
            default:
                return route('admin.exam-set.index');
        }
    }
}
