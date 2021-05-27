<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use TM;
use Alert;

class TaxonomyCtrl extends Controller
{
    //

    public function update($id,Request $request){
            $data=DB::table('taxonomy')->where('id',$id)->update([
                'name'=>$request->name,
                'description'=>$request->description,
                'id_user'=>Auth::User()->id,
                'updated_at'=>TM::now(),
             ]);

            if($data){
            Alert::success('Berhasil','Berhasil Mengubah Taxonomy');
           }else{
            Alert::error('Gagal','Gagal Mengubah  Taxonomy');

           }

           return back();

    }

    public function edit($id){

        $data=DB::table('taxonomy')->where('id',$id)->first();

        if($data){
            return view('admin.pages.taxonomy.edit')->with(['data'=>$data]);
       }else{
            return abort(404);

       }

        return back();


    }

    public function delete($id){

        $data=DB::table('taxonomy')->where('id',$id)->first();

        if($data){
            Alert::success('Berhasil','Berhasil Menghapus Taxonomy');
           }else{
            Alert::error('Gagal','Gagal Menghapus  Taxonomy');

           }

        return back();

    }

    public function index(Request $request){
        $post_type=DB::table('post_types')->orderBy('name','ASC')->get();

        $where=[];
        $post_type_select=isset($post_type[0])?$post_type[0]->id:0;
        $post_type_select_data=isset($post_type[0])?$post_type[0]:null;

        if($request->post_type){
            $post_type_select=$request->post_type;
            $post_type_select_data=DB::table('post_types')->where('id', $post_type_select)->first();
        }

        if(!$post_type_select_data){
        	return abort(404);
        }

        $def=[
            ['d.id_post_type ='.$post_type_select],
        ];




        if($request->q){
            $where[]="d.name like '%".$request->q."%'";
            $where[]="d.description like '%".$request->q."%'";

        }


        $whereRaw=[];

        if(count($where)){
            foreach ($def as $key => $value) {
                 foreach ($where as $kw => $w) {
                        $d=$value;
                        $d[]=$w;

                        $whereRaw[]='('.implode(' and ', $d).')';
                     # code...
                 }
            }
        }else{
             foreach ($def as $key => $value) {
                $whereRaw[]='('.implode(' and ', $value).')';
            }
        }

        $data=DB::table('taxonomy as d')
        ->whereRaw(implode(' OR ', $whereRaw))
        ->orderBy('updated_at','desc')
        ->paginate(10);

        $data->appends($request->all());


        return view('admin.pages.taxonomy.index')->with([
            'data'=>$data,
            'post_type_select_data'=>$post_type_select_data,
            'post_type_select'=>$post_type_select,
            'post_types'=>$post_type,'request'=>$request]);
    }


    public function create($id_post_type,$slug){
        $post_type=DB::table('post_types')->where('id',$id_post_type)->first();

        if($post_type){
            return view('admin.pages.taxonomy.create')->with(['post_type'=>$post_type]);
        }else{
            return abort(404);
        }
    }

    public function store(Request $request){
        $post_type=DB::table('post_types')->where('id',$request->id_post_type)->first();
        if($post_type){
              $data=DB::table('taxonomy')->insert([
                'name'=>$request->name,
                'id_post_type'=>$post_type->id,
                'description'=>$request->description,
                'id_user'=>Auth::User()->id,
                'created_at'=>TM::now(),
                'updated_at'=>TM::now(),
             ]);

              if($data){
                Alert::success('Berhasil','Berhasil Menambah Taxonomy');
               }else{
                Alert::error('Gagal','Gagal Menambah  Taxonomy');

               }

             return redirect()->route('admin.taxonomy.index',['post_type'=>$post_type->id]);
        }else{
            return back();
        }   
    }

}
