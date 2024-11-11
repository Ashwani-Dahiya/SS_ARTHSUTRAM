@include('admin.header')
<style>
    .form-control {
        margin-bottom: 20px !important;
    }

    label {
        margin-bottom: 0.5rem;
    }
</style>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">

                <div class="page-header breadcumb-sticky">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Update Product</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home /</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('adm.add.product.page') }}p">Update
                                            Product</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Update Product</h5>
                                    </div>
                                    <div class="card-block table-border-style">

                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif
                                        @if (session('error'))
                                        <div class="alert alert-success">
                                            {{ session('error') }}
                                        </div>
                                        @endif




                                        <form method="post" enctype="multipart/form-data"
                                            action="{{ route('adm.update.product.post',['id'=>$product->id]) }}">
                                            {{-- <form method="get" enctype="multipart/form-data"
                                                action="{{ route('test.req') }}"> --}}
                                                @csrf
                                                @method('POST')
                                                <div class="row">
                                                    <div class="d-flex p-4 m-2 justify-content-center align-items-center"
                                                        style="height: 250px;">
                                                        <img src="{{ asset('uploads/Products Images/'.$product->image) }}"
                                                            alt="" width="200" height="200">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Select Category</label>
                                                        <select name="category_id" class="form-control form-select"
                                                            >
                                                            <option value="0">Select Category</option>
                                                            <option value="{{ $product->category_id }}" selected>{{
                                                                $categorieName->name }}
                                                                @foreach ($categories as $categorie )

                                                            <option value="{{ $categorie->id }}">{{ $categorie->name }}
                                                            </option>

                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Select Brand</label>
                                                        <select name="brand_id" class="form-control form-select"
                                                            >
                                                            <option value="0">Select Brand</option>
                                                            <option value="{{ $product->brand_id }}" selected>{{
                                                                $brandName->name }}</option>
                                                            @foreach ($brands as $brand)

                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Product Name</label>
                                                        <input class="form-control" type="text" name="product_name"
                                                             value="{{ $product->name }}">
                                                        @if ($errors->has('product_name'))
                                                        <p class="text-danger">{{ $errors->first('product_name') }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3">

                                                        <label>Photo 1</label>

                                                        <input class="form-control" type="file" name="product_image"
                                                             value="{{ $product->image }}">
                                                        <div class="user-icon">

                                                            <img src="{{ asset('uploads/Products Images/'.$product->image) }}"
                                                                style="height: 50px; width: 50px;">

                                                        </div>
                                                        @if ($errors->has('product_image'))
                                                        <p class="text-danger">{{ $errors->first('product_image') }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>Photo 2</label>
                                                        <input class="form-control" type="file" name="product_image_2" >
                                                        <div class="user-icon">
                                                            @if($product->image2)
                                                            <img src="{{ asset('uploads/Products Images/'.$product->image2) }}"
                                                                style="height: 50px; width: 50px;">
                                                                @else
                                                                <p class="text-danger text-center">No Photo 2</p>
                                                            @endif


                                                        </div>
                                                        @if ($errors->has('product_image_2'))
                                                        <p class="text-danger">{{ $errors->first('product_image_2') }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Photo 3</label>
                                                        <input class="form-control" type="file" name="product_image_3">
                                                        <div class="user-icon">

                                                            @if($product->image3)
                                                            <img src="{{ asset('uploads/Products Images/'.$product->image3) }}"
                                                                style="height: 50px; width: 50px;">
                                                                @else
                                                                <p class="text-danger text-center">No Photo 3</p>
                                                            @endif

                                                        </div>
                                                        @if ($errors->has('product_image_3'))
                                                        <p class="text-danger">{{ $errors->first('product_image_3') }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Photo 4</label>
                                                        <input class="form-control" type="file" name="product_image_4">
                                                        <div class="user-icon">

                                                            @if($product->image4)
                                                            <img src="{{ asset('uploads/Products Images/'.$product->image4) }}"
                                                                style="height: 50px; width: 50px;">
                                                                @else
                                                                <p class="text-danger text-center">No Photo 4</p>
                                                            @endif

                                                        </div>
                                                        @if ($errors->has('product_image_4'))
                                                        <p class="text-danger">{{ $errors->first('product_image_4') }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Photo 5</label>
                                                        <input class="form-control" type="file" name="product_image_5">
                                                        <div class="user-icon ">

                                                            @if($product->image5)
                                                            <img src="{{ asset('uploads/Products Images/'.$product->image5) }}"
                                                                style="height: 50px; width: 50px;">
                                                                @else
                                                                 <p class="text-danger text-center">No Photo 5</p>
                                                            @endif

                                                        </div>
                                                        @if ($errors->has('product_image_5'))
                                                        <p class="text-danger">{{ $errors->first('product_image_5') }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    {{-- <div class="col-md-3">
                                                        <label>Product model</label>
                                                        <input class="form-control" type="text" name="model"  value="{{ $product->model }}">
                                                        @if ($errors->has('model'))
                                                        <p class="text-danger">{{ $errors->first('model') }}</p>
                                                        @endif
                                                    </div> --}}
                                                    <div class="col-md-3">
                                                        <label>Colors</label>
                                                        <input class="form-control" type="text" name="color"
                                                            value="{{ $product->colors }}">
                                                        @if ($errors->has('color'))
                                                        <p class="text-danger">{{ $errors->first('color') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Price</label>
                                                        <input class="form-control" type="number" name="price"  value="{{ $product->price }}">
                                                        @if ($errors->has('price'))
                                                        <p class="text-danger">{{ $errors->first('price') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Discounted Price</label>
                                                        <input class="form-control" type="number"
                                                            name="discounted_price"  value="{{ $product->discounted_price }}">
                                                        @if ($errors->has('discounted_price'))
                                                        <p class="text-danger">{{ $errors->first('discounted_price') }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-5 m-2 p-2 border d-flex justify-content-around align-items-center text-center">
                                                        Size Available
                                                        @php
                                                            // Ensure $sizes is not null and extract size values into an array
                                                            $sizeValues = $sizes ? $sizes->pluck('value')->toArray() : [];
                                                        @endphp

                                                        @for ($j = 38; $j <= 48; $j += 2)
                                                            <label for="check{{ $j }}">{{ $j }}</label>
                                                            <input id="check{{ $j }}" type="checkbox" name="size[]" value="{{ $j }}" style="width: 20px; height: 20px;"
                                                                {{ in_array($j, $sizeValues) ? 'checked' : '' }}>
                                                        @endfor
                                                    </div>








                                                    <div class="col-md-12">
                                                        <label>About1</label>
                                                        <textarea class="form-control" name="about1"
                                                            rows="5">{{ $product->about1 }}</textarea>
                                                        @if ($errors->has('about1'))
                                                        <p class="text-danger">{{ $errors->first('about1') }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-lg" type="submit"
                                                            >Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.footer')
