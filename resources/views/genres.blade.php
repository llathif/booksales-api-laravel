<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Genres</title>
</head>
<body>
    <h1>Daftar Genre Buku</h1>
    <p>Berikut adalah daftar genre yang tersedia:</p>

    <ul>
        @foreach ($genres as $item)
            <li>{{ $item['name'] }}</li>
        @endforeach
    </ul>
</body>
</html>