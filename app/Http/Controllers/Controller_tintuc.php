<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model_tintuc;
class Controller_tintuc extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas= Model_tintuc::all();
        return view('admin.tintuc', compact("datas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tintuc_them');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tentintuc'=>"required",  
            'loingangon'=>"required|max:25",
            'anh'=>"required",
            'mota'=>"required", 
        ],[
            'tentintuc.required'=>"Mời bạn nhập thông tin vào",  
            'loingangon.required'=>"Mời bạn nhập thông tin vào",
            'anh.required'=>"Mời bạn nhập thông tin vào",
            'mota.required'=>"Mời bạn nhập thông tin vào",
            'loingangon.max'=>"Bạn nhập quá số ký tự cho phép (max:25 ký tự)",
        ]);

        if($request->has('anh'))
        {
            $file=$request->anh;
            $file_name=$file->getClientOriginalName();
            $file->move(public_path('tin_tuc'),$file_name);
        }

        $tintuc=new Model_tintuc();
        $tintuc->ten_tin_tuc=$request->tentintuc;
        $tintuc->loi_ngan_gon=$request->loingangon;
        $tintuc->anh=$file_name;
        $tintuc->mo_ta=$request->mota;
        $tintuc->save();
        return redirect()->route("admin_tintuc.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Model_tintuc::find($id);
        return view("admin.tintuc_sua", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tintuc=Model_tintuc::find($id);
        if($request->has('anh'))
        {
            $file=$request->anh;
            $file_name=$file->getClientOriginalName();
            $file->move(public_path('tin_tuc'),$file_name);
            $tintuc->ten_tin_tuc=$request->tentintuc;
            $tintuc->loi_ngan_gon=$request->loingangon;
            $tintuc->anh=$file_name;
            $tintuc->mo_ta=$request->mota;
            $tintuc->save();
        }
        else{
            $tintuc->ten_tin_tuc=$request->tentintuc;
            $tintuc->loi_ngan_gon=$request->loingangon;
            $tintuc->mo_ta=$request->mota;
            $tintuc->save();
        }
        return redirect()->route("admin_tintuc.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tintuc=Model_tintuc::find($id)->delete();
        return redirect()->route("admin_tintuc.index");
    }
}
