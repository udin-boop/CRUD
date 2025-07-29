<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Brand</title>
</head>
<body>
    <h1>📖 Detail Brand Handphone</h1>

    <p><strong>Nama:</strong> {{ $brand->nama }}</p>
    <p><strong>Negara Asal:</strong> {{ $brand->negara_asal }}</p>
    <p><strong>Tahun Berdiri:</strong> {{ $brand->tahun_berdiri }}</p>

    <a href="{{ route('brand.index') }}">⬅️ Kembali</a>
</body>
</html>
