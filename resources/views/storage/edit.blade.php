<!DOCTYPE html>
<html>

<head>
    <title>Edit Note</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h1>Edit Note</h1>

    <div class="container mt-5">
        <h2>Edit Note</h2>
        <form action="{{ route('storage.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" value="{{ $product->amount }}" required>
            </div>
            @if ($product->imageUrl)
            <div class="image-container">
                <img src="{{ asset("{$product->imageUrl}") }}" alt="Product Image" class="img-fluid images">
            </div>
            @endif
            <div class="form-group">
                <label for="imageUrl">Image:</label>
                <input type="file" class="form-control" id="imageUrl" name="imageUrl">
            </div>
            <div class="form-group">
                <label for="category_id">Category ID:</label>
                <input type="number" class="form-control" id="category_id" name="category_id" value="{{ $product->category_id }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
    </div>
</body>

</html>