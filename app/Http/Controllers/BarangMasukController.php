<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarang = BarangMasuk::with('barang')->latest()->paginate(10);

        return view('barangmasuk.index', compact('rsetBarang'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $abarang = Barang::all();
        return view('barangmasuk.create',compact('abarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'tgl_masuk'          => 'required',
            'qty_masuk'          => 'required',
            'barang_id'   => 'required',

        ]);

        //create post
        BarangMasuk::create([
            'tgl_masuk'             => $request->tgl_masuk,
            'qty_masuk'             => $request->qty_masuk,
            'barang_id'      => $request->barang_id,
        ]);

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = BarangMasuk::find($id);

        //return $rsetBarang;

        //return view
        return view('barangmasuk.show', compact('rsetBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $abarang = Barang::all();
    $rsetBarang = BarangMasuk::find($id);
    $selectedBarang = Barang::find($rsetBarang->barang_id);

    return view('barangmasuk.edit', compact('rsetBarang', 'abarang', 'selectedBarang'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'tgl_masuk'        => 'required',
            'qty_masuk'        => 'required',
            'barang_id' => 'required',
        ]);

        $rsetBarang = BarangMasuk::find($id);

            //update post without image
            $rsetBarang->update([
                'tgl_masuk'          => $request->tgl_masuk,
                'qty_masuk'          => $request->qty_masuk,
                'barang_id'   => $request->barang_id,
            ]);

        // Redirect to the index page with a success message
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarang = BarangMasuk::find($id);

        //delete post
        $rsetBarang->delete();

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}