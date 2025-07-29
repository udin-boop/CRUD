<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Brand;


class BrandController extends Controller
{
public function index(Request $request)
{
    $query = Brand::query();

    if ($request->filled('nama')) {
        $query->where('nama', 'like', '%' . $request->nama . '%');
    }

    if ($request->filled('negara_asal')) {
        $query->where('negara_asal', 'like', '%' . $request->negara_asal . '%');
    }

    // FILTER TANGGAL
    if ($request->filled('tanggal_range')) {
        $range = $request->tanggal_range;

        switch ($range) {
            case 'today':
                $query->whereDate('tanggal_berdiri', today());
                break;

            case 'yesterday':
                $query->whereDate('tanggal_berdiri', today()->subDay());
                break;

            case 'last_week':
                $query->whereBetween('tanggal_berdiri', [now()->subWeek(), now()]);
                break;

            case 'last_30_days':
                $query->whereBetween('tanggal_berdiri', [now()->subDays(30), now()]);
                break;

            case 'last_month':
    $start = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
    $end = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
    $query->whereBetween('tanggal_berdiri', [$start, $end]);
    break;

case 'last_year':
    $start = Carbon::now()->subYear()->startOfYear()->startOfDay();
    $end = Carbon::now()->subYear()->endOfYear()->endOfDay();
    $query->whereBetween('tanggal_berdiri', [$start, $end]);
    break;

        case 'custom':
    if ($request->filled('custom_date_range')) {
        $dates = explode(' - ', $request->custom_date_range);
        if (count($dates) == 2) {
            $start = Carbon::parse(trim($dates[0]))->startOfDay();
            $end = Carbon::parse(trim($dates[1]))->endOfDay();
            $query->whereBetween('tanggal_berdiri', [$start, $end]);
        }
    }
    break;



        }
    }

    // SORTING
    if ($request->filled('sort') && $request->filled('order')) {
        $query->orderBy($request->sort, $request->order);
    } else {
        $query->latest();
    }

    $brands = $query->paginate(10);

foreach ($brands as $brand) {
    $brand->formatted_tanggal = \Carbon\Carbon::parse($brand->tanggal_berdiri)->format('Y-m-d');
}

    return view('brand.index', compact('brands'));
}







    public function create()
    {
        return view('brand.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'negara_asal' => 'required|string|max:255',
            'tahun_berdiri' => 'required|integer',
            'tanggal_berdiri' => 'nullable|date',
        ]);

        Brand::create($validated);

        return redirect()->route('brand.index')->with('success', 'Brand berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'negara_asal' => 'required|string|max:255',
            'tahun_berdiri' => 'required|integer|min:1900',
            'tanggal_berdiri' => 'nullable|date',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update([
            'nama' => $request->nama,
            'negara_asal' => $request->negara_asal,
            'tahun_berdiri' => $request->tahun_berdiri,
            'tanggal_berdiri' => $request->tanggal_berdiri,
        ]);

        return redirect()->route('brand.index')->with('success', 'Brand berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand berhasil dihapus.');
    }
}
