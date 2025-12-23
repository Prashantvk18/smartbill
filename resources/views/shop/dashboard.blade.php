 @include('dashboard.header', ['title' => 'Shop Dashboard | SmartBill'])

<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{$shop_name}} Dashboard</h4>
        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#billModal">
            ➕ Add Bill
        </button>
    </div>

</div>

<div class="card mb-3 shadow-sm">
    <div class="card-body">

        <form method="GET">
            <div class="row g-2 align-items-end">

                <div class="col-md-3">
                    <label>From</label>
                    <input type="date" name="from_date" class="form-control"
                           value="{{ $from }}">
                </div>

                <div class="col-md-3">
                    <label>To</label>
                    <input type="date" name="to_date" class="form-control"
                           value="{{ $to }}">
                </div>

                <div class="col-md-3">
                    <label>Search By</label>
                    <select name="search_type" class="form-control">
                        <option value="">-- Select --</option>
                        <option value="bill_no">Bill No</option>
                        <option value="whatsapp_number">Mobile No</option>
                        <option value="customer_name">Customer Name</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Search</label>
                    <input type="text" name="search_value" class="form-control"
                           placeholder="Enter value">
                </div>

                <div class="col-md-12 mt-2">
                    <button class="btn btn-primary btn-sm">
                        🔍 Filter
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Bill No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Mobile</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Action</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>

            @forelse($bills as $bill)
               <tr style="cursor:pointer;">

                    <td onclick='openEditBill(@json($bill))'>{{ $bill->bill_no }}</td>
                    <td>{{ $bill->bill_date }}</td>
                    <td>{{ $bill->customer_name ?? '-' }}</td>
                    <td>{{ $bill->whatsapp_number ?? '-' }}</td>
                    <td>₹{{ $bill->total_amount }}</td>
                    <td>₹{{ $bill->paid }}</td>
                    <td class="text-danger fw-semibold">
                        ₹{{ $bill->balance }}
                    </td>
                    <td>
                        @if($bill->balance > 0)
                            <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBalanceModal"
                                    data-id="{{ $bill->id }}"
                                    data-total="{{ $bill->total_amount }}"
                                    data-balance="{{ $bill->balance }}">
                                ✏️ Edit
                            </button>
                        @else
                            <span class="badge bg-success">Paid</span>
                        @endif
                    </td>
                    @php
                        $pdfValid = $bill->is_pdf
                            && $bill->pdf_generate_date
                            && \Carbon\Carbon::parse($bill->pdf_generate_date)->addDays(30)->isFuture();
                    @endphp

                   <td>
                        @if($bill->hasPdf())

                            {{-- VIEW PDF --}}
                            <a  href="{{ route('bill.pdf.internal', $bill->id) }}"
                            target="_blank"
                            class="btn btn-outline-success btn-sm mb-1">
                                📄 View PDF
                            </a>

                            {{-- SEND PDF --}}
                            <a href="{{ route('bill.pdf.send', $bill->id) }}"
                            class="btn btn-success btn-sm mb-1">
                                📲 Send
                            </a>

                            {{-- REMOVE PDF --}}
                            <form method="POST"
                                action="{{ route('bill.pdf.remove', $bill->id) }}"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Remove existing PDF?')">
                                    🗑 Remove
                                </button>
                            </form>

                        @else

                            {{-- GENERATE PDF --}}
                            <a href="{{ route('bill.pdf.internal', $bill->id) }}"
                            class="btn btn-outline-primary btn-sm mb-1">
                                ⚙️ Generate PDF
                            </a>

                            {{-- GENERATE & SEND --}}
                            <a href="{{ route('bill.pdf.send', $bill->id) }}"
                            class="btn btn-success btn-sm">
                                📲 G/S PDF
                            </a>

                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        No bills found
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="editBalanceModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('bill.update.balance') }}"
              class="modal-content">
            @csrf

            <input type="hidden" name="bill_id" id="billId">

            <div class="modal-header">
                <h5>Edit Balance</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Balance Amount</label>
                <input type="number"
                       name="balance"
                       id="balanceInput"
                       class="form-control"
                       min="0"
                       required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary w-100">
                    Update Balance
                </button>
            </div>

        </form>
    </div>
</div>

@include('shop.partials.bill-modal')


<script>
document.getElementById('editBalanceModal')
    ?.addEventListener('show.bs.modal', function (e) {
        document.getElementById('billId').value =
            e.relatedTarget.getAttribute('data-id');
        document.getElementById('balanceInput').value =
            e.relatedTarget.getAttribute('data-balance');
});
</script>

 @include('dashboard.footer')