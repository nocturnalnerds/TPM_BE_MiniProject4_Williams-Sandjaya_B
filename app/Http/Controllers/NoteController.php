<?php
namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|mimes:png,jpg|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('image')) {
            $filePath = public_path('storage/images');
            $file = $request->file('image');
            $fileName = $request->title . '-' . $file->getClientOriginalName();
            $file->move($filePath, $fileName);
            $fileName = 'storage/images/' . $fileName;
        }
        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $fileName,
        ]);
        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, $id){
        $notes = Note::findOrFail($id);

        $fileName = null;
        if ($request->hasFile('image')) {
            $filePath = public_path('storage/images');
            $file = $request->file('image');
            $fileName = $request->title . '-' . $file->getClientOriginalName();
            $file->move($filePath, $fileName);
            $fileName = 'storage/images/' . $fileName;
        }
        $notes->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $fileName,
        ]);


        return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }
}