<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use TM;
use Validator;
use Alert;
class PostTypeCtrl extends Controller
{
    //

    public function delete($id){
          $data= DB::table('post_types')->where('id',$id)->delete();
          if($data){
            Alert::success('Berhasil','Berhasil Menghapus Post Type');
           }else{
            Alert::error('Gagal','Gagal Menghapus Post Type');
           }

       return back();
    }

    public function update($id,Request $request){
        $valid=Validator::make($request->all(),[
            'name'=>'required|string'
        ]);

        if($valid->fails()){
            return back()->withInputs();
        }

       $data= DB::table('post_types')->where('id',$id)->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'id_user'=>Auth::User()->id,
            'updated_at'=>TM::now(),
        ]);

       if($data){
        Alert::success('Berhasil','Berhasil Merubah Post Type');
       }else{
        Alert::error('Gagal','Gagal Merubah Post Type');

       }

       return back();

    }

    public function edit($id){
        $data= DB::table('post_types')->where('id',$id)->first();

        if($data){
            return view('admin.pages.post_type.edit')->with(['data'=>$data]);
        }
    }

    public function index(Request $request){
        $where=[];

        
        if($request->q){
            $where[]="d.name like '%".$request->q."%'";
            $where[]="d.description like '%".$request->q."%'";

        }

    
        $data=DB::table('post_types as d');
        if(count($where)){
            $data=$data->whereRaw(implode(' or ', $where));
        }

        $data=$data->orderBy('updated_at','desc')->paginate(10);

         return view('admin.pages.post_type.index')->with([
            'data'=>$data,
           
            'request'=>$request]);
    }


    public function create(){
        return view('admin.pages.post_type.create');
    }

    public function store(Request $request){
        
        $valid=Validator::make($request->all(),[
            'name'=>'required|string'
        ]);

        if($valid->fails()){
            return back()->withInputs();
        }

        DB::table('post_types')->insert([
            'name'=>$request->name,
            'description'=>$request->description,
            'id_user'=>Auth::User()->id,
            'created_at'=>TM::now(),
            'updated_at'=>TM::now(),

        ]);

        return redirect()->route('admin.post-type.index');
    }


       
}
