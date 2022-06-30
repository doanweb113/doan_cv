<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model_sanpham;
use App\Models\Model_tintuc;
use App\Models\Model_danhmuc;
use Illuminate\Database\Eloquent\Model;
use Cart;
class Controller_client extends Controller
{
    public function index(){
        $sanphams=Model_sanpham::all();
        $tintucs=Model_tintuc::all();
        $bonsais=Model_danhmuc::where("ten_danh_muc", 'Bonsai')->first();
        $phongthuys=Model_danhmuc::where("ten_danh_muc", 'Cây cảnh phong thủy')->first();
        $sendas=Model_danhmuc::where("ten_danh_muc", 'Cây cảnh sen đá')->first();
        $vanphongs=Model_danhmuc::where("ten_danh_muc", 'Cây cảnh văn phòng')->first();
        $danhmucs=Model_danhmuc::all();
        // session()->put($d)
        return view("client.index", compact("sanphams","tintucs", "bonsais", "phongthuys", "sendas", "danhmucs","vanphongs"));
    }

    public function sanpham()
    {   
        $sanphams=Model_sanpham::orderBy('gia_tien', 'asc')->paginate(20);
        $danhmucs=Model_danhmuc::all();
        $sanpham_5=Model_sanpham::offset(0)->limit(5)->get();
        return view("client.product", compact("sanphams", "danhmucs", "sanpham_5"));
    }

    public function filter_sanpham($danhmuc)
    {
        
        $danhmucs=Model_danhmuc::all();
        $sanpham_5=Model_sanpham::offset(0)->limit(5)->get();
        $sanphams=Model_sanpham::where("ID_danhmuc","=",$danhmuc)->orderBy('gia_tien', 'asc')->paginate(5);
        return view("client.product", compact("sanphams", "danhmucs", "sanpham_5"));
    }

    public function sanpham_info($id)
    {
        $danhmucs=Model_danhmuc::all();
        $sanpham_5=Model_sanpham::offset(0)->limit(5)->get();
        $sanphams=Model_sanpham::find($id);
        return view("client.product_info", compact("sanphams", "danhmucs", "sanpham_5"));
    }
    public function price_sanpham(Request $request){
        // dd($request->all());
        $max= $request->Price_max;
        $min= $request->Price_min;
        $danhmucs=Model_danhmuc::all();
        $sanpham_5=Model_sanpham::offset(0)->limit(5)->get();
        $sanphams=Model_sanpham::where('gia_tien', '>', $min)->where('gia_tien', '<', $max)->paginate(1);
        return view("client.product", compact("sanphams", "danhmucs", "sanpham_5")); 
    }

    public function search_sanpham(Request $request){
        $keywork=$request->sanpham_search;
        $danhmucs=Model_danhmuc::all();
        $sanpham_5=Model_sanpham::offset(0)->limit(5)->get();
        $sanphams=Model_sanpham::where("ten_san_pham", 'like', '%'.$keywork .'%')->paginate(5);
        return view("client.product", compact("sanphams", "danhmucs", "sanpham_5")); 
    }

    public function tintuc(){
        $tintucs= Model_tintuc::all();
        $tintuc_5= Model_tintuc::offset(0)->limit(5)->get();
        $danhmucs=Model_danhmuc::all();
        return view("client.news", compact("danhmucs", "tintucs", "tintuc_5"));
    }

    public function tintuc_info($id){
        $tintucs= Model_tintuc::find($id);
        $tintuc_5= Model_tintuc::offset(0)->limit(5)->get();
        $danhmucs=Model_danhmuc::all();
        return view("client.news_info", compact("danhmucs","tintuc_5", "tintucs"));
    }

    //lam phan mua hang
    public function cart(){
        $danhmucs=Model_danhmuc::all();
        return view("client.cart", compact("danhmucs"));
    }
    public function cart_buy($id){
        $sanpham=Model_sanpham::find($id);
        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        $data['id']=$id;
        $data['qty']=12;
        $data['name']=$sanpham->ten_san_pham;
        $data['price']=$sanpham->gia_tien;
        $data['weight']=12;
        $data['options']['img']=$sanpham->anh;
        Cart::add($data);
        $danhmucs=Model_danhmuc::all();
        return view("client.cart", compact("danhmucs"));
    }
}
