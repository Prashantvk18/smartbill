@include('dashboard.header', ['title' => 'Settings | SmartBill'])

<h4 class="mb-3">🔐 Global Admin – User Management</h4>

<table class="table">
    <thead>
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
                <button class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#passwordModal"
                        data-userid="{{ $user->id }}">
                    Update Password
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<h4 class="mt-5 mb-3">💳 Shop Payment Management</h4>

<table class="table">
    <thead>
        <tr>
            <th>Shop</th>
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
                @if($shop->is_paid)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>

            <td>{{ $shop->dop ?? '—' }}</td>
            <td>{{ $shop->doe ?? '—' }}</td>

            <td>
                @if(!$shop->is_paid)
                    <button class="btn btn-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal"
                            data-shopid="{{ $shop->id }}">
                        Activate
                    </button>
                @else
                    <form method="POST" action="{{ route('admin.shop.deactivate') }}">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <button class="btn btn-danger btn-sm">Deactivate</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<div class="modal fade" id="paymentModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.shop.payment') }}" class="modal-content">
            @csrf

            <input type="hidden" name="shop_id" id="shopIdInput">

            <div class="modal-header">
                <h5>Activate Shop</h5>
            </div>

            <div class="modal-body">
                <label>Paid Amount</label>
                <input type="number" name="paid_amount" class="form-control" required>

                <label class="mt-2">Date of Payment</label>
                <input type="date" name="dop" class="form-control" required>

                <label class="mt-2">Date of Expiry</label>
                <input type="date" name="doe" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success w-100">Activate</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('paymentModal')
    ?.addEventListener('show.bs.modal', e => {
        document.getElementById('shopIdInput').value =
            e.relatedTarget.getAttribute('data-shopid');
});
</script>


@include('dashboard.footer')