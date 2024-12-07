<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UtangPiutang;

class UtangPiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utangPiutangTemp = DB::table('utang_piutangs')
        ->select(
            'utang_piutangs.id as utang_id',
            'utang_piutangs.deskripsi as deskripsi',
            'utang_piutangs.batasWaktu as batasWaktu',
            'utang_piutangs.nominal as nominal',
            'utang_piutangs.jenis as jenis',
        );

    $utangPiutang = $utangPiutangTemp->get();

    return view('utangPiutang', [
        'utangPiutang' => $utangPiutang,
    ]);
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
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'batasWaktu' => 'required|date',
            'nominal' => 'required',
            'jenis' => 'required|string',
        ]);

        DB::table('utang_piutangs')->insert([
            'deskripsi' => $request->deskripsi,
            'batasWaktu' => $request->batasWaktu,
            'nominal' => $request->nominal,
            'jenis' => $request->jenis,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('utangPiutang')->with('success', 'Transaksi berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
        {
            $request->validate([
                'deskripsi' => 'required|string|max:255',
                'batasWaktu' => 'required|string',
                'nominal' => 'required|numeric',
                'jenis' => 'required|string',
            ]);
    
            $utang = UtangPiutang::find($id);
    
            if ($utang) {
                $utang->deskripsi = $request->input('deskripsi');
                $utang->batasWaktu = $request->input('batasWaktu');
                $utang->nominal = $request->input('nominal');
                $utang->jenis = $request->input('jenis');
                $utang->save();
    
                return redirect()->back()->with('success', 'Stok barang berhasil diperbarui!');
            }
    
            return redirect()->back()->with('error', 'Stok barang tidak ditemukan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        {
            $utangPiutang = UtangPiutang::find($id);
    
            if ($utangPiutang) {
                $utangPiutang->delete();
                return redirect()->back()->with('success', 'SUCCESS : Berhasil Dihapus');
            }
    
            return redirect()->back()->with('error', 'ERROR : Utang Tidak Ditemukan');
        }
    }
}
