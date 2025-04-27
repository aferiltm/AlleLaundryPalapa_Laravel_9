<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\PriceList;
use App\Models\Service;
use App\Models\CategoryKiloan;
use App\Models\PriceListKiloan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionSessionController extends Controller
{
    /**
     * Method to add new transaction to session
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSatuan(Request $request): RedirectResponse
    {
        $inputData = $request->validate([
            'item'      => ['required'],
            'service'   => ['required'],
            'category'  => ['required'],
            'member-id' => [Rule::requiredIf(!$request->session()->has('memberIdTransaction'))],
            'quantity'  => ['required'],
        ]);

        // Make sure input data member id is not empty
        $inputData['member-id'] = $inputData['member-id'] ?? $request->session()->get('memberIdTransaction');

        // Check if price list exist in database
        if (!PriceList::where([
            'item_id'     => $inputData['item'],
            'category_id' => $inputData['category'],
            'service_id'  => $inputData['service'],
        ])->exists()) {
            return redirect()->route('admin.transactions.create')->with('error', 'Harga tidak ditemukan!');
        }

        // Check if member exist
        $memberNotExist = !User::where('id', $inputData['member-id'])->where('role', Role::Member)->exists();

        if ($memberNotExist) {
            return redirect()->route('admin.transactions.create')->with('error', 'Member tidak ditemukan!');
        }

        // Get price list's price from database
        $price = PriceList::where([
            'item_id'     => $inputData['item'],
            'category_id' => $inputData['category'],
            'service_id'  => $inputData['service']
        ])->firstOrFail()->price;

        // Calculate sub total
        $subTotal = $price * $inputData['quantity'];

        // Get item name, service name, and category name based on id
        $itemName     = Item::where('id', $inputData['item'])->firstOrFail()->name;
        $serviceName  = Service::where('id', $inputData['service'])->firstOrFail()->name;
        $categoryName = Category::where('id', $inputData['category'])->firstOrFail()->name;

        // Get user code and member name
        $phone_number = $request->session()->get('phone_number', '');
        $member_name = $request->session()->get('member_name', '');

        // make new transaction row to store in session
        $rowId = md5($inputData['member-id'] . serialize($inputData['item']) . serialize($inputData['service']) . serialize($inputData['category']));
        $data = [
            $rowId => [
                'itemId'       => $inputData['item'],
                'itemName'     => $itemName,
                'categoryId'   => $inputData['category'],
                'categoryName' => $categoryName,
                'serviceId'    => $inputData['service'],
                'serviceName'  => $serviceName,
                'quantity'     => $inputData['quantity'],
                'subTotal'     => $subTotal,
                'rowId'        => $rowId,
                'phone_number'    => $phone_number,
                'member_name'  => $member_name,
            ]
        ];

        $sessionTransaction = $request->session()->get('transaction', []);
        // Pastikan data ditambahkan dengan benar
        $request->session()->put('transaction', $sessionTransaction);

        // Check if there is a same transaction. If exist, just increment the quantity and subtotal
        $exist = false;
        foreach ($sessionTransaction as &$transaction) {
            if ($transaction['itemId'] == $inputData['item'] &&
                $transaction['categoryId'] == $inputData['category'] &&
                $transaction['serviceId'] == $inputData['service']) {
                $transaction['quantity'] += $inputData['quantity'];
                $transaction['subTotal'] += $subTotal;
                $exist = true;
                break; // Exit the loop once we find the existing transaction
            }
        }

        // If there is no existing transaction, add the new one
        if (!$exist) {
            $sessionTransaction = array_merge($sessionTransaction, $data);
        }

        // Store the updated session transaction
        $request->session()->put('transaction', $sessionTransaction);
        $request->session()->put('memberIdTransaction', $inputData['member-id']);
        return redirect()->route('admin.transactions.create');
    }

    public function storeKiloan(Request $request): RedirectResponse
    {
        $inputData = $request->validate([
            'categoryKiloan' => ['required'],
            'heavy'          => ['required', 'numeric', 'min:1'],
            'member-id'      => [Rule::requiredIf(!$request->session()->has('memberIdTransaction'))],
        ]);

        // Ensure member ID is not empty
        $inputData['member-id'] = $inputData['member-id'] ?? $request->session()->get('memberIdTransaction');

        // Check if member exists
        $memberNotExist = !User ::where('id', $inputData['member-id'])->where('role', Role::Member)->exists();
        if ($memberNotExist) {
            return redirect()->route('admin.transactions.create')->with('error', 'Member tidak ditemukan!');
        }

        // Get price and calculate subtotal
        $priceKiloan = PriceListKiloan::where('category_kiloan_id', $inputData['categoryKiloan'])->firstOrFail()->price;
        $subTotalKiloan = $priceKiloan * $inputData['heavy'];

        // Get category name
        $categoryNameKiloan = CategoryKiloan::where('id', $inputData['categoryKiloan'])->firstOrFail()->name;

        // Create row ID for session
        $rowIdKiloan = md5($inputData['member-id'] . serialize($inputData['categoryKiloan']) . serialize($inputData['heavy']));
        $dataKiloan = [
            $rowIdKiloan => [
                'categoryKiloanId' => $inputData['categoryKiloan'],
                'categoryNameKiloan' => $categoryNameKiloan,
                'heavy' => $inputData['heavy'],
                'subTotalKiloan' => $subTotalKiloan, // Ensure this key is set
                'rowId' => $rowIdKiloan,
            ]
        ];

        $sessionTransaction = $request->session()->get('transaction', []);
        $request->session()->put('transaction', $sessionTransaction);

        // Check if the transaction already exists
        $existKiloan = false;
        foreach ($sessionTransaction as &$transaction) {
            if ($transaction['categoryKiloanId'] == $inputData['categoryKiloan']) {
                $transaction['heavy'] += $inputData['heavy'];
                $transaction['subTotalKiloan'] += $subTotalKiloan; // Ensure this key is updated
                $existKiloan = true;
                break;
            }
        }

        // If it doesn't exist, add the new transaction
        if (!$existKiloan) {
            $sessionTransaction = array_merge($sessionTransaction, $dataKiloan);
        }


        // Store the updated session transaction
        $request->session()->put('transaction', $sessionTransaction);
        $request->session()->put('memberIdTransaction', $inputData['member-id']);

        return redirect()->route('admin.transactions.create');
    }

    /**
     * Method for delete current transaction in session
     *
     * @param  string $rowId
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $rowId, Request $request): RedirectResponse
    {
        $sessionTransaction = $request->session()->get('transaction');
        unset($sessionTransaction[$rowId]);

        // Check if after unset, the transaction session is empty ([]), then destroy all transaction session
        if (blank($sessionTransaction)) {
            $request->session()->forget('transaction');
            $request->session()->forget('memberIdTransaction');
            return redirect()->route('admin.transactions.create');
        } else {
            $request->session()->put('transaction', $sessionTransaction);
        }

        return redirect()->route('admin.transactions.create');
    }
}
