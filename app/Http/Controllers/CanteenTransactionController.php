<?php
namespace App\Http\Controllers;

use App\Models\CanteenTransaction;
use Illuminate\Http\Request;

class CanteenTransactionController extends Controller
{
    public function index() {
        $transactions = CanteenTransaction::orderBy('created_at', 'desc')->get();
        return view('canteen.transactions.index', compact('transactions'));
    }

    public function create() {
        return view('canteen.transactions.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'transaction_type'   => 'required|in:credit,debit',
            // When type is credit, credit field is required; when type is debit, debit field is required.
            'credit'             => 'required_if:transaction_type,credit|nullable|numeric|min:0',
            'debit'              => 'required_if:transaction_type,debit|nullable|numeric|min:0',
            'inside_transaction' => 'required|boolean',
            'description'        => 'nullable|string',
        ]);
    
        // Force credit and debit to be 0 if they are null or empty
        $credit = !empty($data['credit']) ? $data['credit'] : 0;
        $debit  = !empty($data['debit']) ? $data['debit'] : 0;
    
        // Get previous balance
        $lastTransaction = \App\Models\CanteenTransaction::orderBy('created_at', 'desc')->first();
        $previousBalance = $lastTransaction ? $lastTransaction->balance : 0;
    
        // Calculate new balance based on transaction type
        $newBalance = $previousBalance + $credit - $debit;
        $data['balance'] = $newBalance;
    
        // Set username from logged-in user
        $data['username'] = auth()->user()->name;
    
        // Overwrite the values in data to ensure they are numeric
        $data['credit'] = $credit;
        $data['debit']  = $debit;
    
        \App\Models\CanteenTransaction::create($data);
    
        return redirect()->route('canteen.transactions.index')
                         ->with('success', 'Transaction recorded successfully.');
    }
    

}
