<x-app-layout>
    <h1>Canteen Transactions</h1>
    <a href="{{ route('canteen.transactions.create') }}">Add Transaction</a>
    <table>
        <thead>
            <tr>
                <th>Balance</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Description</th>
                <th>Updated_By</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ number_format($transaction->balance,2) }}</td>
                <td>{{ $transaction->credit == 0 ? '-' : number_format($transaction->credit, 2) }}</td>
                <td>{{ $transaction->debit == 0 ? '-' : number_format($transaction->debit, 2) }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ ucfirst($transaction->username) }}</td>
                <td>{{ $transaction->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
