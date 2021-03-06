<?php

namespace App\Http\Controllers;

use App\Cate;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductImage;
use Auth;
use DB;
use File;
use Illuminate\Http\Request as Request;
use Image;
// use Image;

use Input;

// use Intervention\Image\Facades\Image;
// use Request;

class ProductController extends Controller
{

    public function getAdd()
    {
        $cate = Cate::select('name', 'id', 'parent_id')->get()->toArray();
        return view('admin.product.product_add', compact('cate'));
    }

    public function postAdd(ProductRequest $product_request)
    {

        // $file_fImages = $request->file('fImages');
        // $cate         = DB::table('cates')->select()->where('name', $request->txtCP)->first();

        // $product          = new Product;
        // $product->name    = $request->txtName;
        // $product->alias   = $request->txtName;
        // $product->price   = $request->txtPrice;
        // $product->intro   = $request->txtIntro;
        // $product->content = $request->txtContent;
        // $product->image   = $file_fImages->getClientOriginalName();
        // $file_fImages->move(public_path('image/'), $file_fImages->getClientOriginalName());

        // $product->keywords    = $request->txtKeywords;
        // $product->description = $request->txtDescription;
        // $product->user_id     = Auth::user()->id;
        // $product->cate_id     = $cate->id;
        // $product->save();
        // $image_fImagess = Image::make(public_path('image/'.$file_fImages->getClientOriginalName()))->resize(400, 400);
        // $image_fImagess->save();
        // // dd(1);
        // $product_img_id = $product->id;
        // if (Input::hasFile('fProductDetail')) {
        // 	foreach ((Input::file('fProductDetail')) as $file) {
        // 		dd($file->getClientOriginalName());
        // 		$product_img = new ProductImage();
        // 		if (isset($file)) {
        // 			$product_img->image      = $file->getClientOriginalName();
        // 			$product_img->product_id = $product_img_id;
        // 			$file->move(public_path('image/image_detail/'), $file->getClientOriginalName());
        // 			$product_img->save();

        // 			$image_fImagess = Image::make(public_path('image/image_detail/'.$file->getClientOriginalName()))->resize(400, 400);
        // 			$img->save();
        // 			dd("All Upload");
        // 		}
        // 	}
        // }

        // return redirect()->route('admin.product.getList')->with([
        // 		'flash_message' => 'Bạn đã thêm thành công 1 sản phẩm mới',
        // 		'flash_level'   => 'success'
        // 	]);

        $file_name = $product_request->file('fImages')->getClientOriginalName();
        $cate = DB::table('cates')->select('id')->where('name', $product_request->txtCP)->first();
        $product = new Product;
        $product->name = $product_request->txtName;
        $product->alias = $product_request->txtName;
        $product->price = $product_request->txtPrice;
        $product->intro = $product_request->txtIntro;
        $product->content = $product_request->txtContent;
        $product->image = $file_name;
        $product->keywords = $product_request->txtKeywords;
        $product->description = $product_request->txtDescription;
        $product->user_id = Auth::user()->id;
        $product->cate_id = $cate->id;
        // dd(1);
        // // Resize Image Products
        $file_imgImg = Input::file('fImages');
        Image::make($file_imgImg->getRealPath())->resize(400, 400)->save(public_path('image/') . $file_name)->destroy();
        $product->save();
        $product_id = $product->id;
        // Resize Image Product Details
        if (!empty(Input::file('fProductDetail'))) {
            // dd(1);
            // foreach (Input::file('fProductDetail') as $file) {
            $file = Input::file('fProductDetail');

            $product_img = new ProductImage;
            // if (isset($file)) {
            foreach ($file as $v) {
                // dd($v->getClientOriginalName());
                $product_img->image = $v->getClientOriginalName();
                $product_img->product_id = $product_id;
                $v->move(public_path('image/image_details/'), $v->getClientOriginalName());
                // $file->move(public_path('image/image_detail/'), $file->getClientOriginalName());
                $product_img->save();
            }
            // $file_ProductsDetail = Input::file('fProductDetail');
            // $product_img->save();

            // ERROR UPLOAD PRODUCT DETAILS
            // Image::make($file->getRealPath())->resize(400, 400)->save(public_path('image/image_detail/').$file->getClientOriginalName())->destroy();
            // $image_fProductDetail = Image::make(public_path('image/image_detail/').$file->getClientOriginalName())->resize(400, 400);
            // $image_fProductDetail->save();

            // }
            // }
        }
        return redirect()->route('admin.product.getList')->with([
            'flash_message' => 'Bạn đã thêm thành công 1 sản phẩm mới',
            'flash_level' => 'success'
        ]);
    }

