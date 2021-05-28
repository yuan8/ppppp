

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>TAMBAH  USER</h1>
@stop


@section('content')
	
  <div class="box box-solid">
  <form action="{{route('admin.users.store')}}" method="post">
  	@csrf
  		<div class="box-body">
  		<div class="row">
  			<div class="col-md-6">
  				<div class="form-group">
  					<label>NAMA</label>
  					<input type="text" class="form-control" required="" value="{{old('name')}}" name="name">
  				</div>
  				<div class="form-group">
  					<label>NRP</label>
  					<input type="text" value="{{old('nrp')}}" class="form-control" required="" name="nrp">
  				</div>
  				<div class="form-group">
  					<label>PANGKAT</label>
  					<input type="text" value="{{old('pangkat')}}" class="form-control" required="" name="pangkat">
  				</div>
  				<div class="form-group">
  					<label>JABATAN</label>
  					<input type="text" value="{{old('jabatan')}}" class="form-control" required="" name="jabatan">
  				</div>
  			</div>
  			<div class="col-md-6">
  				<div class="form-group">
  					<label>EMAIL</label>
  					<input type="email" value="{{old('email')}}" class="form-control" required="" name="email">
  				</div>
  				<div class="form-group">
  					<label>ROLE</label>
  					<select class="form-control" required="" name="role">
  						@foreach ($role as $k=> $r)
  						<option value="{{$k}}" {{old('role')==$k?'selected':''}}}>{{$r}}</option>
  							{{-- expr --}}
  						@endforeach
  						
  					</select>
  				</div>
  				<div class="form-group">
  					<label>PASSWORD</label>
  					<input type="password" class="form-control" required="" name="password">
  				</div>
  				<div class="form-group">
  					<label>KONFIRMASI PASSWORD </label>
  					<input type="password" class="form-control" required="" name="password_confirmation">
  				</div>
  			</div>
  		</div>
  		<div class="form-group" id="post_type_group">
  			<label>POST TYPE</label>
  			<select class="form-control" id="post_type" name="id_post_type[]" multiple="">
  				@foreach ($post_types as $element)
  					<option value="{{$element->id}}">{{$element->name}}</option>
  				@endforeach
  			</select>
  			
  		</div>
  		
  	</div>
  	<div class="box-footer">
  		<button class=" btn btn-primary" type="submit">TAMBAH</button>
  	</div>
  	
  </form>
  </div>

 @stop

 @section('js')


 <script type="text/javascript">

 	$('[name="role"]').on('change',function(){
 		console.log(this.value);
 		if(this.value==1){
 			$('#post_type_group').css('display','none');
 		}else{
 			$('#post_type_group').css('display','block');

 		}
 	});

 	$('[name="role"]').trigger('change');
 	$('#post_type').select2();
 </script>
 @stop