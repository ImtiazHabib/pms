@extends('layout.master')


@section('content')

    {{-- Manage All product start --}}
    <section class="main_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @foreach ($products as $product )
                         {{-- add product form start --}}
                    <form action="{{ route('update_product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Product name</label>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                            <div class="form-text">Give you product name here </div>
                            @error('name')
                             <div class="alert alert-danger" role="alert">
                             {{ $message }}
                           </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Price</label>
                            <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                            <div class="form-text">Give you product price here </div>

                            @error('price')
                            <div class="alert alert-danger" role="alert">
                            {{ $message }}
                           </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Description</label>
                            <input type="text" class="form-control" name="description" value="{{ $product->description }}">
                            <div class="form-text">Give you product description here </div>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Product Category</label>
                            <select class="form-select" id="inputGroupSelect01" name="category_id">

                                {{-- read category from Db and show here --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $product->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            {{-- image show  --}}
                             <img src="{{ asset($product->product_image) }}" alt="..." width="41px">
                            <label for="formFile" class="form-label">Product Image</label>
                            <input class="form-control" type="file" id="formFile" name="product_image" >
                        </div>
                        <input type="hidden" id="custId" name="id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary">edit {{ $product->name }} </button>
                    </form>
                    {{-- add product form end --}}
                    @endforeach
                   
                </div>
            </div>
        </div>
    </section>

@endsection
