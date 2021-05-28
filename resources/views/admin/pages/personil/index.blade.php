
@extends('adminlte::page')
@section('content_header')
    <h1>PERSONIL</h1>
@stop


@section('content')


<div class="box box-solid">
	<div class="box-header with-border">
		<a href="{{route('admin.personil.create')}}" class="btn btn-primary">TAMBAH PERSONIL</a>
		<hr>
		<form action="{{url()->full()}}" method="get" id="form-filter">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>PENDIDIKAN UMUM</label>
						<select class="form-control filter-data" name="pendidikan_umum">
							<option value="">-</option>
							@foreach (config('websetting.meta.pendidikan_umum')??[] as $element)
								<option value="{{$element['tag']}}" {{$request->pendidikan_umum==$element['tag']?'selected':''}}>{{$element['text']}}</option>
							@endforeach
						</select>
					</div>
				</div>
				

				<div class="col-md-3">
					<div class="form-group">
						<label>PENDIDIKAN BAGIAN PERSONIL</label>
						<select class="form-control  filter-data" name="pendidikan_bagian_personil">
							<option value="">-</option>

							@foreach (config('websetting.meta.pendidikan_bagian_personil')??[] as $element)
								<option value="{{$element['tag']}}" {{$request->pendidikan_bagian_personil==$element['tag']?'selected':''}}>{{$element['text']}}</option>
							@endforeach
						</select>
					</div>
					
				</div>
				<div class="col-md-3">

					<div class="form-group">
						<label>DATA PENDUKUNG</label>
						<select class="form-control  filter-data" name="order">
							<option value="">-</option>

							@foreach (config('websetting.meta.order_tag')??[] as $element)
								<option value="{{$element}}" {{$request->order==$element?'selected':''}}>{{$element}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>SEARCH</label>
						<input type="text" class="form-control filter-data" name="q" value="{{$request
							->q}}">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>NAMA</th>
						<th>PANGKAT</th>
						<th>JABATAN</th>
						<th>PENDIDIKAN UMUM</th>
						<th>PENDIDIKAN BAGIAN PERSONIL</th>
						<th>DATA PENDUKUNG</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $element)
					<tr>
						<td>{{$element->id}}</td>

						<td>{{$element->name}}</td>
						<td>{{$element->pangkat}}</td>
						<td>{{$element->jabatan}}</td>
						<td>{{implode(', ',$element->pendidikan_umum->pluck('tag')->toArray())}}
						</td>
						<td>
							{{implode(', ',$element->pendidikan_bagian_personil->pluck('tag')->toArray())}}
						</td>
						<td>
							{{implode(', ',$element->order->pluck('tag')->toArray())}}
						</td>
						<td>
							<div class="btn-group">
								<a href="{{route('admin.personil.edit',['id'=>$element->id])}}" class="btn btn-primary btn-xs">Update</a>
								<button onclick="show_modal_delete('{{route('admin.personil.delete',['id'=>$element->id])}}',{{$element->id}},'{{$element->name}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
							</div>
						</td>



					</tr>

					@endforeach
				</tbody>
			</table>
		</div>
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

		function show_modal_delete(link,id,name){
			console.log(link,id,name);
			$('#modal-delete .modal-delete-content').html('Hapus Data ID '+id);
			$('#modal-delete .modal-delete-content-name').html(name);

			$('#modal-delete-form').attr('action',link);
			$('#modal-delete').modal();
		}
		
		
</script>
	<script type="text/javascript">
		
		$('.filter-data').on('change',function(){
			$('#form-filter').submit();
		});
	</script>

@stop