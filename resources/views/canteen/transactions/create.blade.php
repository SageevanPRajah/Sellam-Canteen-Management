<x-app-layout>
    <h1>Add Transaction</h1>
    <form action="{{ route('canteen.transactions.store') }}" method="POST">
        @csrf
        <div>
            <label>Transaction Type:</label>
            <select name="transaction_type" id="transaction_type" required>
                <option value="">Select Transaction Type</option>
                <option value="credit">Credit (Add Money)</option>
                <option value="debit">Debit (Subtract Money)</option>
            </select>
        </div>

        <!-- Credit Input: shown only when "credit" is selected -->
        <div id="credit-field" style="display: none;">
            <label>Credit (Amount Added):</label>
            <input type="number" step="0.01" name="credit">
        </div>

        <!-- Debit Input: shown only when "debit" is selected -->
        <div id="debit-field" style="display: none;">
            <label>Debit (Amount Withdrawn):</label>
            <input type="number" step="0.01" name="debit">
        </div>

        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>

        <div>
            <label for="inside_transaction">Inside Transaction:</label>
            <input type="hidden" name="inside_transaction" value="0">
            <input type="checkbox" id="inside_transaction" name="inside_transaction" value="1">
        </div>
        

        <button type="submit">Submit Transaction</button>
    </form>

    <script>
        const transactionTypeSelect = document.getElementById('transaction_type');
        const creditField = document.getElementById('credit-field');
        const debitField = document.getElementById('debit-field');

        transactionTypeSelect.addEventListener('change', function () {
            if (this.value === 'credit') {
                creditField.style.display = 'block';
                debitField.style.display = 'none';
            } else if (this.value === 'debit') {
                debitField.style.display = 'block';
                creditField.style.display = 'none';
            } else {
                creditField.style.display = 'none';
                debitField.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
