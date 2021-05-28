<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Validator;
use TM;
use Alert;
use Storage;
class PersonilCtrl extends Controller
{
    //

    public function delete($id){
    	

		$data=DB::table('personil')->where('id',$id)
		->delete();
    	if($data){

    		Alert::success('Berhasil','Berhasil Menghapus Data Personil');
    	}else{
    		Alert::error('Gagal','Gagal Menghapus Data Personil');

    	}

    	return back();

    }

	public function edit($id){
		$data=DB::table('personil')->where('id',$id)->first();
		$rand=Auth::User()->id.'-'.date('dmyhi').'-'.rand(0,100);
		if($data){
			$data->pendidikan_umum=collect(static::meta_pendidikan($data->pendidikan_umum));
			$data->pendidikan_bagian_personil=collect(static::meta_pendidikan($data->pendidikan_bagian_personil));
			$data->order=collect(static::meta_pendidikan($data->order));

			return view('admin.pages.personil.edit')->with([
				'data'=>$data,
				'rand'=>$rand
			]);

		}else{
			return abort(404);
		}
	}

	static function meta_pendidikan($pendidikan){
		$data=json_decode($pendidikan,true);
		foreach ($data??[] as $key => $value) {
			$data[$key]['file_recorded']=$value['file_recorded']?url($value['file_recorded']):null;
			$data[$key]['id']=$key;
		}
		return collect($data);
	}

	public function store(Request $request){
		$valid=Validator::make($request->all(),[
			'name'=>'required|string',
			'jabatan'=>'required|string',
			'pangkat'=>'required|string',
			'nrp'=>'required|string|unique:personil,nrp',
		]);


		if($valid->fails()){
			Alert::error('',$valid->errors()->first());
			return back()->withInputs();
		}

		$pendidikan_umum=[];

		if($request->pendidikan_umum){
			foreach ($request->pendidikan_umum as $key => $value) {
				$pm=[
					'label'=>$value['label'],
					'tag'=>$value['tag'],
					'file_recorded'=>isset($value['file_recorded'])?str_replace(url(''), '', $value['file_recorded']):null

				];



				if(!empty($request->pendidikan_umum[$key]['file'])){
					$pm['file_recorded']=Storage::put('public/personil/'.$request->rand,$value['file']);
					$pm['file_recorded']=Storage::url($pm['file_recorded']);

				}

				$pendidikan_umum[]=$pm;
			}
		}

		$order=[];

		if($request->order){
			foreach ($request->order as $key => $value) {
				$pm=[
					'label'=>$value['label'],
					'tag'=>$value['tag'],
					'file_recorded'=>isset($value['file_recorded'])?str_replace(url(''), '', $value['file_recorded']):null

				];

				if(!empty($request->order[$key]['file'])){
					$pm['file_recorded']=Storage::put('public/personil/'.$request->rand,$value['file']);
					$pm['file_recorded']=Storage::url($pm['file_recorded']);

				}

				$order[]=$pm;
			}
		}



		$pendidikan_bagian_personil=[];
		if($request->pendidikan_bagian){
			foreach ($request->pendidikan_bagian??[] as $key => $value) {

				$pm=[
					'label'=>$value['label'],
					'tag'=>$value['tag'],
					'file_recorded'=>isset($value['file_recorded'])?str_replace(url(''), '', $value['file_recorded']):null

				];

				if(!empty($request->pendidikan_bagian[$key]['file'])){
					$pm['file_recorded']=Storage::put('public/personil/'.$request->rand,$value['file']);
					$pm['file_recorded']=Storage::url($pm['file_recorded']);
				}

				$pendidikan_bagian_personil[]=$pm;
			}
		}




		$data=DB::table('personil')->insert([
			'name'=>$request->name,
			'jabatan'=>$request->jabatan,
			'nrp'=>$request->nrp,
			'pangkat'=>$request->pangkat,
			'pendidikan_umum'=>str_replace('" : "', '":"', json_encode($pendidikan_umum)),
			'pendidikan_bagian_personil'=>str_replace('" : "', '":"',json_encode($pendidikan_bagian_personil)),
			'order'=>str_replace('" : "', '":"', json_encode($order??[])),
			'id_user_c'=>Auth::User()->id,
			'created_at'=>TM::now(),
			'updated_at'=>TM::now(),
		]);


		if($data){
			Alert::success('Berhasil','Berhasil Menambahkan Personil');
		}else{
			Alert::error('Gagal','Gagal Menambahkan Personil');

		}

		return redirect()->route('admin.personil.index');

	}


