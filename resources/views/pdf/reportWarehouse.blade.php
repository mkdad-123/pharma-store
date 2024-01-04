<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Details</title>

    <style>
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: #3498db;
            color: white;
            font-weight: bold;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }
        .warehouse-info {
            font-size: 10px;
            opacity: 0.7;
        }
    </style>
</head>

<br>
<div style="width: 90%; margin: 0 auto;">
    <div style="width: 10%; float:left; margin-right: 20px;">
        <div class="warehouse-info">
            <p>Name:{{ $warehouse['name'] }}
            <p>Email:{{ $warehouse['email'] }}
            <p>Phone:{{ $warehouse['phone'] }}
            <p>Location:{{ $warehouse['location'] }}
        </div>
    </div>
    <div style="width: 50%; float: right;">
        <h1>All Order Details</h1>
    </div>
</div>
</br> </br>
@foreach ($orders as $key => $order)
    <table style="position: relative; top: 50px;">
        <thead>
        <tr>
            <th>Order number</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-column="Status">{{ $key + 1 }}</td>
            <td data-column="Status">{{ $order->total_price }}</td>
        </tr>
        </tbody>
    </table>

    <table style="position: relative; top: 50px;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Commercial Name</th>
            <th>Scientific Name</th>
            <th>Amount</th>
            <th>Expiration Date</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->orderMedicines as $key2 => $medicine)
            <tr>
                <td data-column="ID">{{ $key2 + 1 }}</td>
                <td data-column="Commercial Name">{{ $medicine->medicine->commercial_name }}</td>
                <td data-column="Scientific Name">{{ $medicine->medicine->scientific_name }}</td>
                <td data-column="Amount">{{ $medicine->medicine->amount }}</td>
                <td data-column="Expiration Date">{{ $medicine->medicine->expiration_date }}</td>
                <td data-column="Price">{{ $medicine->medicine->price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table style="position: relative; top: 50px;">
        <thead>
        <tr>
            <th>Name of Pharmacist</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Location</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-column="Name">{{ $order->pharmacist->name }}</td>
            <td data-column="Email">{{ $order->pharmacist->email }}</td>
            <td data-column="Phone">{{ $order->pharmacist->phone }}</td>
            <td data-column="Location">{{ $order->pharmacist->location }}</td>
        </tr>
        </tbody>
    </table>
</br> </br> </br>
                ******************************{{ $warehouse['name'] }}*************************************
    </br>
@endforeach

</body>

</html>
