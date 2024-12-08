<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request){
        $notes = Note::all();
        return response()->json(['success'=> true, 'notesList' => $notes], 200);
    }
    // public function index(){
    //     $userId = session('user_id');
    //     $notes = Note::where('user_id', $userId)->get();
    //     return response()->json(['success' => true, 'notesList' => $notes], 200);
    // }
    public function createNote(Request $request){
        try{
            $validatedData = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'nullable|mimes:png,jpg|max:2048',
            ]);
            $newNote = new Note;
            $newNote->title = $request->title;
            $newNote->content = $request->content;
            $fileName = null;
            if ($request->hasFile('image')) {
                $filePath = public_path('storage/images');
                $file = $request->file('image');
                $fileName = $request->title . '-' . $file->getClientOriginalName();
                $file->move($filePath, $fileName);
                $fileName = 'storage/images/' . $fileName;
                $newNote->image_url = asset($fileName);
            }
            // $newNote->updated_at = now();
            // $newNote->created_at = now();
            $newNote->save();
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()],500);
        }
        return response()->json(['success'=> true,'data'=> $newNote],201);
    }
    public function updateNote(Request $request){
        $updatedNote = Note::find($request->id);
        $updatedNote->title = $request->title;
        $updatedNote->content = $request->content;
        $updatedNote->image = $request->image;
        $updatedNote->save();
        return response()->json(['success'=> true,'data'=> $updatedNote],200);
    }
    public function deleteNote($id){
        $deletedNote = Note::find($id);
        $deletedNote->delete();
        return response()->json(['success'=> true,'message'=> "Note {$id} has been deleted"],200);
    }
}