<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import the DB facade
use App\Models\Kolam;
use Validator;

class KolamController extends Controller
{
    public function index()
    {
        $kolam = Kolam::all();
        $totalLuas = Kolam::sum("luas");
        $totalHidup = Kolam::sum("jumlah_ikan_hidup");
        $totalMati = Kolam::sum("jumlah_ikan_mati");
        return view(
            "admin.kolam.index",
            compact(["kolam", "totalLuas", "totalHidup", "totalMati"])
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            "nama_kolam" => "required|string|max:255",
            "luas" => "required|numeric",
            "tanggal_dibersihkan" => "required|date",
            "tanggal_pakan" => "required|date",
            "tanggal_panen" => "required|date",
            "jumlah_ikan_hidup" => "required|integer",
            "jumlah_ikan_mati" => "required|integer",
        ]);

        // Create a new kolam with the validated data
        $kolam = Kolam::create($validatedData);

        // Redirect back to the index page with a success message
        return redirect()
            ->route("admin.kolam.index")
            ->with("success", "Kolam berhasil disimpan.");
    }
    public function destroy($id)
    {
        // Temukan kolam berdasarkan ID
        $kolam = Kolam::find($id);

        if (!$kolam) {
            return response()->json(["message" => "Kolam not found."], 404);
        }

        // Hapus kolam dari database
        $kolam->delete();

        // return response()->json(["message" => "Kolam deleted successfully."]);
        return redirect()
            ->route("admin.kolam.index")
            ->with("success", "Kolam berhasil dihapus.");
    }
    public function update(Request $request, $id)
    {
        // Temukan kolam berdasarkan ID
        $kolam = Kolam::find($id);
        if (!$kolam) {
            return response()->json(["message" => "Kolam not found."], 404);
        }

        // Validasi data input
        $validatedData = $request->validate([
            "nama_kolam" => "required|string|max:255",
            "luas" => "required|numeric",
            "tanggal_dibersihkan" => "required|date",
            "tanggal_pakan" => "required|date",
            "tanggal_panen" => "required|date",
            "jumlah_ikan_hidup" => "required|integer",
            "jumlah_ikan_mati" => "required|integer",
        ]);

        // Update kolam dengan data yang divalidasi
        $kolam->update($validatedData);

        // Beri respons sukses
        return redirect()
            ->route("admin.kolam.index")
            ->with("success", "Kolam berhasil disimpan.");
    }

    public function detail(Request $request)
    {
        $data = Kolam::where("id", $request->id)->first();
        return response()->json([
            "data" => $data,
        ]);
    }
}
