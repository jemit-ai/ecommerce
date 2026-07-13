<h2>Invoice</h2>

<p>Order Number: {{ $order->order_number }}</p>
<p>Customer: {{ $order->user->name }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->details as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>