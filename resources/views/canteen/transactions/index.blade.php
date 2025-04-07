<x-app-layout>
    <h1>Canteen Transactions</h1>
    <a href="{{ route('canteen.transactions.create') }}">Add Transaction</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ number_format($transaction->amount,2) }}</td>
                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
