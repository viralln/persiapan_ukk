<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarang = BarangKeluar::with('barang')->latest()->paginate(10);

        return view('barangkeluar.index', compact('rsetBarang'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $abarang = Barang::all();
        return view('barangkeluar.create',compact('abarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'tgl_keluar'          => 'required',
            'qty_keluar'          => 'required',
            'barang_id'   => 'required',

        ]);

        //create post
        BarangKeluar::create([
            'tgl_keluar'             => $request->tgl_keluar,
            'qty_keluar'             => $request->qty_keluar,
            'barang_id'      => $request->barang_id,
        ]);

        //redirect to index
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = BarangKeluar::find($id);

        //return $rsetBarang;

        //return view
        return view('barangkeluar.show', compact('rsetBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $abarang = Barang::all();
    $rsetBarang = BarangKeluar::find($id);
    $selectedBarang = Barang::find($rsetBarang->barang_id);

    return view('barangkeluar.edit', compact('rsetBarang', 'abarang', 'selectedBarang'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'tgl_keluar'        => 'required',
            'qty_keluar'        => 'required',
            'barang_id' => 'required',
        ]);

        $rsetBarang = BarangKeluar::find($id);

            //update post without image
            $rsetBarang->update([
                'tgl_keluar'          => $request->tgl_keluar,
                'qty_keluar'          => $request->qty_keluar,
                'barang_id'   => $request->barang_id,
            ]);

        // Redirect to the index page with a success message
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarang = BarangKeluar::find($id);

        //delete post
        $rsetBarang->delete();

        //redirect to index
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}