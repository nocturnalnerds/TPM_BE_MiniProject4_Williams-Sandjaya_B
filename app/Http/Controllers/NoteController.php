<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return view('notes.index', compact('notes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Note::create($request->all());
        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }
    public function editView(Request $request){
        $note = Note::findOrFail($request->id);
        return view('notes.edit', compact('note'));
    }
    
    // public function delete($id){
    //     $note = Note::findOrFail($id);
    //     $note->delete();
    //     return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    // }
}