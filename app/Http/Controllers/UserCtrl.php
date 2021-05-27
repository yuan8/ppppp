<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Validator;
use Hash;
use Alert;
class UserCtrl extends Controller
{
    //


    public function update($id,Request $request){
    	$valid=Validator::make($request->all(),[
    		'name'=>'string|required',
            'jabatan'=>'string|required',
            'pangkat'=>'string|required',
    	]);

    	 if($valid->fails()){
    		Alert::error('',$valid->errors()->fisrt());

            return back()->withInputs();

        }

    	$data=DB::table('users')->where('id',$id)->first();
    	if($data){
    		$up=[
    			'name'=>$request->name,
    			'jabatan'=>$request->jabatan,
    			'pangkat'=>$request->pangkat,
    			'nrp'=>$request->nrp,
    		];

    		$chek_nrp=DB::table('users')
    		->where('nrp',trim($request->nrp))
    		->where('id','!=',$id)->first();

    		if($chek_nrp){
    			Alert::error('','NRP Telah digunakan sebelumnya');
    			return back();
    		}
    		if(Auth::User()->role<=1 and (Auth::User()->id!=$id) and ($data->role==2)){

    			$up['role']=$request->role;

    			if($up['role']==1){
    				DB::table('user_group_post_type')->where('id_user',$id)->delete();
    			}else{

    				foreach ($request->id_post_type??[] as $key => $value) {
    					# code...
    					DB::table('user_group_post_type')->insertOrIgnore([
    						'id_user'=>$id,
    						'id_post_type'=>$value
    					]);
    				}


    				if($request->id_post_type){

    					DB::table('user_group_post_type')->where('id_user',$id)
    					->whereNotIn('id_post_type',$request->id_post_type)
    					->delete();
    				}

                    if(count($request->id_post_type??[])==0){
                        DB::table('user_group_post_type')->where('id_user',$id)
                        ->delete();
                    }


    				
    			}


    		}else if($data->role==1){

    			if(!isset($required->id_post_type)){
    				DB::table('user_group_post_type')->where('id',$id)
    				->delete();
    			}

    		}

    		$u=DB::table('users')->where('id',$id)
    		->update($up);

    		if($up){
    			Alert::success('Berhasil','Data Berhasil Di Update');

    		}else{
    			Alert::success('Error','Data Tidak Berhasil Di Update');

    		}



    	}

    	return back();

    }

	public function update_password($id,Request $request){
		if(Auth::User()->role!=1){
			if(Auth::User()->id!=$id){
    			Alert::error('','Data Tidak Dapat di Akses');

				return back();
			}

			$valid_rule=[
				'password'=>'confirmed|string|min:8|string',
				'old_password'=>'required|string|min:8'
			];

			if(!Hash::check(Auth::User()->password, Hash::make($request->old_password) )){
				// password tidak cocok;
    			Alert::error('','Password Tidak Cocok');


				return back();
			}else{
			}

		}else{
			$valid_rule=[
				'password'=>'confirmed|string|min:8|string',
			];

		}

		$valid=Validator::make($request->all(),$valid_rule);

		if($valid->fials()){
    			Alert::error('',$valid->errors()->fisrt());

			return back()->withInputs();
		}

		$pass=DB::table('users')->where('id',$id)->update([
			'password'=>Hash::make($request->password)
		]);

		if($pass){
    			Alert::success('Berhasil','Password Berhasil Di Update');


		}else{
    			Alert::error('','Password Tidak Berhasil Di Update');

		}

		return back();

	}


	static $role=[
    		"2"=>'ADMIN',
    		"1"=>'SUPER ADMIN',

    	];


   public function edit($id){
   		$data=DB::table('users')->where('id',$id)->first();
   		$post_types=DB::table('post_types')->get();

   		


   		if($data){

   			$post_types_u=DB::table('user_group_post_type as gpt')
   			->join('post_types as pt','gpt.id_post_type','=','pt.id')
   			->where('gpt.id_user',$id)
   			->selectRaw('pt.*')
   			->get()->pluck('id')->toArray();

   			$data->post_type=$post_types_u??[];

   			return view('admin.pages.user.edit')->with([
   				'post_types'=>$post_types,
   				'data'=>$data,
   				'role'=>static::$role]);
   		}

   } 

   public function store(Request $request){

        $valid=Validator::make($request->all(),[
            'password'=>'string|confirmed|min:8',
            'email'=>'email|unique:users,email',
            'nrp'=>'string|unique:users,nrp',
            'name'=>'string|required',
            'jabatan'=>'string|required',
            'pangkat'=>'string|required',
            'role'=>'numeric|required|in:1,2'
        ]);

        if($valid->fails()){
    		Alert::error('Gagal',$valid->errors()->first());

            return back()->withInputs();

        }

        $data=[
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
            'email'=>$request->email,
            'nrp'=>$request->nrp,
            'jabatan'=>$request->jabatan,
            'pangkat'=>$request->pangkat,
            'role'=>$request->role,
        ];




        $user=DB::table('users')->insertGetId($data);

        if($user){
            if($request->role){
                foreach ($request->id_post_type??[] as $key => $value) {
                    DB::table('user_group_post_type')->insertOrIgnore([
                    	'id_user'=>$user,
                    	'id_post_type'=>$value
                    ]);
                }
            }
        }



        if($user){
    		Alert::success('Berhasil','User Berhasil Di Tambah');

        	return redirect()->route('admin.users.index');

        }else{
    		Alert::error('Gagal','User Tidak Berhasil Di Tambah');

        	return back();
        }



    }



	public function create(){
		$post_types=DB::table('post_types')->get();

		return view('admin.pages.user.create')->with(['role'=>static::$role,'post_types'=>$post_types]);
	}

    public function index(Request $request){

        
    	$def=[
    		[
    			'u.id <>'.Auth::User()->id
    		]

    	];

    	$where=[];

    	if($request->role){
    			$def[0][]="u.role = '".$request->role."'";
    	}

    	

    	if($request->q){
    		$where[]="u.name like '%".$request->role."%'";
    		$where[]="u.email like '%".$request->role."%'";
    		$where[]="pt.name like '%".$request->role."%'";

    	}

    	$whereRAW=[];

    	if(count($where)){
    		if(count($def)){
    			foreach ($where as $k => $w) {
	    				
	    			foreach ($def as $key => $value) {
	    				$w=array_merge($w,$value);
	    				$whereRAW[]='('.implode(' and ', $w).')';
		    			
	    			}
	    		}
    		}else{
    			$whereRAW=$where;
    		}
    	}else{

    		foreach ($def as $key => $value) {
    			$whereRAW[]='('.implode(' and ', $value).')';
    		}

    	}

    	$users=DB::table('users as u')
    	->leftjoin('user_group_post_type as gpt','gpt.id_user','=','u.id')
    	->leftjoin('post_types as pt','pt.id','=','gpt.id_post_type')
    	->selectRaw("u.*,group_concat(pt.name) as post_types")
    	->groupBy('u.id');
    	if(count($whereRAW)){
    		$users=$users->whereRaw(implode(' or ', $whereRAW));
    	}

    	$users=$users->paginate(10);

    	$users->appends($request->all());

    	


    	return view('admin.pages.user.index')->with([
    		'data'=>$users,
    		'request'=>$request,
    		'role'=>static::$role
    	]);

    }
}
