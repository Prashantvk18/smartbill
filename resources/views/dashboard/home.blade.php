

<!-- CONTENT -->
 @include('dashboard.header', ['title' => 'Feedback'])
<div class="container mt-3">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
       

        <button class="btn btn-primary w-100 w-md-auto"
                data-bs-toggle="modal"
                data-bs-target="#addShopModal">
            + Add Shop
        </button>
    </div>

    <div class="row">
        @forelse($shops as $shop)
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->shop_name }}</h5>

                        <div class="d-flex justify-content-between align-items-center">
                            @if($shop->is_paid)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning text-dark">Trial</span>
                            @endif

                            @if($shop->is_paid)
                                <!-- PAID SHOP -->
                                <a href="{{ route('shop.dashboard', $shop->id) }}"
                                class="btn btn-outline-primary btn-sm">
                                    Open →
                                </a>
                            @else
                                <!-- UNPAID SHOP -->
                                <button class="btn btn-outline-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#subscriptionModal"
                                        data-shopname="{{ $shop->shop_name }}">
                                    Activate →
                                </button>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No shops added yet</p>
        @endforelse
    </div>

</div>


<div class="modal fade" id="addShopModal">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <form method="POST" action="{{ route('shop.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Add Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label">Shop Name</label>
                <input type="text" name="shop_name" class="form-control form-control-lg" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary w-100">Save Shop</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="subscriptionModal">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Activate Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <h6 class="fw-semibold text-primary mb-2" id="shopNameText"></h6>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">

                        <h4 class="fw-bold mb-2">₹1000 / Year</h4>

                        <ul class="list-unstyled mb-3">
                            <li class="mb-2">✅ Store billing data</li>
                            <li class="mb-2">✅ Generate professional PDF bill</li>
                            <li class="mb-2">✅ Easy & fast billing</li>
                            <li class="mb-2">✅ Owner signature on bill</li>
                            <li class="mb-2">✅ Shop stamp on bill</li>
                            <li class="mb-2">✅ WhatsApp bill sharing</li>
                        </ul>

                        <div class="alert alert-info small">
                            These features will be enabled after activation.
                        </div>

                    </div>
                </div>

                <a href="https://wa.me/918652897550?text=SmallBill%20Interested"
                   target="_blank"
                   class="btn btn-success w-100 fw-semibold">
                    📲 Contact on WhatsApp
                </a>

            </div>

        </div>
    </div>
</div>



<script>
document.getElementById('subscriptionModal')
    ?.addEventListener('show.bs.modal', function (event) {

        let button = event.relatedTarget;
        let shopName = button.getAttribute('data-shopname');

        document.getElementById('shopNameText').innerText =
            'Shop: ' + shopName;
    });
</script>


@include('dashboard.footer')



