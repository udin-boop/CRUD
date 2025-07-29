<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($brand) ? 'Edit' : 'Tambah' }} Brand</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            {{ isset($brand) ? '✏️ Edit Brand' : '➕ Tambah Brand' }}
        </h1>

        {{-- Validasi error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ isset($brand) ? route('brand.update', $brand->id) : route('brand.store') }}"
            method="POST"
            class="space-y-5"
        >
            @csrf
            @if (isset($brand))
                @method('PUT')
            @endif

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Brand</label>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $brand->nama ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Negara Asal</label>
                <input
                    type="text"
                    name="negara_asal"
                    value="{{ old('negara_asal', $brand->negara_asal ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Tahun Berdiri</label>
                <input
                    type="number"
                    name="tahun_berdiri"
                    value="{{ old('tahun_berdiri', $brand->tahun_berdiri ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Berdiri</label>
                <input
                    type="date"
                    name="tanggal_berdiri"
                    value="{{ old('tanggal_berdiri', isset($brand) ? $brand->tanggal_berdiri : '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('brand.index') }}" class="text-gray-600 hover:underline">
                    ❌ Batal
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                >
                    💾 {{ isset($brand) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
