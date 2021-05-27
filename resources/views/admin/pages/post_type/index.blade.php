
@extends('adminlte::page')


@section('content_header')

    <h1>POST TYPE  </h1>
 
@stop


@section('content')
<div class="box box-solid">
	<div class="box-header with-border">

		<form action="{{url()->full()}}" method="get" id="form-filter">
			  <div class="row">
			  	<div class="col-md-12">
		  		<a href="{{route('admin.post-type.create')}}" class="btn btn-primary">TAMBAH POST TYPE</a>
		  		<hr>
		  	</div>
		  
   		
	   		<div class="col-md-12">
	   			<div class="form-group">
			   		<label>SEARCH</label>
	   				<input type="text"  name="q" class="form-control filter-data" placeholder="SEARCH..." value="{{$request->q}}">
	   			</div>
	   		</div>
   		</div>
		</form>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<table class="table-bordered table">
				<thead>
					<tr>
						<th>ID</th>
						<th>NAMA</th>
						<th>DESKRIPSI</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $d)
						<tr>
							<td>{{$d->id}}</td>

							<td>{{$d->name}}</td>

							<td>{{ substr(strip_tags(preg_replace('/<figure.*.<\/figure>/', '', $d->description)), 0,100) }} 
								</td>
							<td>
									<div class="btn-group">
									<a href="{{route('admin.post-type.edit',['id'=>$d->id])}}" class="btn btn-primary btn-xs">Update</a>
									<button onclick="show_modal_delete('{{route('admin.post-type.delete',['id'=>$d->id])}}',{{$d->id}},'{{$d->name}}')"   class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
								</div>

							</td>
								


						</tr>
						{{-- expr --}}
					@endforeach
				</tbody>
			</table>
		</div>
		{{$data->links()}}
	</div>
</div>
<div class="modal modal-danger fade" id="modal-delete">
	<div class="modal-dialog">
		<form action="" method="post" id="modal-delete-form">
			@csrf
			@method('DELETE')
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">HAPUS PERSONIL</h4>
			</div>
			<div class="modal-body">
				<p class="modal-delete-content"></p>
				<p ><b class="modal-delete-content-name"></b></p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">CANCLE</button>
				<button type="submit" class="btn btn-primary">HAPUS</button>
			</div>
		</div>
		</form>
	</div>
</div>

@stop

@section('js')
	<script type="text/javascript">
		
		$('.filter-data').on('change',function(){
			$('#form-filter').submit();
		});

		function show_modal_delete(link,id,name){
			console.log(link,id,name);
			$('#modal-delete .modal-delete-content').html('Hapus Data ID '+id);
			$('#modal-delete .modal-delete-content-name').html(name);

			$('#modal-delete-form').attr('action',link);
			$('#modal-delete').modal();
		}
		
	</script>

@stop