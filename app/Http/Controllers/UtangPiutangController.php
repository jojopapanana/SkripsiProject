<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UtangPiutang;

class UtangPiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userid = Auth::check() ? Auth::id() : null;
        $utangPiutang = DB::table('utang_piutangs')
        ->select(
            'utang_piutangs.id as utang_id',
            'utang_piutangs.deskripsi as deskripsi',
            'utang_piutangs.batasWaktu as batasWaktu',
            'utang_piutangs.nominal as nominal',
            'utang_piutangs.jenis as jenis',
        )->where('userID', '=', $userid)
        ->get();

        $transaction = DB::table('utang_piutangs')->select('id')->latest()->first();
        $transactionID = $transaction ? $transaction->id + 1 : 1;
        
        return view('utangPiutang', [
            'utangPiutang' => $utangPiutang,
            'transactionID' => $transactionID
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
        $userid = Auth::check() ? Auth::id() : null;
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'batasWaktu' => 'required|date',
            'nominal' => 'required',
            'jenis' => 'required|string',
        ]);

        DB::table('utang_piutangs')->insert([
            'userID' => $userid,
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
    public function update(Request $request, string $id)
    {
            $utang = UtangPiutang::find($id);
    
            if ($utang) {
                
                // $request->validate([
                //     'deskripsi' => 'required|string|max:255',
                //     'batasWaktu' => 'required|date',
                //     'nominal' => 'required|numeric',
                //     'jenis' => 'required|string',
                // ]);
                
                $utang->update([
                    'deskripsi' => $request->deskripsi,
                    'batasWaktu' => $request->batasWaktu,
                    'nominal' => $request->nominal,
                    'jenis' => $request->jenis
                ]);
    
                return redirect()->back()->with('success', 'Utang/Piutang berhasil diperbarui!');
            }
    
            return redirect()->back()->with('error', 'Utang/Piutang tidak ditemukan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $utangPiutang = UtangPiutang::find($id);
    
            if ($utangPiutang) {
                $utangPiutang->delete();
                return redirect()->back()->with('success', 'SUCCESS : Berhasil Dihapus');
            }
    
            return redirect()->back()->with('error', 'ERROR : Utang/Piutang Tidak Ditemukan');
        }
    }
}
