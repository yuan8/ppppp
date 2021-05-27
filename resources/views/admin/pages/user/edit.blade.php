

@extends('adminlte::page')

@section('title', '')

@section('content_header')
    <h1>UPDATE  USER {{$data->name}}</h1>
@stop


@section('content')
	
  <div class="box box-solid">
  <form action="{{route('admin.users.update',['id'=>$data->id])}}" method="post">
  	@csrf
    @method('PUT')
  		<div class="box-body">
  		<div class="row">
  			<div class="col-md-6">
  				<div class="form-group">
  					<label>NAMA</label>
  					<input type="text" class="form-control" required="" value="{{$data->name}}" name="name">
  				</div>
  				<div class="form-group">
  					<label>NRP</label>
  					<input type="text" value="{{$data->nrp}}" class="form-control" required="" name="nrp">
  				</div>
  				<div class="form-group">
  					<label>PANGKAT</label>
  					<input type="text" value="{{$data->pangkat}}" class="form-control" required="" name="pangkat">
  				</div>
  				<div class="form-group">
  					<label>JABATAN</label>
  					<input type="text" value="{{$data->jabatan}}" class="form-control" required="" name="jabatan">
  				</div>
  			</div>
  			<div class="col-md-6">
  			
          @can('is_supper')
  				<div class="form-group">
  					<label>ROLE</label>
  					<select class="form-control" required="" name="role">
  						@foreach($role??[] as $k=> $r)
  						  <option value="{{$k}}"  {{$data->role==$k?'selected':''}} >{{$r}}</option>
  						@endforeach
  					</select>
  				</div>
          <div class="form-group" id="post_type_group">
            <label>POST TYPE</label>
            <select class="form-control" id="post_type" name="id_post_type[]" multiple="">
              @foreach ($post_types as $element)
                <option value="{{$element->id}}" {{in_array($element->id,$data->post_type)?'selected':''}} >{{$element->name}}</option>
              @endforeach
            </select>
          </div>
          @endcan
  				
  			</div>
  		</div>
      
  		
  	</div>
  	<div class="box-footer">
  		<button class=" btn btn-primary" type="submit">UPDATE</button>
  	</div>
  	
  </form>
  </div>
  <div class="box-solid box">
    <div class="box-header with-border">
      UPDATE PASSWORD
    </div>
   <form action="{{route('admin.users.password',['id'=>$data->id])}}" method="post">
     @csrf
     @method('PUT')
      <div class="box-body">
        @if(!Auth::User()->can('is_supper'))
         <div class="form-group">
            <label>PASSWORD LAMA</label>
            <input type="password" class="form-control" required="" name="old_password">
          </div>
        @endif
        <div class="form-group">
            <label>UPDATE PASSWORD</label>
            <input type="password" class="form-control" required="" name="password">
          </div>
          <div class="form-group">
            <label>UPDATE KONFIRMASI PASSWORD </label>
            <input type="password" class="form-control" required=""  name="password_confirmation">
          </div>
       </div>
       <div class="box-footer">
         <button type="submit" class="btn btn-primary">UPDATE</button>
       </div>
   </form>
  </div>


 @stop

 @section('js')

 <script type="text/javascript">

 	$('[name="role"]').on('change',function(){
 		if(this.value==1){
 			$('#post_type_group').css('display','none');
 		}else{
 			$('#post_type_group').css('display','block');

 		}
 	});

  $('[name="role"]').val({{$data->role}});
 	$('[name="role"]').trigger('change');

 	$('#post_type').select2();
 </script>
 @stop