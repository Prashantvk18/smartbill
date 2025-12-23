<style>
    @media (max-width: 576px) {
    .modal-footer .btn {
        width: 100%;
        margin-bottom: 6px;
    }

    .toggle-box {
    transition: all 0.3s ease;
    }
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
.items-scroll {
    max-height: 260px;
    overflow-y: auto;
    padding-right: 4px;
}


.modal-body input[type="checkbox"] {
    margin-right: 6px;
    accent-color: #2563EB;
}

.modal-body .row.mt-3 > div {
    margin-bottom: 6px;
}

/* Ensure modal fits screen */
.modal-dialog {
    height: 95vh;
}

/* Make body scrollable */
.modal-body {
    overflow-y: auto;
    max-height: calc(95vh - 140px); /* header + footer space */
}

/* Keep footer always visible */
.modal-footer {
    position: sticky;
    bottom: 0;
    background: #fff;
    z-index: 10;
}


#warrantyInput,
#guaranteeInput,
#balanceInput1 {
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



</style>
<div class="modal fade" id="billModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <form method="POST" action="{{ route('bill.store') }}">
                @csrf
                <input type="hidden" name="shop_id" value="{{$shop}}">
                <input type="hidden" name="bill_id" id="billId1" value="0">
                <input type="hidden" name="mode" id="billMode" value="create">

                <div class="modal-header">
                    <h5 class="modal-title" id="billModalTitle">Create Bill</h5>
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
                                   onclick="toggleWarranty()"> Warranty/Guarantee
                        </div>
                        <!-- <div class="col-md-3">
                            <input type="checkbox" id="guarantee"
                                   name="is_guarantee"
                                   value="1"
                                   onclick="toggleGuarantee()"> Warranty/
                        </div> -->
                        <div class="col-md-3">
                            <input type="checkbox" id="balance1"
                                   name="is_balance1"
                                   value="1"
                                   onclick="toggleBalance()"> Balance
                        </div>
                        
                    </div>

                    {{-- WARRANTY / GUARANTEE DETAILS --}}
                    <div id="warrantyInput" class="mt-2 d-none">
                        <input type="text"
                               class="form-control"
                               name="details"
                               placeholder="Warranty details">
                    </div>
                    <!-- <div id="guaranteeInput" class="mt-2 d-none">
                        <input type="text"
                               class="form-control"
                               name="details"
                               placeholder="Guarantee details">
                    </div> -->

                    <div id="balanceInput1" class="mt-2 d-none">
                        <input type="text"
                               class="form-control"
                               name="balance1"
                               placeholder="Balance details">
                    </div>

                    {{-- BALANCE --}}
                 

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

                {{-- CREATE MODE --}}
                <div id="createButtons" class="w-100 d-flex gap-2">
                    <button type="submit"
                            name="action"
                            value="send"
                            class="btn btn-success px-4 fw-semibold w-100">
                        📲 Send Bill
                    </button>

                    <button type="submit"
                            name="action"
                            value="save"
                            class="btn btn-outline-primary px-4 fw-semibold w-100">
                        💾 Save Bill
                    </button>
                </div>

                {{-- EDIT MODE --}}
                <div id="updateButtons" class="w-100 d-none">
                    <button type="submit"
                            class="btn btn-primary px-4 fw-semibold w-100">
                        ♻️ Update Bill
                    </button>
                </div>

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
    document.getElementById('warrantyInput').classList.toggle('d-none');
}

function toggleBalance() {
    document.getElementById('balanceInput1').classList.toggle('d-none');
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


document.addEventListener('input', function (e) {
    if (e.target.name === 'balance') {
        let total = parseFloat(document.getElementById('totalInput').value) || 0;
        let balance = parseFloat(e.target.value) || 0;

        if (balance > total) {
            e.target.value = total;
        }
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

function openEditBill(bill) {
    // Mode
    console.log(bill.id);
    document.getElementById('billMode').value = 'edit';
    document.getElementById('billId1').value = bill.id;

    // Title
    document.getElementById('billModalTitle').innerText = 'Edit Bill';

    // Buttons
    document.getElementById('createButtons').classList.add('d-none');
    document.getElementById('updateButtons').classList.remove('d-none');

    // Basic fields
    document.querySelector('[name="customer_name"]').value = bill.customer_name;
    document.querySelector('[name="bill_date"]').value = bill.bill_date;
    document.querySelector('[name="balance1"]').value = bill.balance ?? '';
    if(bill.balance > 0){
        document.querySelector('[name="is_balance1"]').checked = 1;
        toggleBalance();
    }
    document.querySelector('[name="whatsapp_number"]').value = bill.whatsapp_number ?? '';

    // Checkboxes
    document.querySelector('[name="is_sign"]').checked = bill.is_sign == 1;
    document.querySelector('[name="is_stamp"]').checked = bill.is_stamp == 1;
    document.querySelector('[name="is_warranty"]').checked = bill.is_warranty == 1;
    //document.querySelector('[name="is_guarantee"]').checked = bill.is_guarantee == 1;
    if(bill.is_warranty == 1){
        document.querySelector('[name="details"]').value = bill.details;
        toggleWarranty();
    }
  
    // Clear items
   const container = document.getElementById('itemsContainer');
container.innerHTML = '';

const template = document.querySelector('#itemRowTemplate .item-row');

if (!template) {
    console.error('Item template not found');
    return;
}

if (bill.items && bill.items.length > 0) {
    bill.items.forEach(item => {
        const row = template.cloneNode(true);

        row.querySelector('[name="item_name[]"]').value = item.item_name;
        row.querySelector('[name="quantity[]"]').value = item.quantity;
        row.querySelector('[name="price[]"]').value = item.price;

        container.appendChild(row);
    });
}

    calculateTotalLive();

    new bootstrap.Modal(document.getElementById('billModal')).show();
}
</script>





