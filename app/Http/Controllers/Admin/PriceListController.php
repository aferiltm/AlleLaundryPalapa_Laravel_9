<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\PriceList;
use App\Models\PriceListKiloan;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceListController extends Controller
{
    /**
     * Display price lists view
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function index(): View
    {
        $user = Auth::user();

        $satuan = PriceList::with(['item', 'service'])->where('category_id', 1)->get();
        $kiloan = \App\Models\PriceListKiloan::with('category_kiloan')->where('category_kiloan_id', 2)->get();

        return view('admin.price_lists', [
            'user' => $user,
            'satuan' => $satuan,
            'kiloan' => $kiloan,
            'items' => Item::all(),
            'services' => Service::all(),
            'categories' => Category::all(),
            'categories_Kiloan' => \App\Models\CategoryKiloan::all(),
            'serviceTypes' => ServiceType::all(),
        ]);
    }

    /**
     * Get price list price
     *
     * @param  \App\Models\PriceList $priceList
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PriceList $priceList): JsonResponse
    {
        return response()->json($priceList);
    }

    /**
     * Store new price list to database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'item'     => 'required|exists:items,id',
            'category' => 'required|exists:categories,id',
            'service'  => 'required|exists:services,id',
            'price'    => 'required|numeric|min:0',
        ]);

        if (PriceList::where([
            'item_id'     => $request->item,
            'category_id' => $request->category,
            'service_id'  => $request->service,
        ])->exists()) {
            return back()->with('error', 'Harga sudah tersedia!');
        }

        PriceList::create([
            'item_id'     => $request->item,
            'category_id' => $request->category,
            'service_id'  => $request->service,
            'price'       => $request->price,
        ]);

        return redirect()->route('admin.price-lists.index')->with('success', 'Harga satuan berhasil ditambahkan!');
    }

    /**
     * Change price list price
     *
     * @param  \App\Models\PriceList $priceList
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PriceList $priceList, Request $request): RedirectResponse
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $priceList->price = $request->price;
        $priceList->save();

        return redirect()->route('admin.price-lists.index')->with('success', 'Harga Satuan berhasil diperbarui!');
    }
}
