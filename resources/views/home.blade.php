@extends('layouts.app')

@section('content')

    <h2 class="mb-4">Our Products</h2>
    <p class="text-center">Page {{ $page }} of {{ $totalPages }} pages</p>
    <div class="row">
        @foreach ($products as $product)
            {{-- Display the product if the catalog visibility is visible
            --}}
            @if ($product->catalog_visibility === 'visible')
                <div class="col-3 mb-4">
                    <div class="card text-center">
                        <img src="{{ $product->images[0]->src }}" class="card-img-top img-product">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <br>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $totalPages; $i++)
                @php
                $class = 'page-item';
                @endphp
                {{-- If current i is the same as the current page, set the current page item to active
                --}}
                @if ($i === (int) $page)
                    @php
                    $class = 'page-item active';
                    @endphp
                @endif

                <li class="{{ $class }}"><a class="page-link" href="/{{ $i }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

@endsection
