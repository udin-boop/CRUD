<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>📱 Daftar Brand Handphone</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-10 space-y-10">
  <!-- Header -->
  <div class="flex justify-between items-center border-b pb-4">
    <div class="flex items-center gap-3">
      <img src="https://img.icons8.com/color/48/000000/android.png" alt="Logo" class="w-10 h-10">
      <h1 class="text-3xl font-bold">Brand Handphone</h1>
    </div>
    <a href="{{ route('brand.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow hover:bg-indigo-700 transition">
      ➕ Tambah
    </a>
  </div>

  <!-- Filter -->
  <form method="GET" action="{{ route('brand.index') }}" class="bg-white rounded-xl shadow-md p-6 space-y-6">
    <div class="grid md:grid-cols-3 gap-6">
      <div>
        <label class="text-sm font-semibold block mb-1">🔍 Nama Brand</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-300">
      </div>

      <div class="md:col-span-2">
        <label class="text-sm font-semibold block mb-1">📅 Tanggal</label>
        <div class="flex gap-2 flex-wrap md:flex-nowrap">
          <select name="tanggal_range" id="tanggal_range" class="border px-4 py-2 rounded-lg text-sm w-full md:w-1/3">
            <option value="">-- Semua --</option>
            <option value="today" {{ request('tanggal_range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="yesterday" {{ request('tanggal_range') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
            <option value="last_week" {{ request('tanggal_range') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
            <option value="last_30_days" {{ request('tanggal_range') == 'last_30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
            <option value="last_month" {{ request('tanggal_range') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
            <option value="last_year" {{ request('tanggal_range') == 'last_year' ? 'selected' : '' }}>Tahun Lalu</option>
            <option value="custom" {{ request('tanggal_range') == 'custom' ? 'selected' : '' }}>Custom Range</option>
          </select>

          <input type="text" id="date_range" name="date_range"
                 class="hidden w-full md:w-2/3 max-w-xs border border-gray-300 rounded-lg px-4 py-2 text-sm"
                 placeholder="YYYY-MM-DD - YYYY-MM-DD"
                 value="{{ request('date_range') }}">
        </div>
      </div>
    </div>

    <div class="flex gap-3 pt-2">
      <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 text-sm">🔍 Filter</button>
      <a href="{{ route('brand.index') }}" class="bg-gray-200 px-5 py-2.5 rounded-lg hover:bg-gray-300 text-sm">♻️ Reset</a>
    </div>
  </form>

  <!-- Tabel -->
  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="min-w-full text-sm text-left">
      <thead class="bg-indigo-100 text-gray-800">
        <tr>
          <th class="px-6 py-3">#</th>
          <th class="px-6 py-3">📛 Nama</th>
          <th class="px-6 py-3">🌍 Negara</th>
          <th class="px-6 py-3">📅 Berdiri</th>
          <th class="px-6 py-3">⚙️ Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse ($brands as $brand)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-3">{{ $loop->iteration }}</td>
            <td class="px-6 py-3 font-medium">{{ $brand->nama }}</td>
            <td class="px-6 py-3">{{ $brand->negara_asal }}</td>
            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($brand->tanggal_berdiri)->format('Y-m-d') }}</td>
            <td class="px-6 py-3 space-x-2">
              <a href="{{ route('brand.edit', $brand) }}" class="text-indigo-600 hover:underline text-sm">✏️ Edit</a>
              <form action="{{ route('brand.destroy', $brand) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline text-sm">🗑️ Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-gray-500 py-6">Tidak ada data ditemukan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Flatpickr -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const rangeSelect = document.getElementById('tanggal_range');
    const rangeInput = document.getElementById('date_range');

    const fp = flatpickr(rangeInput, {
      mode: 'range',
      dateFormat: 'Y-m-d',
      allowInput: true,
      clickOpens: false,
      showMonths: 2,
    });

    function togglePicker() {
      const val = rangeSelect.value;
      const visibleRanges = ['custom', 'last_month', 'last_year'];
      const today = new Date();
      let start = null;
      let end = null;

      if (val === 'last_month') {
        end = new Date(today.getFullYear(), today.getMonth(), 0);
        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
      } else if (val === 'last_year') {
        end = new Date(today.getFullYear() - 1, 11, 31);
        start = new Date(today.getFullYear() - 1, 0, 1);
      }

      if (visibleRanges.includes(val)) {
        rangeInput.classList.remove('hidden');
        fp.set('clickOpens', true);

        if (start && end) {
          fp.setDate([start, end], true);
        }
      } else {
        rangeInput.classList.add('hidden');
        fp.set('clickOpens', false);
      }
    }

    rangeSelect.addEventListener('change', togglePicker);
    togglePicker();
  });
</script>

</body>
</html>
