<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;

class JournalController extends Controller
{
    public function index(){
        $entries = JournalEntry::with('lines')->latest()->paginate(10);
        return view('journal.index', compact('entries'));
    }

    public function show(JournalEntry $journalEntry){
        $journalEntry->load('lines');
        return view('journal.show', compact('journalEntry'));
    }
}
