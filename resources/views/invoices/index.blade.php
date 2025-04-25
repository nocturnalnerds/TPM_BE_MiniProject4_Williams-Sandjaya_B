<!DOCTYPE html>
<html>
<head>
    <title>Your Invoices</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #2d3748;
                padding: 12px 24px;
                color: #fff;
            }
    
            .navbar-left .navbar-brand {
                font-weight: bold;
                font-size: 20px;
            }
    
            .navbar-right {
                display: flex;
                align-items: center;
                gap: 16px;
            }
    
            .nav-storage, .nav-invoice {
                color: #fff;
                text-decoration: none;
                padding: 6px 12px;
                transition: background-color 0.3s;
            }
    
            .nav-storage:hover, .nav-invoice:hover {
                background-color: #4a5568;
                border-radius: 4px;
            }
    
            .nav-logout-form {
                margin: 0;
            }
    
            .nav-logout-btn {
                background: none;
                border: none;
                color: #fff;
                cursor: pointer;
                padding: 6px 12px;
                font: inherit;
                transition: background-color 0.3s;
            }
    
            .nav-logout-btn:hover {
                background-color: #e53e3e;
                border-radius: 4px;
            }
    
            .badge-light {
                background-color: #edf2f7;
                color: #2d3748;
                border-radius: 12px;
                padding: 2px 8px;
                font-size: 12px;
                margin-left: 4px;
            }
    </style>
</head>

<?php
    $role = session('role');
    $userId = session('userId');
    $cart = session()->get('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
?>

<body>
    <div class="navbar">
        <div class="navbar-left">
            <span class="navbar-brand">Chipi Chapa Storage Management</span>
        </div>
        <div class="navbar-right">
            <a href="{{ route('storage.index') }}" class="nav-storage">Storage</a>
            @if($role === 'user')
                <a href="{{ route('cart.view') }}" class="nav-invoice">
                    Cart 
                    <span class="badge badge-light">{{ $cartCount }}</span>
                </a>
                <a href="{{ route('invoices.index') }}" class="nav-invoice">
                    Invoices
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                @csrf
                <button type="submit" class="nav-logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container mt-4">
        <h2>Your Invoices</h2>

        @if ($invoices->count() > 0)
            @foreach ($invoices as $invoice)
                <div class="invoice-card">
                    <h5>Invoice #{{ $invoice->id }}</h5>
                    <p><strong>Date:</strong> {{ $invoice->created_at->format('Y-m-d H:i') }}</p>
            
                    @if($role === 'admin')
                        <p><strong>User:</strong> {{ $invoice->user->name ?? 'Unknown User' }} (ID: {{ $invoice->user_id }})</p>
                    @endif
            
                    <p><strong>Total:</strong> ${{ $invoice->total_price }}</p>
            
                    <table class="table table-sm mt-3">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ $item->price }}</td>
                                    <td>${{ $item->price * $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <p>You have no invoices yet.</p>
        @endif
    </div>
</body>
</html>
