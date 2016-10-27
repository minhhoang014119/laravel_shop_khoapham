<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CateRequest;

use App\Cate;

class CateController extends Controller
{
	public function getList(){
		// $list = Cate::all();
        $list = Cate::select('id','name','parent_id','alias')->orderBy('id','DESC')->get();
		return view('admin.cate.cate_list',compact('list'));
	}

    public function getAdd()
    {
        $list = Cate::select('id','name','parent_id')->get();
    	return view('admin.cate.cate_add')->with([
    	    'list' => $list
        ]);
    }

    public function postAdd(CateRequest $request)
    {
    	// dd($request->all());
    	$cate = new Cate;
    	$cate->name = $request->txtCateName;
    	$cate->alias = $request->txtCateName;
    	$cate->order = $request->txtOrder;
    	$cate->parent_id = 1;
    	$cate->keywords = $request->txtKeywords;
    	$cate->description = $request->txtDescription;
    	$cate->save();
    	return redirect()->route('admin.cate.getList')->with([
                'flash_message' => 'Bạn Tạo Thành Công CMNR Nhé !!!',
                'flash_level' => 'success'
            ]);
    }

    public function getDelete($id){
        $parent = Cate::where('parent_id',$id)->count();
        dd($parent);
        if ($parent == 0) {
            $cate = Cate::find($id);
            $cate->delete();
            return redirect()->route('admin.cate.getList')->with([
                'delete' => 'Bạn đã xóa thành công dữ liệu của cate ',
                'id' => $id
            ]);
        }else{
            echo "<script type='text/javascript'>
                    alert('Sorry You can not delete category name');
                    window.location = '";
                    echo route('admin.cate.list');
                    echo "';
            </script>";
        }
    }
    public function getEdit(){
        
    }
    public function postEdit(){
        
    }
}
