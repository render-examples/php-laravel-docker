<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirection
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Constructeur
=======
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
>>>>>>> origin/master
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
<<<<<<< HEAD

    /**
     * Validation
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {

        return $this->guard()->attempt(
            array_merge($this->credentials($request), ['is_active' => true]),
            $request->filled('remember')
        );
    }

    /**
     * Réponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if (User::where('email', $request->email)
            ->where('is_active', false)
            ->exists()) {
            $errors = [$this->username() => 'Votre compte est en attente de validation.'];
        }

        throw ValidationException::withMessages($errors);
    }

    /**
     * Redirection
     */
    protected function authenticated(Request $request, $user)
    {

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->professeur) {
            return redirect()->route('professeur.dashboard');
        }
        elseif ($user->eleve) {
            return redirect()->route('bulletin.index');
        }

        // Par défaut pour les élèves
        return redirect()->intended($this->redirectPath());

    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/');
    }
=======
>>>>>>> origin/master
}
