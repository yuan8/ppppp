

@extends('adminlte::page')


@section('content_header')
    <h1>EDIT DATA {{strtoupper($data->name_post_type)}}</h1>
@stop

@section('content')
	<div class="box box-solid">
			</div>
  <div class="box box-solid">
  	 <form method="POST" enctype='multipart/form-data' action="{{ route('admin.data.update',['id'=>$model->id]) }}">

  	 		<input type="hidden" name="rand" value="{{$rand}}">
            @csrf
            @method('PUT')
		  	<div class="box-body">
		            <div class="row">
		            	<div class="col-md-6">
		            		 <div class="form-group">
				            	<label>Bidang</label>
				            	<select class="form-control" name="id_taxonomy" required="">
				            		@foreach ($taxonomy as $element)
				            		<option value="{{$element->id}}" {{$model->id_taxonomy==$element->id?'selected':''}}>{{$element->name}}</option>
				            		@endforeach
				            	</select>
				            </div>
				            <div class="form-group">
				            	<label>Tanggal Data</label>
				            	<input class="form-control" type="date" name="data_date" required="" value="{{$model->data_date}}">
				            </div>
		            	</div>
		            	<div class="col-md-6">
		            		
		            		<div class="form-group">
				            	<label>No. Dokumen</label>
				            	<input type="text" class="form-control" value="{{$model->no_dokumen}}" name="no_dokumen" >
				            </div>
				            <div class="form-group">
				            	<label>Perihal</label>
				            	<input type="text" value="{{$model->perihal}}" class="form-control" name="prihal">
				            </div>
		            	</div>
		            </div>
		            <div class="form-group">
		            	<label>Isi</label>
		            	 @trix($model, 'content',
				            ['hideToolbar'=>false,
				            'hideButtonIcons'=>['decrease-nesting-level','increase-nesting-level']])
		            </div>
		            <div class="form-group">

				            	<label>Dokumen (PDF)</label>
				            	<div class="row">
				            		<div class="col-md-12">
				            				<a href="{{route('admin.data.render',['id'=>$model->id,'slug'=>Str::slug($model->perihal)])}}" class="btn btn-xs btn-primary" >Lihat Dokumen Tersimpan</a>
				            		</div>
				            	</div>
				            	<input type="file" class="form-control" accept="application/pdf" name="dokumen" >
				     </div>

		  	</div>
	  	<div class="box-footer">
	            <button class="btn btn-primary" type="SUBMIT">UPDATE</button>
	  		
	  	</div>
        </form>

  </div>
@stop