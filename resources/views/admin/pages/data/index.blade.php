
@extends('adminlte::page')


@section('content_header')

    <h1>DATA {{strtoupper(!empty($post_type_select_data)?$post_type_select_data->name:'')}}</h1>
 
@stop


@section('content')
<div class="box box-solid">
	<div class="box-header with-border">
		<form action="{{url()->full()}}" method="get" id="form-filter">
			  <div class="row">
		  	<div class="col-md-12">
		  		<a href="{{route('admin.data.create',['type_id'=>$post_type_select,'slug'=>Str::slug((!empty($post_type_select_data)?$post_type_select_data->name:''))])}}" class="btn btn-primary">TAMBAH DATA {{strtoupper(!empty($post_type_select_data)?$post_type_select_data->name:'')}}</a>
		  		<hr>
		  	</div>
	   	<div class="col-md-4">
		   	<div class="form-group">
		   		<label>JENIS DATA</label>
		    		<select class="form-control filter-data" name="post_type">
		    			@foreach($post_types as $pt)
		    				<option value="{{$pt->id}}" {{($post_type_select==$pt->id?'selected':'')}}>{{$pt->name}}</option>
		    			@endforeach
		    		</select>
		    		
		    	
		    </div>

   		</div>
   		<div class="col-md-4">
   			<div class="form-group">
			   		<label>BIDANG</label>

	   				<select class="form-control filter-data" name="taxonomy" name="taxonomy">
	   					<option value="">-</option>
	   					@foreach($taxonomy as $pt)
			    				<option value="{{$pt->id}}" {{$request->taxonomy==$pt->id?'selected':''}}>{{$pt->name}}</option>
			    			@endforeach
	   				</select>
	   			</div>
	   		</div>
	   		<div class="col-md-4">
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
						<th>BIDANG</th>
						<th>PERIHAL</th>
						<th>TANGGAL DOKUMEN</th>
						<th>TANGGAL ENTRY</th>
						<th>TANGGAL UPDATE</th>
						<th>PERSONIL PEMBUAT</th>
						<th>PERSONIL PENYUNTING</th>
						<th>DOKUMEN</th>
						<th>ISI</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $d)
						<tr>
							<td>{{$d->id}}</td>
							<td>{{$d->name_taxonomy}}</td>
							<td>{{$d->perihal}}</td>
							<td>{{TM::parse($d->data_date)->format('d F Y')}}</td>
							<td>{{TM::parse($d->created_at)->format('d F Y')}}</td>
							<td>{{TM::parse($d->updated_at)->format('d F Y')}}</td>
							<td>{{$d->uc_pangkat.' '.$d->uc_name.' ('.$d->uc_jabatan.')'}}</td>
							<td></td>
							<td>
								<a href="{{route('admin.data.render',['id'=>$d->id,'slug'=>Str::slug($d->perihal)])}}" class="btn btn-xs btn-primary" >Lihat Dokumen</a>
							</td>


							<td>{{ substr(str_replace('&nbsp;','', strip_tags(preg_replace('/<figure.*.<\/figure>/', '', $d->content))), 0,100).
								(strlen(str_replace('&nbsp;','', strip_tags(preg_replace('/<figure.*.<\/figure>/', '', $d->content))))>100?'...':'') }} 
								</td>
								<td style="width: 200px;">
									<div class="btn-group">
										<a href="{{route('admin.data.edit',['id'=>$d->id])}}" class="btn btn-primary btn-xs">Update</a>
										<a href="javascript:void(0)" onclick="show_modal_delete('{{route('admin.data.delete',['id'=>$d->id])}}',{{$d->id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>

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
				<h4 class="modal-title">HAPUS DATA</h4>
			</div>
			<div class="modal-body">
				<p class="modal-delete-content"></p>
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

		function show_modal_delete(link,id){
			$('#modal-delete .modal-delete-content').html('Hapus Data ID '+id);
			$('#modal-delete-form').attr('action',link);
			$('#modal-delete').modal();
		}
		
		$('.filter-data').on('change',function(){
			$('#form-filter').submit();
		});
	</script>

@stop