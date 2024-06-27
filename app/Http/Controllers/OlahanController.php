<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Olahan;
use App\Models\Keuangan;

class OlahanController extends Controller
{
    /**
     * Menampilkan semua olahan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $olahan = Olahan::all();
        $data = Olahan::select("jenis_transaksi", "total")->get();
        $total = 0;
        foreach ($data as $value) {
            if ($value->jenis_transaksi == "Pemasukan") {
                $total = $total + $value->total;
            } else {
                $total = $total - $value->total;
            }
        }
        return view("admin.olahan.index", compact(["olahan", "total"]));
    }

    /**
     * Menampilkan formulir untuk membuat olahan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.olahan.create");
    }

    /**
     * Menyimpan olahan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_olahan" => "required",
            "jumlah" => "required|numeric",
            "total" => "required|numeric",
        ]);

        $olahan = Olahan::create($validatedData);

        $keuangan = new Keuangan();
        $keuangan->olahan_id = $olahan->id;
        $keuangan->save();

        return redirect()
            ->route("olahan")
            ->with("success", "Transaksi Olahan Berhasil Disimpan !");
    }

    /**
     * Menampilkan detail olahan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $olahan = Olahan::findOrFail($id);
        return view("admin.olahan.show", compact("olahan"));
    }

    public function detail(Request $request)
    {
        $data = Olahan::where("id", $request->id)->first();
        return response()->json([
            "data" => $data,
        ]);
    }

    /**
     * Menampilkan formulir untuk mengedit olahan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $olahan = Olahan::findOrFail($id);
        return view("admin.olahan.edit", compact("olahan"));
    }

    /**
     * Memperbarui olahan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $olahan = Olahan::findOrFail($request->id);

        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_olahan" => "required",
            "jumlah" => "required|numeric",
            "total" => "required|numeric",
        ]);

        $olahan->update($validatedData);

        return redirect()
            ->route("olahan")
            ->with("success", "Data Olahan Berhasil Diupdate !");
    }

    /**
     * Menghapus data Olahan dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $olahan = Olahan::findOrFail($id);
            $olahan->delete();
            $keuangan = Keuangan::where("olahan_id", $id);
            $keuangan->delete();
            return redirect()
                ->route("olahan")
                ->with("success", "Transaksi olahan berhasil dihapus.");
        } catch (\Throwable $e) {
            return redirect()
                ->route("olahan")
                ->with("error", $e);
        }
    }
}
