

@extends('adminlte::page')
@section('content_header')
    <h1>UBAH TAXONOMY</h1>
@stop

@section('content')
	
  <div class="box box-solid">
  	 <form method="POST" enctype='multipart/form-data' action="{{ route('admin.taxonomy.update',['id'=>$data->id]) }}">
  	 	@csrf
      @method('PUT')

  	 	<div class="box-body">
  	 		<div class="form-group">
  	 		<label>Nama</label>
  	 		<input type="text" name="name" value="{{$data->name}}" class="form-control" required="">
  	 		</div>
  	 		<div class="form-group">
  	 		<label>Deskripsi</label>
  	 		<textarea class="form-control" name="description">{!!$data->description!!}</textarea>
  	 		</div>
		</div>
		<div class="box-footer">
			<button class="btn btn-primary ">UPDATE</button>
		</div>

	</form>
</div>


  @stop
