<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\ManajemenController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PerlengkapanController;
use App\Http\Controllers\OlahanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Auth::routes(["verify" => true]);

Route::get("/home", [App\Http\Controllers\HomeController::class, "index"])
    ->middleware(["verified"])
    ->name("home");

Route::get("/", [AuthController::class, "index"]);

Route::get("/login-page", [AuthController::class, "index"])->name("login.page");
Route::post("/login/action", [AuthController::class, "actionLogin"])->name(
    "login.action"
);
Route::get("/registrasi", [AuthController::class, "registrasi"])->name(
    "registrasi"
);
Route::post("/registrasi/action", [
    AuthController::class,
    "actionRegistrasi",
])->name("registrasi.action");

Route::get("/logout", [AuthController::class, "logout"])->name("logout.action");

Route::prefix("admin")->group(function () {
    Route::get("/kolam", [KolamController::class, "index"])->name(
        "admin.kolam.index"
    );
    Route::post("/kolam/store", [KolamController::class, "store"])->name(
        "admin.kolam.store"
    );
    Route::get("/kolam/delete/{id}", [KolamController::class, "destroy"])->name(
        "admin.kolam.delete"
    );
    Route::put("/kolam/{id}", [KolamController::class, "update"])->name(
        "admin.kolam.update"
    );
    Route::post("/kolam/detail", [KolamController::class, "detail"])->name(
        "kolam.detail"
    );
    Route::get("/manajemen", [ManajemenController::class, "index"])->name(
        "admin.manajemen.index"
    );
    Route::post("/manajemen/store", [
        ManajemenController::class,
        "store",
    ])->name("admin.manajemen.store");
    Route::put("/manajemen/update/{id}", [
        ManajemenController::class,
        "update",
    ])->name("admin.manajemen.update");
    Route::delete("/manajemen/delete/{id}", [
        ManajemenController::class,
        "destroy",
    ])->name("admin.manajemen.delete");
});

Route::get("/dashboard", [DashboardController::class, "index"])->name(
    "dashboard"
);

Route::get("/keuangan", [KeuanganController::class, "index"])->name("keuangan");
Route::post("/keuangan/store", [KeuanganController::class, "store"])->name(
    "keuangan.add"
);
Route::post("/keuangan/detail", [KeuanganController::class, "detail"])->name(
    "keuangan.detail"
);
Route::post("/keuangan/update", [KeuanganController::class, "update"])->name(
    "keuangan.update"
);
Route::get("/keuangan/{id}/destroy", [
    KeuanganController::class,
    "destroy",
])->name("keuangan.destroy");

Route::get("/pakan", [FeedController::class, "index"])->name("pakan");
Route::post("/pakan/store", [FeedController::class, "store"])->name(
    "pakan.add"
);
Route::post("/pakan/detail", [FeedController::class, "detail"])->name(
    "pakan.detail"
);
Route::post("/pakan/update", [FeedController::class, "update"])->name(
    "pakan.update"
);
Route::get("/pakan/{id}/destroy", [FeedController::class, "destroy"])->name(
    "pakan.destroy"
);

Route::get("/tools", [PerlengkapanController::class, "index"])->name("tools");
Route::post("/tools/store", [PerlengkapanController::class, "store"])->name(
    "tools.add"
);
Route::post("/tools/detail", [PerlengkapanController::class, "detail"])->name(
    "tools.detail"
);
Route::post("/tools/update", [PerlengkapanController::class, "update"])->name(
    "tools.update"
);
Route::get("/tools/{id}/destroy", [
    PerlengkapanController::class,
    "destroy",
])->name("tools.destroy");

Route::get("/olahan", [OlahanController::class, "index"])->name("olahan");
Route::post("/olahan/store", [OlahanController::class, "store"])->name(
    "olahan.add"
);
Route::post("/olahan/detail", [OlahanController::class, "detail"])->name(
    "olahan.detail"
);
Route::post("/olahan/update", [OlahanController::class, "update"])->name(
    "olahan.update"
);
Route::get("/olahan/{id}/destroy", [OlahanController::class, "destroy"])->name(
    "olahan.destroy"
);

Route::prefix("super-admin")->group(function () {
    Route::get("/user", [UserController::class, "index"])->name("user");
    Route::post("/user/filter", [UserController::class, "filter"])->name(
        "user.filter"
    );
    Route::post("/user/detail", [UserController::class, "detail"])->name(
        "user.detail"
    );
    Route::post("/user/store", [UserController::class, "store"])->name(
        "user.add"
    );
    Route::post("/user/update", [UserController::class, "update"])->name(
        "user.update"
    );
    Route::get("/user/{id}/destroy", [UserController::class, "destroy"])->name(
        "user.destroy"
    );
});

// verification

Route::get("/email/verify", function () {
    return view("auth.verify-email");
})
    ->middleware("auth")
    ->name("verification.notice");

Route::get("/email/verify/{id}/{hash}", function (
    EmailVerificationRequest $request
) {
    $request->fulfill();

    return redirect("/login-page")->with("success", "Account Is Activated !");
})
    // ->middleware(["auth", "signed"])
    ->name("verification.verify");
