<style>
    @media (max-width: 576px) {
    .modal-footer .btn {
        width: 100%;
        margin-bottom: 6px;
    }

    .toggle-box {
    transition: all 0.3s ease;
}
/* Modal container */
.modal-content {
    border-radius: 18px;
    border: none;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    overflow: hidden;
}

/* Header */
.modal-header {
    background: linear-gradient(135deg, #2563EB, #0EA5E9);
    color: #fff;
    border-bottom: none;
}

.modal-header .modal-title {
    font-weight: 600;
}

.modal-header .btn-close {
    filter: invert(1);
}

/* Body */
.modal-body {
    background-color: #F8FAFC;
}

/* Footer */
.modal-footer {
    background: #fff;
    border-top: 1px solid #e5e7eb;
}

.modal-body label {
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 4px;
}

.modal-body .form-control {
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 10px 12px;
    font-size: 0.95rem;
}

.modal-body .form-control:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
}

#itemsContainer .item-row {
    background: #ffffff;
    border-radius: 14px;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.total-box {
    background: #ECFEFF;
    border: 1px dashed #0EA5E9;
    border-radius: 14px;
    padding: 12px 16px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #0369A1;
}

.modal-body input[type="checkbox"] {
    margin-right: 6px;
    accent-color: #2563EB;
}

.modal-body .row.mt-3 > div {
    margin-bottom: 6px;
}

#warrantyInput,
#guaranteeInput,
#balanceInput {
    background: #ffffff;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.modal-footer .btn {
    border-radius: 12px;
}

@media (max-width: 576px) {
    .modal-header {
        padding: 14px;
    }

    .modal-title {
        font-size: 1rem;
    }

    .total-box {
        font-size: 1rem;
    }
}

}

</style>
<div class="modal fade" id="billModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-fullscreen-sm-down modal-dialog-scrollable">
        <div class="modal-content">

            <form method="POST" action="{{ route('bill.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Bill</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    {{-- CUSTOMER + DATE --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Customer Name</label>
                            <input type="text" class="form-control" name="customer_name">
                        </div>

                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date"
                                   class="form-control"
                                   name="bill_date"
                                   value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    {{-- ITEMS --}}
                    <div id="itemRowTemplate" class="d-none">
    <div class="row g-2 mb-2 item-row align-items-center">
        <div class="col-12 col-md-5">
            <input type="text" class="form-control"
                   name="item_name[]" placeholder="Item Name">
        </div>
        <div class="col-4 col-md-2">
            <input type="number" class="form-control qty"
                   name="quantity[]" placeholder="Qty">
        </div>
        <div class="col-4 col-md-2">
            <input type="number" class="form-control price"
                   name="price[]" placeholder="Price">
        </div>
        <div class="col-4 col-md-1 text-center">
            <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="removeItem(this)">
                ✕
            </button>
        </div>
    </div>
