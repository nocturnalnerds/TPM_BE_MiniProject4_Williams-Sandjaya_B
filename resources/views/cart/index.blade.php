<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
<body>

<?php
    $role = session('role');
    $userId = session('userId');
    $cart = session()->get('cart', []);
    $cartCount = count($cart);
?>

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

<div class="container mt-5">
    <h2>Your Cart</h2>
    @if($cart && count($cart) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ $item['price'] }}</td>
                        <td>${{ $subtotal }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="form-inline">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm mr-2" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Total: ${{ $total }}</h4>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Checkout</button>
        </form>
        
    @else
        <p>Your cart is empty.</p>
    @endif
</div>

</body>
</html>
