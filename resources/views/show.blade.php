<!DOCTYPE html>
<html>

<head>
    <title>Show Pet</title>
</head>

<body>
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

    <h1>Details of Pet</h1>
    <p>ID: {{ $pet['id'] ?? 'none'}}</p>
    <p>Name: {{ $pet['name'] ?? 'none'}}</p>

    <p>Status: {{$pet['status'] ?? 'none'}}</p>
    @if(isset($pet['photoUrls']))
    <h2>Photos:</h2>
    <ul>
        @foreach($pet['photoUrls'] as $photoUrl)
        <li>{{ $photoUrl }}</li>
        @endforeach
    </ul>
    @endif
    @if(isset($pet['category']))
    <h2>Category:</h2>
    <p>ID: {{ $pet['category']['id'] }}</p>
    <p>Name: {{ $pet['category']['name'] }}</p>
    @endif

    @if(isset($pet['tags']))
    <h2>Tags:</h2>
    <ul>
        @foreach($pet['tags'] as $tag)
        <li>ID: {{ $tag['id'] }}, Name: {{ $tag['name'] }}</li>
        @endforeach
    </ul>
    @endif

    <a href="{{ route('pet.edit', ['id' => $pet['id']]) }}" class="btn btn-primary">Edit</a>


    <form action="{{ route('pet.destroy', ['id' => $pet['id']]) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
    </form>
</body>

</html>