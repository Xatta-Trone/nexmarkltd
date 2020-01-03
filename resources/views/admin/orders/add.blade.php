@extends('admin.app')

@section('page_title','Add')
@section('extra_css')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin_asset/bower_components/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        color: #000;
    }
</style>
@endsection


@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        order
        <a href="{{ route('orders.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New order</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="orderform" role="form" method="POST" action="{{ route('orders.store') }}">

            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label>Select a shop</label>
                    <select required onchange="listenForChange(this.value)" class="form-control select2"
                        name="order_for" id="order_for">
                        <option value="">Select a shoP</option>

                        @foreach ($shops as $shop)
                        <option value={{$shop->id}}>{{$shop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" placeholder="select a shop to populate address"
                        class="form-control">
                </div>

                <div class="form-group">

                    <div class="row">
                        <div class="col-xs-4">
                            <label>Add Products</label>
                            <select required class="form-control select2 product" name="add_products" id="add_products">
                                <option value="">Select a Product</option>
                                @foreach ($products as $product)
                                <option data-price={{$product->price}} data-slug={{$product->slug}}
                                    value={{ ($product->id) }}>
                                    {{$product->name }}({{$product->price }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <label for="quantity">quantity</label>
                            <input type="number" value="1" id="quantity" class="form-control">
                        </div>
                        <div class="col-xs-3">
                            <label for="quantity"></label>

                            <a onclick="addRow()" style="margin-top:25px" id="addProductBtn"
                                class="btn btn-sm btn-primary">Add</a>
                        </div>

                    </div>

                </div>


                <div id="ProductBox">
                    <label for="products">Products</label>
                    <div class="row">
                        <div class="col-xs-3">
                            <p>Product Name</p>
                        </div>
                        <div class="col-xs-3">
                            <p>Product Price</p>

                        </div>
                        <div class="col-xs-3">
                            <p>Product quantity</p>
                        </div>
                        <div class="col-xs-3">
                            <p>Total Price</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <input type="text" readonly class="form-control" placeholder="Product name">
                    </div>
                    <div class="col-xs-3">
                        <input type="text" readonly class="form-control" placeholder="Product price">
                    </div>
                    <div class="col-xs-3">
                        <input type="text" class="form-control" placeholder="Quantity">
                    </div>
                    <div class="col-xs-3">
                        <input type="text" readonly class="form-control" placeholder="total price">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"
                    {{-- onClick="this.form.submit(); this.disabled=true; this.innerText='Submitting....';" --}}>Submit</button>
            </div>
        </form>
    </div>
    <!-- /.box -->



</section>
<!-- /.content -->

@endsection




@section('extra_js')
<!-- Select2 -->
<script src=" {{ asset('admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
    $(function () {

    //Initialize Select2 Elements
    $('.select2').select2({
            placeholder: "Select a shop"}
    )
        //Initialize Select2 Elements
        $('.select2.products').select2({
            placeholder: "Select a product"
        }
    );

    $(document).on('click', '.delete', function(){  
       
        console.log($(this).closest('row').remove());
      });  

  })

</script>




<script defer type="text/javascript">
    let shops = {!! $shops !!}
    let products = {!! $products !!}
    console.log(products);


     
    // function createSelectBox(){
    //     var selectList = document.createElement("select");
    //     selectList.id = "mySelect";
    //     selectList.className = 'form-control'
    //     document.getElementById('ProductBox').appendChild(selectList);

    //     //Create and append the options
    //     for (var i = 0; i < shops.length; i++) {
    //         var option = document.createElement("option");
    //         option.value = products[i].id;
    //         option.text = products[i].name;
    //         selectList.appendChild(option);
    //     }
    // }

    function listenForChange(e){
        console.log(e);
        let filterd_shop = shops.filter((shop) => {
            return shop.id == e;
        });
        picked_shop = filterd_shop[0];
        let address_value = picked_shop.addr_1;

        if(picked_shop.addr_2){
            address_value += ' '+picked_shop.addr_2;
        }
        document.getElementById('address').value = address_value;

    }

    function addRow(){
        var e = document.getElementById("add_products");
        var value = e.options[e.selectedIndex].value;
        var text = e.options[e.selectedIndex].text;
        var price = e.options[e.selectedIndex].dataset.price;
        var slug = e.options[e.selectedIndex].dataset.slug;

        var quantity = document.getElementById('quantity').value;
        if(value == null || value == ""){
            alert("please select a product to add");
            return;
        }


        let single_row = `<div class="row productsadded product-${slug}">
                    <div class="col-xs-3">
                        <input type="text" name="products[]"  class="form-control" placeholder="Product name" value=${text}>
                    </div>
                    <div class="col-xs-3">
                        <input type="number" readonly name="productsPrice[]"  class="form-control" placeholder="Product price" value=${price}>
                    </div>
                    <div class="col-xs-3">
                        <input type="number" name="productsQty[]" class="form-control" placeholder="Quantity"  value=${quantity}>
                    </div>
                    <div class="col-xs-3">
                        <input type="text" name="productsTotal[]"  class="form-control" placeholder="total price" value=${quantity*price}>
                        <a data-slug=${slug} class="delete">delete</a>
                    </div>
                </div>`;
        
       $('#ProductBox').append(single_row)
                


        
        console.log(value,text,quantity,price);
    }

    // createSelectBox();



    



</script>


@endsection