<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\Product; 

class CartController extends Controller
{
    public function addToCart(Request $request, $id){
        $cart = session()->get('cart', []);
        $product = Product::findOrFail($id);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->amount) {
                return back()->with('error', 'Adding this quantity exceeds available stock.');
            }
            $cart[$id]['quantity']++;
        } else {
            if ($product->amount < 1) {
                return back()->with('error', 'Product is out of stock.');
            }
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "imageUrl" => $product->imageUrl
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
    
    public function remove($id){
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.view')->with('success', 'Item removed from cart.');
    }
    public function update(Request $request, $id){
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            $requestedQuantity = max(1, (int) $request->input('quantity', 1));

            if ($requestedQuantity > $product->amount) {
            return redirect()->route('cart.view')->with('error', 'Requested quantity exceeds available stock.');
            }

            $cart[$id]['quantity'] = $requestedQuantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view')->with('success', 'Cart updated.');
    }

    public function checkout(){
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Cart is empty.');
        }

        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);

            if ($item['quantity'] > $product->amount) {
                return redirect()->route('cart.view')->with('error', 'Insufficient stock for ' . $item['name'] . '.');
            }

            $total += $item['price'] * $item['quantity'];
        }

        $invoice = Invoice::create([
            'user_id' => session('userId'),
            'total_price' => $total,
        ]);

        foreach ($cart as $id => $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product = Product::findOrFail($id);
            $product->amount -= $item['quantity'];
            $product->save();
        }

        session()->forget('cart');

        return redirect()->route('cart.view')->with('success', 'Invoice created successfully.');
    }

}
