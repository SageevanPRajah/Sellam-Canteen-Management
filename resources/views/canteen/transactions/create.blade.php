<x-app-layout>
    <h1>Add Transaction</h1>
    <form action="{{ route('canteen.transactions.store') }}" method="POST">
        @csrf
        <div>
            <label>Amount:</label>
            <input type="number" step="0.01" name="amount" required>
        </div>
        <div>
            <label>Transaction Type:</label>
            <select name="transaction_type" required>
                <option value="credit">Credit (Add Money)</option>
                <option value="debit">Debit (Subtract Money)</option>
            </select>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <button type="submit">Submit Transaction</button>
    </form>
</x-app-layout>