    public function getList()
    {
        $product = Product::all();
        return view('admin.product.product_list', compact('product'));
    }

    public function getDelete($id)
    {
        $product_detail = Product::find($id)->product_image;
        // dd($product_detail);
        if (count($product_detail) > 0) {
            foreach ($product_detail as $value) {
                File::delete('public/image' . $value->image);
            }
            $product = Product::find($id);
            // dd($product_detail);
            File::delete('public/image' . $product->image);
            $product->delete($id);
            return redirect()->route('admin.product.getList')->with([
                'delete' => 'Bạn đã xóa thành công',
                'id' => $id
            ]);
        } else {
            $product = Product::find($id);
            $product->delete($id);
            File::delete('public/image' . $product->image);
            return redirect()->route('admin.product.getList')->with([
                'delete' => 'Bạn đã xóa thành công . Vì không có ảnh phụ nên sản phẩm sẽ được xóa !'
            ]);
        }
    }

    public function getEdit($id)
    {
        $cates = Cate::select('id', 'name', 'parent_id')->get();
        $products = Product::find($id);
        $product_img = Product::find($id)->product_image;
        return view('admin.product.product_edit', compact('cates', 'products', 'product_img'));
    }

    public function postEdit($id, Request $request)
    {
        //		$cate                = Cate::where('parent_id', $request->sltParent);
        //		$request->sltParent  = $cate->name;
        // Lưu ý muốn sửa bất kỳ trường nào ở đây ta phải cho nó giá trị của Category

        $product = Product::findOrFail($id);
        $product->name = $request->txtName;
        $product->alias = $request->txtName;
        $product->price = $request->txtPrice;
        $product->intro = $request->txtIntro;
        $product->content = $request->txtContent;
        $product->keywords = $request->txtKeywords;
        $product->description = $request->txtDes;
        $product->user_id = Auth::user()->id;
        $product->cate_id = $request->sltParent;

        $img_current = 'public/image/' . $request->img_current;
        // logic ở đây có ván đề vì nó không xóa ảnh trong database
        if (!empty($request->hasFile('fImages'))) {
            $filename = $request->file('fImages')->getClientOriginalName();
            $product->image = $filename;
            $desPath = public_path('image');
            $request->file('fImages')->move($desPath, $filename);
            if (file_exists($img_current)) {
                File::delete($img_current);
            }
        } else {
            echo "KO CÓ FILE";
        }
        $product->save();
        if (!empty($request->fEditDetail)) {
            foreach ($request->fEditDetail as $file) {
                $product_img = new ProductImage;
                if (isset($file)) {
                    $product_img->image = $file->getClientOriginalName();
                    $product_img->product_id = $id;
                    $file->move('public/image/image_detail' . $file->getClientOriginalName());
                }
                $product_img->save();
            }
        }
        return redirect()->route('admin.product.getList')->with([
            'delete' => 'Bạn đã sửa thành công !'
        ]);
        //		$product = Product::find($id);
        //		$product->name = Request::input('txtName');
        //		$product->alias = Request::input('txtName');
        //		$product->price = Request::input('txtPrice');
        //		$product->intro = Request::input('txtIntro');
        //		$product->content = Request::input('txtContent');
        //		$product->keywords = Request::input('txtKeyword');
        //		$product->description = Request::input('txtDes');
        //		$product->user_id = 1;
        //		$product->cate_id = Request::input('sltParent');
        //        dd($request->all());
        //        $product->save();
    }

    public function getDelImg($id)
    {
        if (Request::ajax()) {
            $idHinh = (int)Request::get('idHinh');
            // $idHinh = $request->idHinh;
            // dd($idHinh);
            $image_detail = ProductImage::find($idHinh);
            if (!empty($image_detail)) {
                $img = '/public/image/' . $image_detail->image;
                if (File::exists($img)) {
                    File::delete($img);
                }
                $image_detail->delete();
                $image_detail->save();
            }
            return "OK";
        }
    }
}
