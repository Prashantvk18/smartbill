<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <style>
        * {
            font-family: "DejaVu Sans", sans-serif;
        }

        body {
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .shop-name {
            font-size: 18px;
            font-weight: bold;
        }

        .shop-details {
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .bill-info {
            width: 100%;
            margin-bottom: 10px;
        }

        .bill-info td {
            padding: 4px 0;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.items th,
        table.items td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        table.items th {
            background: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 10px;
            width: 100%;
        }

        .summary td {
            padding: 4px;
            font-size: 12px;
        }

        .summary .label {
            text-align: right;
            font-weight: bold;
        }

        .signature-box {
            margin-top: 30px;
            width: 100%;
        }

        .signature {
            float: right;
            text-align: center;
        }

        .stamp {
            float: left;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
        }

        .clear {
            clear: both;
        }

       

.signature,
.stamp {
    width: 45%;
    text-align: center;
}


.stamp {
    float: left;
}

.signature img,
.stamp img {
    max-width: 120px;   /* 👈 small & professional */
    max-height: 60px;
    object-fit: contain;
}

.signature p,
.stamp p {
    margin-top: 5px;
    font-size: 10px;
    font-weight: bold;
}

.clear {
    clear: both;
}

    </style>
</head>

<body>

<div class="header">
    <div class="shop-name">{{ $shop->shop_name }}</div>
    <div class="shop-details">
        {{ $shop->address }} <br>
        Mobile: {{ $owner->mobile }}
    </div>
</div>

<hr>

<table class="bill-info">
    <tr>
        <td><b>Bill No:</b> {{ $bill->bill_no }}</td>
        <td class="text-right"><b>Date:</b> {{ $bill->bill_date }}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Customer Name:</b> {{ $bill->customer_name }}</td>
    </tr>
</table>

<table class="items">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->item_name }}</td>
            <td class="text-right">{{ $item->quantity }}</td>
            <td class="text-right">₹ {{ number_format($item->price, 2) }}</td>
            <td class="text-right">
                ₹ {{ number_format($item->quantity * $item->price, 2) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<table class="summary">
    <tr>
        <td class="label">Total Amount:</td>
        <td class="text-right">₹ {{ number_format($bill->total_amount, 2) }}</td>
    </tr>
    <tr>
        <td class="label">Paid:</td>
        <td class="text-right">₹ {{ number_format($bill->paid, 2) }}</td>
    </tr>
    <tr>
        <td class="label">Balance:</td>
        <td class="text-right">₹ {{ number_format($bill->balance, 2) }}</td>
    </tr>
</table>

<div class="signature-box">

    {{-- STAMP --}}
    @if($bill->is_stamp && $shop->stamp_path)
        <div class="stamp">
            <img src="{{ public_path('storage/' . $shop->stamp_path) }}" alt="Stamp">
            <p>Stamp</p>
        </div>
    @endif

    {{-- SIGNATURE --}}
    @if($bill->is_sign && $shop->signature_path)
    @php
        $signaturePath = storage_path('app/public/' . $shop->signature_path);
    @endphp

    @if(file_exists($signaturePath))
        <div class="signature">
            <img src="file://{{ $signaturePath }}"
                 style="height:60px; max-width:150px;">
            <p>Authorized Signature</p>
        </div>
    @endif
@endif
    <div class="clear"></div>
</div>


@if($bill->is_warranty || $bill->is_guarantee)
    <p><b>Note:</b> {{ $bill->details }}</p>
@endif

<div class="footer">
    Thank you for shopping with us 🙏 <br>
    This is a computer-generated bill.
</div>

</body>
</html>
