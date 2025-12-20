@include('dashboard.header', ['title' => 'Admin Settings'])

<div class="container mt-4">

    <h4 class="fw-bold mb-3">🔐 Global Admin – User Management</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->unique_name }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"
                                    onclick="openPasswordModal({{ $user->id }}, '{{ $user->name }}')">
                                Update Password
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

<!-- Payemnt Setting-->
 <hr class="my-4">

<h5 class="fw-bold mb-3">💳 shop Payment Management</h5>
<a href="{{ route('admin.payment.history') }}"
   class="btn btn-outline-primary btn-sm">
    📜 View Payment History
</a>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>shop</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Expiry</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach($shops as $shop)
                <tr>
                    <td>{{ $shop->shop_name }}</td>

                    <td>
                        @if($shop->doe)     
                            <span class="badge bg-warning text-dark">{{ \Carbon\Carbon::parse($shop->doe)->isPast() ? 'Expired' : 'Active' }}</span>
                        @else
                            <span class="badge bg-danger text-dark">Inactive</span>
                        @endif
                    </td>

                    <td>
                        {{ $shop->dop ? \Carbon\Carbon::parse($shop->dop)->format('d M Y') : '—' }}
                    </td>

                    <td>
                        {{ $shop->doe ? \Carbon\Carbon::parse($shop->doe)->format('d M Y') : '—' }}
                    </td>

                   <td>
   <button class="btn btn-sm {{ $shop->is_paid ? 'btn-outline-danger' : 'btn-outline-success' }}"
    onclick='openshopPaymentModal(
        {{ $shop->id }},
        @json($shop->shop_name),
        {{ $shop->is_paid ? 'true' : 'false' }},
        @json($shop->amount),
        @json($shop->dop)
    )'>
    {{ $shop->is_paid ? 'Deactivate' : 'Activate' }}
</button>

</td>

                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="shopPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="shopPaymentForm" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="shopPaymentTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="shop_id" id="paymentshopId">

                <div class="mb-2">
                    <label class="small text-muted">shop</label>
                    <input type="text" id="paymentshopName" class="form-control" readonly>
                </div>

                <!-- ACTIVATE SECTION -->
                <div id="activateSection">

                    <div class="mb-2">
                        <label class="small text-muted">Amount (₹)</label>
                        <input type="number" name="amount"
                               id="paymentAmount"
                               class="form-control"
                               min="0">
                    </div>

                    <div class="mb-2">
                        <label class="small text-muted">Date of Payment</label>
                        <input type="date" name="dop"
                               id="paymentDate"
                               class="form-control">
                    </div>

                    <small class="text-muted">
                        Expiry will be set automatically (6 months)
                    </small>

                </div>

                <!-- DEACTIVATE WARNING -->
                <div id="deactivateSection" class="alert alert-warning mt-2">
                    ⚠️ This will deactivate the shop and lock all premium features.
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn" id="shopPaymentSubmit"></button>
            </div>

        </form>
    </div>
</div>




<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.user.password.update') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="user_id" id="modalUserId">

                <div class="mb-2">
                    <label class="small text-muted">User</label>
                    <input type="text" id="modalUserName" class="form-control" readonly>
                </div>

                <div>
                    <label class="small text-muted">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPasswordModal(id, name) {
    document.getElementById('modalUserId').value = id;
    document.getElementById('modalUserName').value = name;
    new bootstrap.Modal(document.getElementById('passwordModal')).show();
}

</script>

<script>
function openshopPaymentModal(id, name, isPaid, amount, dop) {

    document.getElementById('paymentshopId').value = id;
    document.getElementById('paymentshopName').value = name;

    const form = document.getElementById('shopPaymentForm');
    const title = document.getElementById('shopPaymentTitle');
    const submitBtn = document.getElementById('shopPaymentSubmit');

    const activateSection = document.getElementById('activateSection');
    const deactivateSection = document.getElementById('deactivateSection');

    if (isPaid) {
        // DEACTIVATE MODE
        title.innerText = 'Deactivate shop';
        submitBtn.innerText = 'Deactivate';
        submitBtn.className = 'btn btn-danger';

        activateSection.style.display = 'none';
        deactivateSection.style.display = 'block';

        form.action = "{{ route('admin.shop.deactivate') }}";
    } else {
        // ACTIVATE MODE
        title.innerText = 'Activate shop';
        submitBtn.innerText = 'Activate';
        submitBtn.className = 'btn btn-success';

        activateSection.style.display = 'block';
        deactivateSection.style.display = 'none';

        document.getElementById('paymentAmount').value = amount || 500;
        document.getElementById('paymentDate').value = dop || '';

        form.action = "{{ route('admin.shop.activate') }}";
    }

    new bootstrap.Modal(document.getElementById('shopPaymentModal')).show();
}
</script>



@include('dashboard.footer')
