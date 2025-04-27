<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryKiloan;
use App\Models\PriceListKiloan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class PriceListKiloanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category' => 'required|exists:categories_kiloan,id',
            'heavy'   => 'required|numeric|min:0.1',
            'price'    => 'required|numeric|min:0',
        ]);

        PriceListKiloan::create([
            'category_kiloan_id' => $request->category,
            'heavy'              => $request->heavy,
            'price'              => $request->price,
        ]);

        return redirect()->route('admin.price-lists.index')->with('success', 'Harga kiloan berhasil ditambahkan!');
    }
    public function update(PriceListKiloan $priceListKiloan, Request $request): RedirectResponse
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $priceListKiloan->price = $request->price;
        $priceListKiloan->save();

        return redirect()->route('admin.price-lists.index')->with('success', 'Harga kiloan berhasil diperbarui!');
    }

    public function show(PriceListKiloan $priceListKiloan): JsonResponse
    {
        return response()->json($priceListKiloan);
    }
}
