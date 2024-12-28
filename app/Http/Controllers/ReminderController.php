<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reminder;
use App\Models\UtangPiutang;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function addUtangtoReminder(string $id){
        $userid = Auth::check() ? Auth::id() : null;

        $utangPiutang = UtangPiutang::find($id);

        $reminder = new Reminder();
        $reminder->userID = $userid;
        $reminder->reminderName = $utangPiutang->deskripsi;
        $reminder->reminderDeadline = $utangPiutang->batasWaktu;
        $reminder->reminderDescription = $utangPiutang->nominal;

        $reminder->save();

        $utangPiutang->reminderID = $reminder->id;
        $utangPiutang->save();

        return redirect()->route('reminder')->with('success', 'Pengingat utang/piutang berhasil ditambahkan!');
    }

    public function index()
    {
        $userid = Auth::check() ? Auth::id() : null;
        $reminders = DB::table('reminders')->select('*')->where('reminders.userID', '=', $userid)->get();
        return view('reminder', ['reminders' => $reminders]);
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

        $validator = \Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataInput' => $request->all()
            ]);
        }
        
        $reminder = new Reminder();
        $reminder->userID = $userid;
        $reminder->reminderName = $request->judul;
        $reminder->reminderDeadline = $request->deadline;
        $reminder->reminderDescription = $request->deskripsi;
        $reminder->save();

        return redirect()->route('reminder')->with('success', 'Pengingat berhasil ditambahkan!');
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
        $validator = \Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataUpdate' => array_merge($request->all(), ['id' => $id])
            ]);
        }

        $utangPiutang = UtangPiutang::where('reminderID', $id)->first();
        if ($utangPiutang) {
            $validator = \Validator::make($request->only('deskripsi'), [
                'deskripsi' => 'required|numeric|max:999999999999',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with([
                    'error' => 'Input kolom Deskripsi harus berupa numeric dengan maks 12 digit angka untuk pengingat ini karena berkaitan dengan utang piutang!',
                    'errorDataUpdate' => array_merge($request->all(), ['id' => $id])
                ]);
            }

            $utangPiutang->update([
                'deskripsi' => $request->judul,
                'batasWaktu' => $request->deadline,
                'nominal' => $request->deskripsi
            ]);
        }

        $reminder = Reminder::find($id);
        $reminder->update([
            'reminderName' => $request->judul,
            'reminderDeadline' => $request->deadline,
            'reminderDescription' => $request->deskripsi
        ]);

        return redirect()->route('reminder')->with('success', 'Pengingat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $utangPiutang = UtangPiutang::where('reminderID', $id)->first();
        if ($utangPiutang) {
            $utangPiutang->update([
                'reminderID' => NULL
            ]);
        }

        Reminder::find($id)->delete();
        
        return redirect()->route('reminder')->with('success', 'Pengingat berhasil di hapus!');
    }
}