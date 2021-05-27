<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use Auth;
use DB;
use Storage;
use TM;
use Validator;
use Hash;
use Alert;
class DataCtrl extends Controller
{
    //

    protected $post_type_list;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $post=[
                    'data'=>[],
                    'id'=>[]
            ];
            if(Auth::user()){
                if(Auth::User()->role==2){
            
                    $post['data']=DB::table('post_types as pt')
                    ->join('user_group_post_type as gpt','pt.id','=','gpt.id_post_type')
                    ->selectRaw('pt.*')
                    ->where('gpt.id_user',Auth::User()->id)
                    ->get();

                    $post['id']=$post['data']->pluck('id')->toArray();
                    $this->post_type_list=$post;
                }else{
                    $post['data']=DB::table('post_types')->get();
                    $post['id']=$post['data']->pluck('id')->toArray();
                    $this->post_type_list=$post;
                }

            }else{
                $post['data']=DB::table('post_types')->get();
                $post['id']=$post['data']->pluck('id')->toArray();
                $this->post_type_list=$post;

            }
            

           

            return $next($request);
        });
    }


    public function update($id,Request $request){
        $model=Data::find($id);

        if($model){
            if(!in_array($model->id_post_type, $this->post_type_list['id'])){
                Alert::error('','Post Type Access Tidak Berhasil Di Akses');

                return abort(404);
            }

            $rand=$request->rand;
            $dokumen=[
                'count'=>$model->max_pages,
                'path_file'=>$model->path_file,
                'path_file_pages'=>storage_path('app/public/dokumen_laporan/'.$model->id_post_type.'/'.$request->id_taxonomy.'/'.$rand),
               'path_file_pages_save'=>Storage::url('dokumen_laporan/'.$model->id_post_type.'/'.$request->id_taxonomy.'/'.$rand),
            ];


            if($request->dokumen){
                $path=Storage::put('/public/dokumen_laporan/'.$model->id_post_type.'/'.$request->id_taxonomy.'/'.$rand,$request->dokumen);
                $path=Storage::url($path);

                $dokumen['path_file']=$path;

                $im = new \Imagick(app_path('../public/'.$path));
                $dokumen['count']=$im->getNumberImages();
                $count = $im->getNumberImages();


                for ($x = 1;$x <= $im->getNumberImages(); $x++) {
                  $im->previousImage();
                   $im->setImageBackgroundColor('#ffffff');
                    $im->setImageFormat("jpeg");

                  $im->writeImage($dokumen['path_file_pages'].'/page_'.$count.'.png');
                  if($count==1){

                   
                    $im->setImageCompressionQuality(80);
                    $im->writeImage($dokumen['path_file_pages'].'/cover'.'.png');
                  }

                  $count--; 

                }
            }else if((($model->path_file!=$dokumen['path_file']) OR ($model->path_file_pages!=$dokumen['path_file_pages_save']))){
                
                Storage::copy($model->path_file_pages, $dokumen['path_file_pages_save']);
                
            }

           $d=$model->update([
                // 'title'=>$request->perihal??"".$request->id_taxonomy,
                'perihal'=>$request->prihal,
                'id_taxonomy'=>$request->id_taxonomy,
                'id_post_type'=>$model->id_post_type,
                'no_dokumen'=>$request->no_dokumen,
                'id_user'=>Auth::User()->id,
                'data_date'=>TM::parse($request->data_date),
                'max_pages'=>$dokumen['count'],
                'path_file'=>$dokumen['path_file'],
                'path_file_pages'=>$dokumen['count']?$dokumen['path_file_pages_save']:null,
                'data-trixFields'=>request('data-trixFields'),
                'attachment-data-trixFields'=>request('attachment-data-trixFields'),
            ]);

           if($d){
                Alert::success('','User Berhasil Di Tambah');

           }else{

                Alert::error('','User Tidak Berhasil Di Tambah');


           }
            return back();

       }else{
                Alert::error('','User Tidak Tersedia');

        return abort(500);
       }

    }

    public function delete($id){
        $data=Data::find($id);

        if($data){
            $data->delete();
        }

        return back();
    } 

    public function index(Request $request){

        $post_type=$this->post_type_list['data'];
        $where=[];
        $post_type_select=isset($post_type[0])?$post_type[0]->id:0;
        $post_type_select_data=isset($post_type[0])?$post_type[0]:null;

        if($request->post_type){
            $post_type_select=$request->post_type;
            $post_type_select_data=DB::table('post_types')->where('id', $post_type_select)->first();

        }

        $def=[
            ['d.id_post_type ='.$post_type_select],
        ];




        if($request->q){
            $where[]="d.no_dokumen like '%".$request->q."%'";
            $where[]="c.content like '%".$request->q."%'";
            $where[]="d.perihal like '%".$request->q."%'";
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



        $data=DB::table('data as d')
        ->join('trix_rich_texts as c',[
            ['c.model_id','=','d.id'],

        ])
         ->join('taxonomy as tx','tx.id','=','d.id_taxonomy')
         ->leftJoin('users as uc','uc.id','=','d.id_user')
         ->join('post_types as pt','pt.id','=','d.id_post_type')
        ->leftJoin('trix_attachments as at',[
            ['at.attachable_id','=','d.id'],
            ['at.is_pending','=',DB::raw(0)],
            
        ])
        ->selectRaw("
            d.*,
            (c.content) as content,
            tx.name as name_taxonomy,
            uc.name as uc_name,
            uc.pangkat as uc_pangkat,
            uc.jabatan as uc_jabatan,

            pt.name as name_post_type,
            group_concat(at.attachment) as attch

        ")
        ->groupBy('d.id')
        ->orderBy('d.created_at','desc')
        ->whereRaw(implode(' or ', $whereRaw))
        ->paginate(10);

        $data->appends($request->all());
        $taxonomy=DB::table('taxonomy')->where('id_post_type',$post_type_select)->get();
        return view('admin.pages.data.index')->with([
            'data'=>$data,
            'taxonomy'=>$taxonomy,
            'post_type_select_data'=>$post_type_select_data,
            'post_type_select'=>$post_type_select,
            'post_types'=>$post_type,'request'=>$request]);

    }

    public function create($type_id,$slug){
        $type=DB::table('post_types')->where('id',$type_id)->first();
        if($type){
            
            $taxonomy=DB::table('taxonomy')->where('id_post_type',$type->id)->get();

            return (view('admin.pages.data.create')->with(['taxonomy'=>$taxonomy,'post_type'=>$type,'rand'=>Auth::User()->id.'-'.date('ymdhis').'-'.rand(0,100)]));

        }else{

            return abort(404);
        }


    }


    public function store(Request $request){
        if(!in_array($request->id_post_type, $this->post_type_list['id'])){
            return back();
        }

        $rand=$request->rand;
        $dokumen=[
            'count'=>0,
            'path_file_pages'=>storage_path('app/public/dokumen_laporan/'.$request->id_post_type.'/'.$request->id_taxonomy.'/'.$rand),
            'path_file_pages_save'=>Storage::url('dokumen_laporan/'.$request->id_post_type.'/'.$request->id_taxonomy.'/'.$rand),
            'path_file'=>null
        ];

        if($request->dokumen){
            $path=Storage::put('/public/dokumen_laporan/'.$request->id_post_type.'/'.$request->id_taxonomy.'/'.$rand,$request->dokumen);
            $path=Storage::url($path);

            $dokumen['path_file']=$path;

            $im = new \Imagick(app_path('../public/'.$path));
            $dokumen['count']=$im->getNumberImages();
            $count = $im->getNumberImages();


            for ($x = 1;$x <= $im->getNumberImages(); $x++) {
              $im->previousImage();
               $im->setImageBackgroundColor('#ffffff');
                $im->setImageFormat("jpeg");

              $im->writeImage($dokumen['path_file_pages'].'/page_'.$count.'.png');
              if($count==1){

               
                $im->setImageCompressionQuality(80);
                $im->writeImage($dokumen['path_file_pages'].'/cover'.'.png');
              }

              $count--; 
            }
          

        }

        $a=Data::create([
            // 'title'=>$request->perihal??"".$request->id_taxonomy,
            'perihal'=>$request->prihal,
            'id_taxonomy'=>$request->id_taxonomy,
            'id_post_type'=>$request->id_post_type,
            'no_dokumen'=>$request->no_dokumen,
            'id_user'=>Auth::User()->id,
            'data_date'=>TM::parse($request->data_date),
            'max_pages'=>$dokumen['count'],
            'path_file'=>$dokumen['path_file'],
            'path_file_pages'=>$dokumen['count']?$dokumen['path_file_pages_save']:null,
            'data-trixFields'=>request('data-trixFields'),
            'attachment-data-trixFields'=>request('attachment-data-trixFields'),
        ]);

    	




        if($a){
            $a->update([
                'path_file'=>$path
            ]);
            return redirect()->route('admin.data.index',['post_type'=>$request->id_post_type]);
        }else{
            return abort(500);
        }



    }

    public function render($id){

        $data=DB::table('data as d')
        ->join('taxonomy as tx','tx.id','=','d.id_taxonomy')
        ->join('post_types as pt','pt.id','=','d.id_post_type')
        ->selectRaw("d.*,tx.name as name_taxonomy,pt.name as name_post_type")
        ->where('d.id',$id)
        ->first();
        if($data){
            if(!in_array($data->id_post_type, $this->post_type_list['id'])){
                return abort(404);
            }

            if($data->path_file_pages){
                return static::flipbook($data);
            }


        }
    }


    public static function flipbook($data){
            $flip_asset=[];
            for($i=0;$i<$data->max_pages;$i++){
                $flip_asset[]=$data->path_file_pages.'/page_'.($i+1).'.png';
            }

        return view('admin.pages.file-render.flipbook')->with(['data'=>$data,'flip_asset'=>$flip_asset]);

    } 

    public function edit($id){
    	$model=Data::find($id);
        if($model){
            if(!in_array($model->id_post_type, $this->post_type_list['id'])){
                return abort(404);
            }


            $taxonomy=DB::table('taxonomy')->where('id_post_type',$model->id_post_type)->get();
             $data=DB::table('data as d')
                ->join('taxonomy as tx','tx.id','=','d.id_taxonomy')
                ->join('post_types as pt','pt.id','=','d.id_post_type')
                ->selectRaw("d.*,tx.name as name_taxonomy,pt.name as name_post_type")
                ->where('d.id',$id)
                ->first();
            $rand=explode('/',explode('/storage/dokumen_laporan/'.$model->id_post_type.'/'.$model->id_taxonomy.'/',$model->path_file)[1])[0];

        

            return view('admin.pages.data.edit')->with([
                'model'=>$model,
                'data'=>$data,
                'rand'=>$rand,
                'taxonomy'=>$taxonomy
            ]);

        }
    }
}
