<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Keuangan;

class PerlengkapanController extends Controller
{
    /**
     * Menampilkan semua perlengkapan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perlengkapan = Tool::all();
        $data = Tool::select("jenis_transaksi", "total")->get();
        $total = 0;
        foreach ($data as $value) {
            if ($value->jenis_transaksi == "Pemasukan") {
                $total = $total + $value->total;
            } else {
                $total = $total - $value->total;
            }
        }
        return view(
            "admin.perlengkapan.index",
            compact(["perlengkapan", "total"])
        );
    }

    /**
     * Menampilkan formulir untuk membuat perlengkapan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.perlengkapan.create");
    }

    /**
     * Menyimpan perlengkapan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_tools" => "required",
            "jumlah" => "required|numeric",
            "total" => "required|numeric",
        ]);

        $tool = Tool::create($validatedData);

        $keuangan = new Keuangan();
        $keuangan->tool_id = $tool->id;
        $keuangan->save();

        return redirect()
            ->route("tools")
            ->with("success", "Perlengkapan Berhasil Disimpan !");
    }

    /**
     * Menampilkan detail perlengkapan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perlengkapan = Tool::findOrFail($id);
        return view("admin.perlengkapan.show", compact("perlengkapan"));
    }

    public function detail(Request $request)
    {
        $data = Tool::where("id", $request->id)->first();
        return response()->json([
            "data" => $data,
        ]);
    }

    /**
     * Menampilkan formulir untuk mengedit perlengkapan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perlengkapan = Tool::findOrFail($id);
        return view("admin.perlengkapan.edit", compact("perlengkapan"));
    }

    /**
     * Memperbarui perlengkapan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $perlengkapan = Tool::findOrFail($request->id);

        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_tools" => "required",
            "jumlah" => "required|numeric",
            "total" => "required|numeric",
            "keterangan" => "nullable|string|max:255",
        ]);

        $perlengkapan->update($validatedData);

        return redirect()
            ->route("tools")
            ->with("success", "Data Pakan Berhasil Diupdate !");
    }

    /**
     * Menghapus data Pakan dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $perlengkapan = Tool::findOrFail($id);
            $perlengkapan->delete();
            $keuangan = Keuangan::where("tool_id", $id);
            $keuangan->delete();
            return redirect()
                ->route("tools")
                ->with("success", "Transaksi perlengkapan berhasil dihapus.");
        } catch (\Throwable $e) {
            return redirect()
                ->route("tools")
                ->with("error", $e);
        }
    }
}
