<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StorageController extends Controller{
    public function index(){
        $storage = Product::all();
        $categories = Category::all();
        return view('storage.index', compact('storage', 'categories'));
    }

    public function create()
    {
        return view('storage.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'amount' => 'required|integer',
            'imageUrl' => 'nullable|max:2048',
            'category_id' => 'required|integer',
        ]);

        
        $fileName = null;
        if ($request->hasFile('imageUrl')) {
            $filePath = public_path('storage/images');
            if (!file_exists($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $file = $request->file('imageUrl');
            $fileName = $request->name . '-' . $file->getClientOriginalName();
            $file->move($filePath, $fileName);
            $fileName = 'storage/images/' . $fileName;
        }
        
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'amount' => $request->amount,
            'imageUrl' => $fileName,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('storage.index')->with('success', 'Note created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('storage.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $storage = Product::findOrFail($id);

        $fileName = null;
        if ($request->hasFile('image')) {
            $filePath = public_path('storage/images');
            $file = $request->file('image');
            $fileName = $request->title . '-' . $file->getClientOriginalName();
            $file->move($filePath, $fileName);
            $fileName = 'storage/images/' . $fileName;
        }
        $storage->update([
            'name' => $request->name,
            'price' => $request->price,
            'amount' => $request->amount,
            'imageUrl' => $fileName,
            'category_id' => $request->category_id,
        ]);


        return redirect()->route('storage.index')->with('success', 'Note updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('storage.index')->with('success', 'Note deleted successfully.');
    }
}