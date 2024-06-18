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
        <h1 class="mt-5 mb-3 text-center">{{ $product->name }}</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->img_thumbnail }}" width="300px" alt="">
                <table class="table table-bordered">
                    <tr>
                        <th>Trường </th>
                        <th>Giá trị</th>
                    </tr>
                    <tr>
                        <td>SLUG</td>
                        <td>{{ $product->slug }}</td>
                    </tr>
                    <tr>
                        <td>Price_regular</td>
                        <td>{{ $product->price_regular }}</td>
                    </tr>
                    <tr>
                        <td>Price_sale</td>
                        <td>{{ $product->price_sale }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <form action="{{ route('cart.add') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <label class="form-check-label mb-3 mt-3" for=""><b>Color</b></label>
                    @foreach ($colors as $id => $name)
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio_color_{{ $id }}"
                                name="product_color_id" value="{{ $id }}">
                            <label class="form-check-label" for="radio_color_{{ $id }}">{{$name}}</label>
                        </div>
                    @endforeach

                    <label class="form-check-label mb-3 mt-3" for=""><b>Size</b></label>
                    @foreach ($sizes as $id => $name)
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio_size_{{ $id }}"
                                name="product_size_id" value="{{ $id }}">
                            <label class="form-check-label" for="radio_size_{{ $id }}">{{$name}}</label>
                        </div>
                    @endforeach

                    <div class="mb-3 mt-3">
                        <label for="quatity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" min="1" required id="quatity" placeholder="Enter quatity" name="quatity" value="1">
                      </div>

                    <button class="btn btn-primary" type="submit">Add to cart</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
