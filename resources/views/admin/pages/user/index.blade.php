
@extends('adminlte::page')


@section('content_header')
    <h1>USERS</h1>
@stop

@section('content')
<div class="box box-solid">
	<div class="box-header with-border">
    <a class="btn btn-primary" href="{{route('admin.users.create')}}">TAMBAH USER</a>
    <hr>
		<form action="{{url()->full()}}" method="get" id="form-filter">
			<div class="row">
		  	
			   	<div class="col-md-4">
				   	<div class="form-group">
				   		<label>JENIS ROLE</label>
				    		<select class="form-control filter-data" name="role">
				    			<option value="">-</option>

				    			@foreach($role as $k=> $pt)
				    				<option value="{{$k}}" {{$k==$request->role?'selected':''}}>{{$pt}}</option>
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
						<th>NRP</th>
						<th>PANGKAT</th>
						<th>NAMA</th>
						<th>JABATAN</th>
						<th>EMAIL</th>
						<th>ROLE</th>
						<th>POST TYPE</th>
						<th>AKSI</th>

						
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $d)
						<tr>
							<td>{{$d->id}}</td>
							<td>{{$d->nrp}}</td>
							<td>{{$d->pangkat}}</td>
							<td>{{$d->name}}</td>
							<td>{{$d->jabatan}}</td>
							<td>{{$d->email}}</td>
							<td>{{isset($role[$d->role])?$role[$d->role]:''}}</td>
							<td>
								@if($d->role!=1)
									({{count($d->post_types!=''?explode(',',$d->post_types??''):[])}}) 
									{{($d->post_types)}}
								@else
									-
								@endif

							</td>
							<td>
								<div class="btn-group">
									<a href="{{route('admin.users.edit',['id'=>$d->id])}}" class="btn btn-xs btn-primary">Update</a>
									<button class="btn btn-xs btn-danger">
										<i class="fa fa-trash"></i>
									</button>
								</div>
							</td>

						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$data->links()}}
	</div>
</div>

@stop

@section('js')
	<script type="text/javascript">
		
		$('.filter-data').on('change',function(){
			$('#form-filter').submit();
		});
	</script>

@stop