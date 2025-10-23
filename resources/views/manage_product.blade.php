@extends('layout.master')


@section('content')

    {{-- Manage All product start --}}
    <section class="main_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    {{-- session message --}}
                    @if (@session('success'))
                        @session('success')
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endsession
                    @else
                        {{-- check the notifications --}}
                        @session('error')
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endsession
                    @endif

                    <form action="{{ route('manage_product_page') }}" method="GET">
                       
    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#SL</th>
                                <th scope="col">Product image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>

                                        <img src="{{ asset($product->product_image) }}" alt="..." width="41px">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>
                                        <form action="{{ route('edit_product_page', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Edit</button>
                                        </form>

                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $product->id }}">Delete</button>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete {{ $product->name }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                        <form action="{{ route('delete_product', $product->id) }}" method="POST"> 
                                                            @csrf
                                                               <button type="submit" class="btn btn-primary">Delete {{ $product->name }}</button>
                                                        </form>
                                                 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                
                            @endforeach

                           

                        </tbody>

                        {{ $products->links() }}
                   
                </div>
            </div>
        </div>
    </section>

@endsection