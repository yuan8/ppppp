

        @extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>TAMBAH  PRODUK {{strtoupper($post_type->name)}}</h1>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			{{$post_type->description}}
		</div>
	</div>
  <div class="box box-solid">
  	 <form method="POST" enctype='multipart/form-data' action="{{ route('admin.data.store') }}">
  	 		<input type="hidden" name="rand" value="{{$rand}}">
  	 		<input type="hidden" name="label" value="PRODUK">
            @csrf
            <input type="hidden" name="id_post_type" value="{{$post_type->id}}">
		  	<div class="box-body">
		  		
		            <div class="row">
		            	<div class="col-md-6">
		            		 <div class="form-group">
				            	<label>Bidang</label>
				            	<select class="form-control" name="id_taxonomy" required="">
				            		@foreach ($taxonomy as $element)
				            		<option value="{{$element->id}}">{{$element->name}}</option>
				            		@endforeach
				            	</select>
				            </div>
				            <div class="form-group">
				            	<label>Tanggal Data</label>
				            	<input class="form-control" type="date" name="data_date" required="">
				            </div>
				           
				             
		            	</div>
		            	<div class="col-md-6">
		            		
		            		<div class="form-group">
				            	<label>No. Dokumen</label>
				            	<input type="text" class="form-control" name="no_dokumen" >
				            </div>
				            <div class="form-group">
				            	<label>Prihal</label>
				            	<input type="text" class="form-control" name="prihal">
				            </div>
		            	</div>
		            </div>
		            <div class="form-group">
		            	<label>Isi</label>
		            	 @trix(\App\Data::class, 'content',
		            ['hideToolbar'=>false,
		            'hideButtonIcons'=>['decrease-nesting-level','increase-nesting-level']])
		            </div>
		            <div class="form-group">
				            	<label>No. Dokumen (PDF)</label>
				            	<input type="file" class="form-control" accept="application/pdf" name="dokumen" required="">
				     </div>

		  	</div>
	  	<div class="box-footer">
	            <button class="btn btn-primary" type="SUBMIT">SUBMIT</button>
	  		
	  	</div>
        </form>

  </div>
@stop