</div>

                    <div id="itemsContainer">
                        <div class="row g-2 mb-2 item-row align-items-center">
                            <div class="col-12 col-md-5">
                                <input type="text" class="form-control" name="item_name[]" placeholder="Item Name">
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="number" class="form-control qty" name="quantity[]" placeholder="Qty">
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="number" class="form-control price" name="price[]" placeholder="Price">
                            </div>
                            <div class="col-4 col-md-1 text-center">
                                <button type="button"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="removeItem(this)">
                                    ✕
                                </button>
                            </div>
                        </div>

                    </div>

                    <button type="button"
                            class="btn btn-light border-primary text-primary fw-medium mb-3"
                            onclick="addItemRow()">
                        ➕ Add Item
                    </button>


                    {{-- TOTAL --}}
                    <button type="button"
                            class="btn btn-outline-primary mb-2"
                            onclick="calculateTotal()">
                        Calculate Total
                    </button>

                    <div class="total-box mt-3 mb-2">
                        Total Amount: ₹ <span id="totalAmount">0</span>
                    </div>

                    <input type="hidden" name="total_amount" id="totalInput">

                    {{-- OPTIONS --}}
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <input type="checkbox" name="is_sign" value="1"> Add Signature
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="is_stamp" value="1"> Add Stamp
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="warranty"
                                   name="is_warranty"
                                   value="1"
                                   onclick="toggleWarranty()"> Warranty
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="guarantee"
                                   name="is_guarantee"
                                   value="1"
                                   onclick="toggleGuarantee()"> Guarantee
                        </div>
                    </div>

                    {{-- WARRANTY / GUARANTEE DETAILS --}}
                    <div id="warrantyInput" class="mt-2 d-none">
                        <input type="text"
                               class="form-control"
                               name="details"
                               placeholder="Warranty details">
                    </div>

                    <div id="guaranteeInput" class="mt-2 d-none">
                        <input type="text"
                               class="form-control"
                               name="details"
                               placeholder="Guarantee details">
                    </div>

                    {{-- BALANCE --}}
                    <div class="mt-2">
                        <input type="checkbox" onclick="toggleBalance()"> Balance
                    </div>

                    <div id="balanceInput" class="mt-2 d-none">
                        <input type="number"
                               class="form-control"
                               name="balance"
                               placeholder="Balance Amount"
                               min="0">
                    </div>

                    {{-- WHATSAPP --}}
                    <div class="mt-3">
                        <label>WhatsApp Number</label>
                        <input type="text"
                               class="form-control"
                               name="whatsapp_number"
                               placeholder="91XXXXXXXXXX">
                    </div>

                </div>

                {{-- FOOTER BUTTONS --}}
                    <div class="modal-footer gap-2">
                        <button type="submit"
                                name="action"
                                value="send"
                                class="btn btn-success px-4 fw-semibold">
                            📲 Send Bill
                        </button>

                        <button type="submit"
                                name="action"
                                value="save"
                                class="btn btn-outline-primary px-4 fw-semibold">
                            💾 Save Bill
                        </button>
                    </div>


            </form>

        </div>
    </div>
</div>


<script>
document.getElementById('billModal')
    ?.addEventListener('shown.bs.modal', function () {
        document.querySelector('input[name="customer_name"]')?.focus();
    });

function addItemRow() {
    let template = document.querySelector('#itemRowTemplate .item-row');

    if (!template) return;

    let newRow = template.cloneNode(true);

    newRow.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    document.getElementById('itemsContainer').appendChild(newRow);
}


function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        let qty = row.querySelector('.qty').value || 0;
        let price = row.querySelector('.price').value || 0;
        total += qty * price;
    });
    document.getElementById('totalAmount').innerText = total;
    document.getElementById('totalInput').value = total;
}

function toggleWarranty() {
    document.getElementById('warrantyInput').classList.toggle('d-none');
}

function toggleGuarantee() {
    document.getElementById('guaranteeInput').classList.toggle('d-none');
}

function toggleBalance() {
    document.getElementById('balanceInput').classList.toggle('d-none');
}


function calculateTotalLive() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        let qty = parseFloat(row.querySelector('.qty')?.value) || 0;
        let price = parseFloat(row.querySelector('.price')?.value) || 0;
        total += qty * price;
    });

    document.getElementById('totalAmount').innerText = total.toFixed(2);
    document.getElementById('totalInput').value = total.toFixed(2);
}

// auto-calc on change
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('qty') ||
        e.target.classList.contains('price')) {
        calculateTotalLive();
    }
});


document.querySelector('input[name="balance"]')
    ?.addEventListener('input', function () {
        let total = parseFloat(document.getElementById('totalInput').value) || 0;
        let balance = parseFloat(this.value) || 0;

        if (balance > total) {
            this.value = total;
        }
    });

function removeItem(btn) {
    let container = document.getElementById('itemsContainer');
    let rows = container.querySelectorAll('.item-row');

    if (rows.length > 1) {
        btn.closest('.item-row').remove();
    } else {
        // Clear inputs instead of removing last row
        btn.closest('.item-row')
           .querySelectorAll('input')
           .forEach(input => input.value = '');
    }

    calculateTotalLive();
}
</script>