	public function update($id,Request $request){

		$valid=Validator::make($request->all(),[
			'name'=>'required|string',
			'jabatan'=>'required|string',
			'pangkat'=>'required|string',
			// 'nrp'=>'required|string|unique:personil,nrp',
		]);

		$check_nrp=DB::table('personil')->where([
			['nrp','=',trim($request->nrp)],
			['id','!=',$id]
		])->first();

		if($check_nrp){
			Alert::error('','NRP telah digunakan');
			return back()->withInputs();
		}

		if($valid->fails()){
			Alert::error('',$valid->errors()->first());
			return back()->withInputs();
		}
		$order=[];

		if($request->order){
			foreach ($request->order as $key => $value) {
				$pm=[
					'label'=>$value['label'],
					'tag'=>$value['tag'],
					'file_recorded'=>isset($value['file_recorded'])?str_replace(url(''), '', $value['file_recorded']):null

				];

				if(!empty($request->order[$key]['file'])){
					$pm['file_recorded']=Storage::put('public/personil/'.$request->rand,$value['file']);
					$pm['file_recorded']=Storage::url($pm['file_recorded']);

				}

				$order[]=$pm;
			}
		}


		$pendidikan_umum=[];
		if($request->pendidikan_umum){
			foreach ($request->pendidikan_umum as $key => $value) {
				$pm=[
					'label'=>$value['label'],
					'tag'=>$value['tag'],
					'file_recorded'=>str_replace(url(''), '', $value['file_recorded'])

				];
				if(!empty($request->pendidikan_umum[$key]['file'])){
					$pm['file_recorded']=Storage::put('public/personil/'.$request->rand,$value['file']);
					$pm['file_recorded']=Storage::url($pm['file_recorded']);
				}

				$pendidikan_umum[]=$pm;
			}
		}

		$pendidikan_bagian_personil=[];

		if($request->pendidikan_bagian_personil){
			foreach ($request->pendidikan_bagian_personil as $key => $value) {
				$pm=[
					'label'=>$value['label'],
					'tag'=>$value['tag'],
					'file_recorded'=>str_replace(url(''), '', $value['file_recorded'])
				];

				if(!empty($request->pendidikan_bagian_personil[$key]['file'])){
					$pm['file_recorded']=Storage::put('public/personil/'.$request->rand,$value['file']);
					$pm['file_recorded']=Storage::url($pm['file_recorded']);
				}

				$pendidikan_bagian_personil[]=$pm;
			}
		}

		$data=DB::table('personil')->where('id',$id)->update([
			'name'=>$request->name,
			'jabatan'=>$request->jabatan,
			'pangkat'=>$request->pangkat,
			'pendidikan_umum'=>str_replace('" : "', '":"', json_encode($pendidikan_umum)),
			'pendidikan_bagian_personil'=>str_replace('" : "', '":"',json_encode($pendidikan_bagian_personil)),
			'order'=>str_replace('" : "', '":"', json_encode($order??[])),
			'nrp'=>$request->nrp,
			'id_user_u'=>Auth::User()->id,
			'updated_at'=>TM::now(),
		]);


		if($data){
			Alert::success('Berhasil','Berhasil Mengubah Data Personil');
		}else{
			Alert::error('Gagal','Gagal Mengubah Data Personil');

		}

		return back();


	}

    public function create(){
    	$rand=Auth::User()->id.'-'.date('dmyhi').'-'.rand(0,100);
    	return view('admin.pages.personil.create')->with('rand',$rand);
    }

    public function index(Request $request){
    	$def=[

    	];

    	$where=[];

    	if($request->pendidikan_umum){
    		$def[]="p.pendidikan_umum like ('%\"tag\":\"".$request->pendidikan_umum."\"%')";
    	}

    	if($request->pendidikan_bagian_personil){
    		$def[]="p.pendidikan_bagian_personil like ('%\"tag\":\"".$request->pendidikan_bagian_personil."\"%')";
    	}

    	if($request->order){
    		$def[]="p.order like ('%\"tag\":\"".$request->order."\"%')";
    	}


    	if($request->q){
    		$where[]="p.name like '%".$request->q."%'";
    		// $where[]="p.jabatan like '%".$request->q."%'";
    		// $where[]="p.pangkat like '%".$request->q."%'";
    		// $where[]="p.nrp like '%".$request->q."%'";
    		// $where[]="p.dik_bang_pers like '%".$request->q."%'";
    	}
    	$whereRaw=[];



    	if(count($def)){
    		$wd=$def;

    		foreach ($def as $key => $value) {
    				foreach ($where as $k => $w) {
    					$wd[]=$w;
    				}
    		}
    		$wd=array_unique($wd);
    		$whereRaw[]='('.implode(') and (', $wd).')';


    	}else if(count($where)){
    		foreach ($where as $key => $value) {
    			$whereRaw[]=$value;
    		}
    	}

    	

    	$data=DB::table('personil as p');
    	if(count($whereRaw)){
    		$data=$data->whereRaw('('.implode(') or (', $whereRaw).')');

    	}
    	$data=$data->orderBy('p.id','desc')->paginate(10);

    	foreach ($data as $key => $value) {
    		$data[$key]->pendidikan_umum=static::meta_pendidikan($value->pendidikan_umum);
    		$data[$key]->pendidikan_bagian_personil=static::meta_pendidikan($value->pendidikan_bagian_personil);
    		$data[$key]->order=static::meta_pendidikan($value->order);
    	}

    	return view('admin.pages.personil.index')->with([
    		'data'=>$data,
    		'request'=>$request,
    	]);

    }
}
