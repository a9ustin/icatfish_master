<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function index()
    {
        return view("login");
    }

    public function registrasi()
    {
        return view("registrasi");
    }

    public function actionRegistrasi(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = "admin";
        $user->save();
        return redirect()
            ->route("login.page")
            ->with("success", "Registrasi Berhasil Silahkan Untuk Login !");
    }

    public function actionLogin(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            "email" => "required",
            "password" => "required",
        ]);

        $data = User::where("email", $request->email)->first();

        if ($data->status == 0) {
            return redirect()
                ->route("login.page")
                ->with("error", "Account Is Not Activate !");
        }

        if ($data->email_verified_at == null && $data->role == "admin") {
            return redirect()
                ->route("login.page")
                ->with("error", "Account Is Not Activate !");
        }

        if (
            auth()->attempt([
                "email" => $input["email"],
                "password" => $input["password"],
            ])
        ) {
            if (auth()->user()->role == "admin") {
                return redirect()->route("dashboard");
            } else {
                return redirect()->route("dashboard");
            }
        } else {
            return redirect()
                ->route("login.page")
                ->with("error", "Email And Password Are Wrong.");
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect("/login-page");
    }
}