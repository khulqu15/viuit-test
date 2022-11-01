<?php

namespace App\Http\Controllers\Transaction;

use App\Actions\Transaction\CreateTransaction;
use App\Actions\Transaction\EditTransaction;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $transactions = Transaction::query()->with(['product', 'user'])
        ->when($request->get('name'), function($query) use($request) {
            $query->whereHas('product', function($query_product) use($request) {
                $query_product->where('name', 'LIKE', '%'.$request->get('name').'%');
            });
        })
        ->when($request->get('from_date'), function($query) use($request) {
            $query->where('created_at', '>=', $request->get('from_date'));
        })
        ->when($request->get('to_date'), function($query) use($request) {
            $query->where('created_at', '<=', $request->get('to_date'));
        })
        ->orderBy('id', $request->get('sort', 'desc'))
        ->paginate(5);

        foreach ($transactions as $key => $value) {
            $transactions[$key]['hash'] = $value->hash;
        }
        return Inertia::render('Transaction/Index', ['transactions' => $transactions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateTransaction $action
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, CreateTransaction $action): RedirectResponse
    {
        $action->store($request->all());
        return redirect()->back()->with('success', 'Successful buying process');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function edit(Transaction $transaction): Response
    {
        $transaction->hash = $transaction->hash;
        return Inertia::render('Transaction/Edit', ['transaction' => $transaction->load(['user', 'product'])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @param EditTransaction $action
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Transaction $transaction, EditTransaction $action): RedirectResponse
    {
        $action->update($request->all(), $transaction);
        return redirect()->route('transactions')->with('success', 'Transaction has updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();
        return redirect()->route('transactions')->with('success', 'Transaction deleted');
    }
}
