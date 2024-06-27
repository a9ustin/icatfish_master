<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Satuan;
use Auth;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view("Super-admin.User.index", compact("user"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->role = $request->role;
        $data->status = $request->status;
        $data->save();
        event(new Registered($data));

        return redirect()
            ->route("user")
            ->with("success", "Data User Berhasil Ditambahkan !");
    }

    public function detail(Request $request)
    {
        $data = User::where("id", $request->id)->first();
        return response()->json([
            "data" => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = User::find($request->id);
        $data->name = $request->name;
        $data->email = $request->email;
        if (isset($request->password)) {
            $data->password = bcrypt($request->password);
        }
        $data->role = $request->role;
        $data->status = $request->status;
        $data->save();
        return redirect()
            ->route("user")
            ->with("success", "Data User Berhasil Diupdate !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            // unlink("file/user/" . $user->foto);
            $user->delete();
            return redirect()
                ->route("user")
                ->with("success", "Data user Berhasil Di Hapus !");
        } catch (\Throwable $e) {
            return redirect()
                ->route("user")
                ->with("error", $e);
        }
    }
}
