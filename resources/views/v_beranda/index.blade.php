@extends('v_layouts.app')
@section('content')
<div class="row">
    @foreach ($produk as $row)
    <!-- Product Single -->
    <div class="col-md-4 col-sm-6 col-xs-6">
        <div class="product product-single">
            <div class="product-thumb">
                <div class="product-label">
                    <span>Kategori</span>
                    <span class="sale">{{$row->kategori->nama_kategori}}</span>
                </div>

                <a href="{{ route('produk.detail', $row->id)}}">
                    <button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Detail Produk</button>
                </a>

                <img src="{{ asset('storage/img-produk/thumb_md_' . $row->foto) }}" alt="{{ $row->nama_produk}}" class="img-produk">
            </div>
            <div class="product-body">
                <h3 class="product-price">Rp. {{ number_format($row->harga, 0, ',', '.') }} <span class="product-old-price">{{ $row->kategori->nama_kategori }}</span></h3>
                <div class="product-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o empty"></i>
                </div>
                <h2 class="product-name"><a href="#">{{$row->nama_produk}}</a></h2>
                <div class="product-btns">
                    <a href="{{ route('produk.detail', $row->id)}}" title="Detail Produk">
                        <button class="main-btn icon-btn"><i class="fa fa-search-plus"></i></button>
                    </a>
                    <form action="{{ route('produk.detail', $row->id)}}" method="post" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="primary-btn add-to-cart">
                            <i class="fa fa-shopping-cart"></i> Pesan
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /Product Single -->
    @endforeach
    <div class="clearfix visible-md visible-lg visible-sm visible-xs"></div>
</div>
@endsection