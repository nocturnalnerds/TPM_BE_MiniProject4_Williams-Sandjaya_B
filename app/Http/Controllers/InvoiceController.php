<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        $role = session('role');
        $userId = session('userId');

        $invoices = $role === 'admin'
            ? Invoice::with(['items', 'user'])->latest()->get()
            : Invoice::with('items')->where('user_id', $userId)->latest()->get();

        return view('invoices.index', compact('invoices', 'role'));
    }
}
