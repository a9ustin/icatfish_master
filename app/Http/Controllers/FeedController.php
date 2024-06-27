<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use App\Models\Keuangan;

class FeedController extends Controller
{
    /**
     * Menampilkan semua pakan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pakan = Feed::all();
        $data = Feed::select("jenis_transaksi", "total")->get();
        $total = 0;
        foreach ($data as $value) {
            if ($value->jenis_transaksi == "Pemasukan") {
                $total = $total + $value->total;
            } else {
                $total = $total - $value->total;
            }
        }
        return view("admin.feed.index", compact(["pakan", "total"]));
    }

    /**
     * Menampilkan formulir untuk membuat pakan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.feed.create");
    }

    /**
     * Menyimpan pakan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_pakan" => "required",
            "jumlah_pakan" => "required|numeric",
            "total" => "required|numeric",
        ]);

        $feed = Feed::create($validatedData);

        $keuangan = new Keuangan();
        $keuangan->feed_id = $feed->id;
        $keuangan->save();

        return redirect()
            ->route("pakan")
            ->with("success", "Transaksi Pakan Berhasil Disimpan !");
    }

    /**
     * Menampilkan detail pakan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pakan = Feed::findOrFail($id);
        return view("admin.feed.show", compact("pakan"));
    }

    public function detail(Request $request)
    {
        $data = Feed::where("id", $request->id)->first();
        return response()->json([
            "data" => $data,
        ]);
    }

    /**
     * Menampilkan formulir untuk mengedit pakan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pakan = Feed::findOrFail($id);
        return view("admin.feed.edit", compact("pakan"));
    }

    /**
     * Memperbarui pakan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pakan = Feed::findOrFail($request->id);

        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_pakan" => "required",
            "jumlah_pakan" => "required|numeric",
            "total" => "required|numeric",
            "keterangan" => "nullable|string|max:255",
        ]);

        $pakan->update($validatedData);

        return redirect()
            ->route("pakan")
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
            $pakan = Feed::findOrFail($id);
            $pakan->delete();
            $keuangan = Keuangan::where("feed_id", $id);
            $keuangan->delete();
            return redirect()
                ->route("pakan")
                ->with("success", "Transaksi pakan berhasil dihapus.");
        } catch (\Throwable $e) {
            return redirect()
                ->route("pakan")
                ->with("error", $e);
        }
    }
}
