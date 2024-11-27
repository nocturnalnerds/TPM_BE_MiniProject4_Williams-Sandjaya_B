<!DOCTYPE html>
<html>
<head>
    <title>Notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .note-cont {
            min-height: 100%;
            background-color: #ffeb3b;
            min-height: 200px;
            max-height: 200px;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
        }
        .note {
            overflow-y: scroll;
            max-height: 120px;
            scrollbar-width: none;
        }
        .title-class {
            color: black;
            font-weight: 600;
            word-wrap: break-word;
        }
        .info-waktu{
            font-size: 12px;
            color: #424242;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <h1>Williams Notes</h1>

    <div class="container mt-5">
        <h2>Create New Note</h2>
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container mt-5">
        <div class="row">
            @foreach ($notes as $note)
                <div class="col-md-4">
                    <div class="note-cont">
                        <h2 class="title-class">{{ $note->title }}</h2>
                        @if ($note->created_at == $note->updated_at)
                            <p class="info-waktu">Created at: {{ $note->created_at->format('Y-m-d H:i:s') }}</p>
                        @else
                            <p class="info-waktu">Updated at: {{ $note->updated_at->format('Y-m-d H:i:s') }}</p>
                        @endif
                        <div class="note">
                            <p>{{ $note->content }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
