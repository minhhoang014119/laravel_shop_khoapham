@extends('shop.master')
@section('content')
@section('description')
AkKe Category
@endsection
@section('content')
<div id="maincontainer">
  <section id="product">
    <div class="container">
     <!--  breadcrumb -->
      <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Category</li>
      </ul>
      <div class="row">
        <!-- Sidebar Start-->
        <aside class="span3">
         <!-- Category-->
          <div class="sidewidt">
            <h2 class="heading2"><span>Categories</span></h2>
            <ul class="nav nav-list categories">
              @if (isset($menu_cates))
                @foreach ($menu_cates as $item)
                  <li>
                    <a href="{{ route('listProductsDetail',$item->id,$item->alias) }}">{{ $item->name }}</a>
                  </li>
                @endforeach
              @endif
            </ul>
          </div>
         <!--  Best Seller -->
          <div class="sidewidt">
            <h2 class="heading2"><span>Best Seller</span></h2>
            <ul class="bestseller">
              <li>
                <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
                <a class="productname" href="product.html"> Product Name</a>
                <span class="procategory">Women Accessories</span>
                <span class="price">$250</span>
              </li>
              <li>
                <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
                <a class="productname" href="product.html"> Product Name</a>
                <span class="procategory">Electronics</span>
                <span class="price">$250</span>
              </li>
              <li>
                <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
                <a class="productname" href="product.html"> Product Name</a>
                <span class="procategory">Electronics</span>
                <span class="price">$250</span>
              </li>
            </ul>
          </div>
          <!-- Latest Product -->
          <div class="sidewidt">
            <h2 class="heading2"><span>Latest Products</span></h2>
            <ul class="bestseller">
            @if (!empty($lastest_product))
              @foreach ($lastest_product as $item)
              {{-- {{ dd($item) }} --}}
              {{ $cate_name_lastet_product = DB::table('cates')->select('name')->where('id',$item->cate_id)->get() }}
                <li>
                  <img width="68" height="68" src="{{ asset('/image/'.$item->image) }}" alt="product" title="product">
                  <a class="productname" href="{{ route('productDetail',[$item->id,$item->name]) }}"> {{ $item->name }}</a>
                  {{-- <span class="procategory">{{ $cate_name_lastet_product[0]->name }}</span> --}}
                  <span class="procategory">{{ $cate_name->name }}</span>
                  <span class="price">{{ number_format($item->price,0,',','.') }} VNĐ</span>
                </li>
              @endforeach
            @endif
            </ul>
          </div>
          <!--  Must have -->
          <div class="sidewidt">
          <h2 class="heading2"><span>Must have</span></h2>
          <div class="flexslider" id="mainslider">
            <ul class="slides">
              <li>
                <img src="img/product1.jpg" alt="" />
              </li>
              <li>
                <img src="img/product2.jpg" alt="" />
              </li>
            </ul>
          </div>
          </div>
        </aside>
        <!-- Sidebar End-->
        <!-- Category-->
        <div class="span9">
          <!-- Category Products-->
          <section id="category">
            <div class="row">
              <div class="span9">
               <!-- Category-->
                <section id="categorygrid">
                  <ul class="thumbnails grid">
					@if(!empty($list_products))
					@foreach($list_products as $product)
                    <li class="span3">
                      <a class="prdocutname" href="product.html">{{ $product->name }}</a>
                      <div class="thumbnail">
                        <span class="sale tooltip-test">Sale</span>
                        <a href="#"><img alt="" src="{{ asset('image/'.$product->image) }}"></a>
                        <div class="pricetag">
                          <span class="spiral"></span><a href="#" class="productcart">ADD TO CART</a>
                          <div class="price">
                            <div class="pricenew">{{ number_format($product->price,0,',','.') }} VNĐ</div>
                          </div>
                        </div>
                      </div>
                    </li>
                    @endforeach
					@endif
                  </ul>
                  <div class="pagination pull-right">
                    <ul>
                      <li><a href="#">Prev</a>
                      </li>
                      <li class="active">
                        <a href="#">1</a>
                      </li>
                      <li><a href="#">2</a>
                      </li>
                      <li><a href="#">3</a>
                      </li>
                      <li><a href="#">4</a>
                      </li>
                      <li><a href="#">Next</a>
                      </li>
                    </ul>
                  </div>
                </section>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@endsection