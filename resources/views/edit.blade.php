<!DOCTYPE html>
<html>
<head>
    <title>Edit Pet</title>
</head>
<body>
    <h1>Edit Pet</h1>
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
    @if(isset($pet))
    <p>ID: {{ $pet['id'] ?? 'none'}}</p>
    <form method="POST" action="{{ route('pet.update', ['id' => $pet['id']]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $pet['name'] }}">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="available" {{ $pet['status'] === 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ $pet['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ $pet['status'] === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photoUrls">photoUrls:</label>
            <input type="text" class="form-control" id="photoUrls" name="photoUrls" value="{{ $pet['photoUrls'][0] }}">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ $pet['category']['name'] ?? '' }}">
        </div>
        <div class="form-group">
            <label for="tags">Tags:</label>
            <input type="text" class="form-control" id="tags" name="tags" value="{{ $pet['tags'][0]['name'] ?? '' }}">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endif

</body>
</html>
