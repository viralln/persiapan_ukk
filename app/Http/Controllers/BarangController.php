<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarang = Barang::with('kategori')->latest()->paginate(10);

        return view('barang.index', compact('rsetBarang'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akategori = Kategori::all();
        return view('barang.create',compact('akategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'merk'          => 'required',
            'seri'          => 'required',
            'spesifikasi'   => 'required',
            'stok'          => 'required',
            'kategori_id'   => 'required',

        ]);

        //create post
        Barang::create([
            'merk'             => $request->merk,
            'seri'             => $request->seri,
            'spesifikasi'      => $request->spesifikasi,
            'stok'             => $request->stok,
            'kategori_id'      => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);

        //return $rsetBarang;

        //return view
        return view('barang.show', compact('rsetBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $akategori = Kategori::all();
    $rsetBarang = Barang::find($id);
    $selectedKategori = Kategori::find($rsetBarang->kategori_id);

    return view('barang.edit', compact('rsetBarang', 'akategori', 'selectedKategori'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'merk'        => 'required',
            'seri'        => 'required',
            'spesifikasi' => 'required',
            'stok'        => 'required',
            'kategori_id' => 'required',
        ]);

        $rsetBarang = Barang::find($id);

            //update post without image
            $rsetBarang->update([
                'merk'          => $request->merk,
                'seri'          => $request->seri,
                'spesifikasi'   => $request->spesifikasi,
                'stok'          => $request->stok,
                'kategori_id'   => $request->kategori_id,
            ]);

        // Redirect to the index page with a success message
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists()) {
        return redirect()->route('barang.index')->with(['Gagal' => 'Gagal dihapus']);
    } elseif (DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
        return redirect()->route('barang.index')->with(['Gagal' => 'Gagal dihapus']);
    } else {
        $rsetBarang = Barang::find($id);
        $rsetBarang->delete();
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
}