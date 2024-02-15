<!DOCTYPE html>
<html>

<head>
    <title>Add New Pet</title>
</head>

<body>
    <h1>Add New Pet</h1>
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
    @endif
    <form method="POST" action="{{ route('pet.store') }}">
        @csrf
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="photoUrls">photoUrls:</label><br>
        <input type="text" id="photoUrls" name="photoUrls"><br>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category"><br>
        <label for="tags">Tag:</label><br>
        <input type="text" id="tags" name="tags"><br>
        <br>
        <button type="submit">Add Pet</button>
    </form>
</body>

</html>