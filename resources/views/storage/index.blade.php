<!DOCTYPE html>
<html>

<head>
    <title>Notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .note-cont {
            min-height: 100%;
            border: 1px solid #ccc;
            min-height: 200px;
            max-height: 500px;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
        }

        .note {
            overflow-y: scroll;
            max-height: 80px;
            scrollbar-width: none;
        }

        .images {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .image-container {
            max-height: 150px;
            overflow-y: scroll;
        }

        .title-class {
            color: black;
            font-weight: 600;
            word-wrap: break-word;
        }

        .pClass {
            font-size: 12px;
            color: #424242;
            margin-bottom: 10px;
        }

        .special-color1 {
            background: none;
            color: rgb(0, 0, 0);
        }

        .special-color2 {
            background: none;
            color: rgb(255, 0, 0);
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

        .nav-storage {
            color: #fff;
            text-decoration: none;
            padding: 6px 12px;
            transition: background-color 0.3s;
        }

        .nav-storage:hover {
            background-color: #4a5568;
            border-radius: 4px;
        }

        .nav-invoice {
            color: #fff;
            text-decoration: none;
            padding: 6px 12px;
            transition: background-color 0.3s;
        }

        .nav-invoice:hover {
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
    
    @if ($role === 'admin')
        <div class="container mt-5">
            <h2>Create New Product</h2>
            <form action="{{ route('storage.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="imageUrl">Image:</label>
                    <input type="file" class="form-control" id="imageUrl" name="imageUrl">
                </div>
                <select id="category_id" name="category_id" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    @endif
    <div class="container mt-5">
        <div class="row">
            @foreach ($storage as $stuff)
            <div class="col-md-4">
                <div class="note-cont">
                    <h2 class="title-class">{{ $stuff->name }}</h2>
                    <p class="pClass">Price: ${{ $stuff->price }}</p>
                    <p class="pClass">Amount: {{ $stuff->amount }}</p>
                    <p class="pClass">Category: {{ $categories->firstWhere('id', $stuff->category_id)->name ?? 'Unknown' }}</p>
                    @if ($stuff->imageUrl)
                    <div class="image-container">
                        <img src="{{ asset("{$stuff->imageUrl}") }}" alt="Item Image" class="img-fluid images">
                    </div>
                    @endif
                    @if($role === 'admin')
                        <a href="{{ route('storage.edit', $stuff->id) }}" class="btn btn-warning mt-2 special-color1">Edit</a>
                        <form action="{{ route('storage.delete', $stuff->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mt-2 ml-2 special-color2">Delete</button>
                        </form>
                    @else
                        <form action="{{ route('cart.add', $stuff->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success mt-2 special-color1">Add To Cart</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>

</html>