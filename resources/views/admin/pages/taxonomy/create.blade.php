

@extends('adminlte::page')
@section('content_header')
    <h1>TAMBAH  TAXONOMY DATA {{strtoupper($post_type->name)}} </h1>
@stop

@section('content')
	
  <div class="box box-solid">
  	 <form method="POST" enctype='multipart/form-data' action="{{ route('admin.taxonomy.store') }}">
      <input type="hidden" name="id_post_type" value="{{$post_type->id}}">
  	 	@csrf
  	 	<div class="box-body">
  	 		<div class="form-group">
  	 		<label>Nama</label>
  	 		<input type="text" name="name" class="form-control" required="">
  	 		</div>
  	 		<div class="form-group">
  	 		<label>Deskripsi</label>
  	 		<textarea class="form-control" name="description"></textarea>
  	 		</div>
		</div>
		<div class="box-footer">
			<button class="btn btn-primary ">TAMBAH</button>
		</div>

	</form>
</div>


  @stop
