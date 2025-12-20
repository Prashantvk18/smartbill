@include('dashboard.header', ['title' => 'Payment History'])

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">💳 Payment History</h4>
        <a href="{{ route('admin.settings') }}" class="btn btn-sm btn-secondary">
            ← Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Team</th>
                            <th>Team Code</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Expiry Date</th>
                            <th>Activated By</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->team->team_name }}</td>
                            <td>{{ $payment->team->team_code }}</td>
                            <td>₹{{ $payment->amount }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->dop)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->doe)->format('d M Y') }}</td>
                            <td>{{ $payment->admin->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No payment records found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@include('dashboard.footer')
