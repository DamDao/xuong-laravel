<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chi tiết sản phẩm</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-3 text-center">GIỎ HÀNG</h1>
        <div class="row">
            <div class="col-md-8">
                {{-- <img src="{{ $product->img_thumbnail }}" width="300px" alt=""> --}}
                <table class="table table-bordered">
                    <tr>
                        <th>Name </th>
                        <th>Giá thường</th>
                        <th>Giá sale</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Số lượng</th>

                    </tr>
                    @if (session()->has('cart'))
                        @foreach (session('cart') as $item)
                 @php
                    //  dd($item);
                 @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['price_regular'] }}</td>
                                <td>{{ $item['price_sale'] }}</td>
                                <td>{{ $item['product_color']['name'] }}</td>
                                <td>{{ $item['product_size']['name']}}</td>
                                <td>
                                    {{ $item['quatity'] ??=0 }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                    @endif

                </table>
            </div>
            <div class="col-md-4">
                {{-- <form action="{{ route('order.save') }}" method="post">
                    @csrf
                    <label class="form-check-label mb-3 mt-3" for=""><b>Color</b></label>




                    <button class="btn btn-primary" type="submit">Add to cart</button>
                </form> --}}
            </div>
        </div>
    </div>
</body>

</html>
