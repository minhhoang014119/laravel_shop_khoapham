<?php

namespace App\Http\Controllers;
use App\Cate;
use App\Product;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		// $products = Product::all();
		$cates = Cate::all();
		return view('shop.pages.home')->with([
				'products' => $products,
				'cates'    => $cates
			]);
	}

	// public function listProducts() {

	// }
	public function listProductsDetail($id) {
		$list_products = Product::select()->where('cate_id', $id)->get();
		$list_cate_products = Cate::select('parent_id')->where('id',$list_products[0]->cate_id)->first();
		$menu_cates = Cate::select('id','name','alias')->where('parent_id',$list_cate_products->parent_id)->get();
		$lastest_product = Product::select('id','name','price','image','cate_id')->orderBy('id','DESC')->take(3)->get();
		foreach ($lastest_product as $v) {
			$cate_name = Cate::select('name')->where('id',$v->cate_id)->first();
		}
		return view('shop.pages.cate', compact('list_products', 'list_cate', 'menu_cates' , 'lastest_product' , 'cate_name'));
	}

	public function productDetail($id)
	{
		$product_detail = Product::select()->where('id',$id)->first();
		$product_related = Product::select()->where('cate_id',$product_detail->cate_id)->orderBy('id','ASC')->take(4)->get();
		// dd($product_detail);
		return view('shop.pages.product_detail')->with(['product_detail' => $product_detail , 'product_related' => $product_related]);
	}
}
