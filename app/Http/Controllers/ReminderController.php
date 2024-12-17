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
        $utangPiutang = UtangPiutang::find($id);

        $userid = Auth::check() ? Auth::id() : null;
        $reminder = new Reminder();
        $reminder->userID = $userid;
        $reminder->reminderName = $utangPiutang->deskripsi;
        $reminder->reminderDeadline = $utangPiutang->batasWaktu;
        $reminder->reminderDescription = $utangPiutang->nominal;

        $reminder->save();

        return redirect()->route('reminder');
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

        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'required|string|max:255',
        ]);
        
        $reminder = new Reminder();
        $reminder->userID = $userid;
        $reminder->reminderName = $request->judul;
        $reminder->reminderDeadline = $request->deadline;
        $reminder->reminderDescription = $request->deskripsi;

        $reminder->save();

        return redirect()->route('reminder');
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $reminder = Reminder::find($id);
        $reminder->reminderName = $request->judul;
        $reminder->reminderDeadline = $request->deadline;
        $reminder->reminderDescription = $request->deskripsi;

        $reminder->save();

        return redirect()->route('reminder');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Reminder::find($id)->delete();
        return redirect()->route('reminder');
    }
}
