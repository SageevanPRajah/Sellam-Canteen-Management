<?php
namespace App\Http\Controllers;
use App\Models\CanteenTransaction;
use Illuminate\Http\Request;

class CanteenTransactionController extends Controller {
    public function index() {
        $transactions = CanteenTransaction::orderBy('created_at', 'desc')->get();
        return view('canteen.transactions.index', compact('transactions'));
    }

    public function create() {
        return view('canteen.transactions.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'amount'             => 'required|numeric',
            'transaction_type'   => 'required|in:credit,debit',
            'description'        => 'nullable|string',
        ]);
        CanteenTransaction::create($data);
        return redirect()->route('canteen.transactions.index')->with('success', 'Transaction recorded successfully.');
    }
}
