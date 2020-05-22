@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">  {{ $action . " " . $title }}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="{{ $route }}" enctype="multipart/form-data" method="post"
                              class="form-horizontal">
                            @csrf

                            <div class="form-body">

                                <div class="product-cont">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Product Name 1</label>
                                        <div class="col-md-9">
                                            <select name="product[]" class="form-control product" onchange="calculate()">
                                                @foreach($product as $key)
                                                    <option value="{{$key->id}}" data-price="{{$key->price}}">{{$key->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('product_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Product Quantity 1</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control quantity" oninput="calculate()" name="quantity[]"
                                                   placeholder="Product Name" required>
                                            @error('product_quantity')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button class="btn btn-info" type="button"
                                                onclick="education_fields();">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="clear"></div>
                                <div id="education_fields"></div>

                                <hr>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" value="{{old("name") }}" required
                                               class="form-control" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Price</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Price" value="{{old("price") }}" required
                                               class="form-control total-price" name="price">
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-offset-11 col-md-9">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fa fa-check"></i>
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('foot')
    <script !src="">
            var room = 1;
            let json ='<?php echo json_encode($product); ?>';
            let product = JSON.parse(json);

            function education_fields() {
                room++;
                var objTo = document.getElementById('education_fields')
                var divtest = document.createElement("div");
                divtest.setAttribute("class", "removeclass" + room);
                var rdiv = 'removeclass' + room;

                let option = ''
                product.forEach(e => {
                    option += `<option value="${e.id}" data-price="${e.price}">${e.name}</option>`
                });

                divtest.innerHTML = `
                                <div class="product-cont">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Product Name ${room}</label>
                                        <div class="col-md-9">
                                            <select name="product[]" class="form-control product" onchange="calculate()" required>
                                                ${option}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Product Quantity ${room}</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control quantity" oninput="calculate()" name="quantity[]"
                                                   placeholder="Product Name" required>
                                        </div>
                                        <button class="btn btn-danger" type="button"
                                                onclick="remove_education_fields(${room});">
                                            <span class="glyphicon glyphicon-minus" aria-hidden="true">
                                        </button>
                                    </div>
                                </div>`;

                objTo.appendChild(divtest);
                calculate();
            }

            function remove_education_fields(rid) {
                $('.removeclass' + rid).remove();
                room--;
                calculate();
            }

            function calculate() {
                let totalPrice = 0;
                $(document).find(".product-cont").each(function() {
                    let price = $(this).find(".product").find(":selected").attr("data-price");
                    let quantity = $(this).find(".quantity").val();
                    totalPrice += (price * quantity);
                });
                totalPrice == 0 ? $(".total-price").val('') : $(".total-price").val(totalPrice);
            }
    </script>

@endpush
