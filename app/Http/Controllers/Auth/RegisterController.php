<?php

namespace App\Http\Controllers\Auth;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\ClasseMatiereProfesseur;
use App\Models\Eleve;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $redirectTo = '/login';

=======
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
>>>>>>> origin/master
    public function __construct()
    {
        $this->middleware('guest');
    }

<<<<<<< HEAD
    protected function validator(array $data)
    {
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telephone' => ['required', 'string', 'max:20'],
            'date_de_naissance' => ['required', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'terms' => ['required'],
            'user_type' => ['required', 'in:eleve,professeur'],
        ];

        if (isset($data['user_type']) && $data['user_type'] === 'eleve') {
            $rules['classe_id'] = ['required', 'exists:classes,id'];
            $rules['annee_academique_id'] = ['required', 'exists:annee_academique,id'];
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        $photoPath = null;
        if (isset($data['photo']) && $data['photo']) {
            if (is_object($data['photo']) && method_exists($data['photo'], 'store')) {
                $photoPath = $data['photo']->store('avatars', 'public');
            }
        }

        if (! $photoPath) {
            $photoPath = 'avatars/default.png';
        }

        $user = User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'date_de_naissance' => $data['date_de_naissance'],
            'password' => Hash::make($data['password']),
            'photo' => $photoPath,
            'is_active' => false,
        ]);

        if ($data['user_type'] === 'eleve') {
            Eleve::create([
                'user_id' => $user->id,
                'classe_id' => $data['classe_id'],
                'annee_academique_id' => $data['annee_academique_id'],
            ]);
        } elseif ($data['user_type'] === 'professeur') {
            Professeur::create([
                'user_id' => $user->id,
            ]);
        }

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function showRegistrationForm()
    {
        $classes = Classe::all();
        $annees = AnneeAcademique::all();

        return view('auth.register', compact('classes', 'annees'));
    }

    protected function registered(Request $request, $user)
    {
        return redirect($this->redirectPath())
            ->with('success', 'Votre inscription a été soumise. Un administrateur validera votre compte sous 48h.');
    }

    protected function redirectPath()
    {
        return $this->redirectTo ?? '/login';
    }

  
=======
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
>>>>>>> origin/master
}
