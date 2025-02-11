<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UtangPiutang;
use App\Models\Reminder;

class UtangPiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(?string $type = null)
    {
        $userid = Auth::check() ? Auth::id() : null;

        $query = DB::table('utang_piutangs')->select(
            'utang_piutangs.id as utang_id',
            'utang_piutangs.deskripsi as deskripsi',
            'utang_piutangs.batasWaktu as batasWaktu',
            'utang_piutangs.nominal as nominal',
            'utang_piutangs.jenis as jenis',
            'utang_piutangs.reminderID as reminderID'
        )->where('userID', '=', $userid);
    
        if ($type && $type !== 'all') {
            $query->where('jenis', '=', $type);
        }
    
        $result = $query->get();

        return view('utangPiutang', [
            'utangPiutang' => $result,
            'selectedType' => $type
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

        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|max:255',
            'batasWaktu' => 'required|date',
            'nominal' => 'required',
            'jenis' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataInput' => $request->all()
            ]);
        }

        DB::table('utang_piutangs')->insert([
            'userID' => $userid,
            'deskripsi' => $request->deskripsi,
            'batasWaktu' => $request->batasWaktu,
            'nominal' => $request->nominal,
            'jenis' => $request->jenis,
            'reminderID' => NULL,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Utang/piutang berhasil ditambahkan!');
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
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|max:255',
            'batasWaktu' => 'required|date',
            'nominal' => 'required|numeric',
            'jenis' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataUpdate' => array_merge($request->all(), ['id' => $id])
            ]);
        }

        $utangPiutang = UtangPiutang::find($id);
        $utangPiutang->update([
            'deskripsi' => $request->deskripsi,
            'batasWaktu' => $request->batasWaktu,
            'nominal' => $request->nominal,
            'jenis' => $request->jenis
        ]);

        $reminder = Reminder::find($utangPiutang->reminderID);
        if ($reminder) {
            $reminder->update([
                'reminderName' => $request->deskripsi,
                'reminderDeadline' => $request->batasWaktu,
                'reminderDescription' => $request->nominal
            ]);
        }

        return redirect()->back()->with('success', 'Utang/piutang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $utangPiutang = UtangPiutang::find($id);

        $reminder = Reminder::find($utangPiutang->reminderID);
        if ($reminder) {
            $reminder->delete();
        }

        $utangPiutang->delete();

        return redirect()->back()->with('success', 'Utang/piutang berhasil di hapus!');
    }
}