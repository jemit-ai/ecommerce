<!DOCTYPE html>
<html>
<head>
    <title>Laravel Cancel Payment Form</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
        }

        .container{
            width:500px;
            margin:50px auto;
            background:#fff;
            padding:20px;
            border-radius:8px;
            box-shadow:0 0 10px rgba(0,0,0,.1);
        }

        input{
            width:100%;
            padding:10px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:5px;
        }

        button{
            padding:10px 20px;
            background:#0d6efd;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        .success{
            color:green;
            margin-bottom:15px;
        }

        .error{
            color:red;
            font-size:14px;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Simple Laravel Form</h2>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('order.cancel') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Order ID</label>
        <input type="number"
               name="order_id"
               class="form-control"
               value="{{ $order['id'] }}"
               required>
    </div>

    <div class="mb-3">
        <label>Payment Method</label>
        <select name="payment_method" class="form-control" required>
            <option value="">Select</option>
            <option value="cod">Cash on Delivery</option>
            <option value="stripe">Stripe</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Transaction ID</label>
        <input type="text"
               name="transaction_id"
               class="form-control"
               value="{{ $order['transaction_id'] }}">
    </div>

    <div class="mb-3">
        <label>Payment ID</label>
        <input type="text"
               name="payment_id"
               class="form-control"
               value="{{ $order['payment_id'] }}">
    </div>

 
    <button type="submit" class="btn btn-primary">
        Cancel Payment
    </button>

</form>

</div>

</body>
</html>