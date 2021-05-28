

@extends('adminlte::page')
@section('content_header')
    <h1>TAMBAH  PERSONIL</h1>
@stop

@section('content')
	
  <div class="box box-solid">
  	 <form method="POST" enctype='multipart/form-data' action="{{ route('admin.personil.store') }}">
  	 	@csrf
  	 	<div class="box-body">
        <input type="hidden" name="rand" value="{{$rand}}">
  	 		<div class="form-group">
  	 		  <label>NAMA</label>
  	 		  <input type="text" name="name" class="form-control" required=""  value="{{old('nama')}}">
  	 		</div>
          <div class="form-group">
          <label>NRP</label>
          <input type="text" name="nrp" class="form-control" required="" value="{{old('nrp')}}">
        </div>
        <div class="form-group">
          <label>PANGKAT</label>
          <input type="text" name="pangkat" class="form-control" required=""  value="{{old('pangkat')}}">
        </div>
        <div class="form-group">
          <label>JABATAN</label>
          <input type="text" name="jabatan" class="form-control" required=""  value="{{old('jabatan')}}">
        </div>

        <div class="form-group" id="content-pendidikan-umum" >
          <label>PENDIDIKAN UMUM</label>

          <div class="">

            <button class="btn btn-primary btn-xs"  v-on:click="add_row()" type="button">Tambah Pendidikan</button>
            <hr>
          </div>
          <div >
            <div v-for="itm in items ">
                 <div class="row">
                  <div class="col-md-1">
                    <a  v-bind:href="itm.file_recorded">
                      <img v-bind:src="itm.file_recorded" class="img-thumbnail" style="width:100%">
                    </a>
                  </div>
                   <div class="col-md-1 text-center">
                    <label class="">AKSI</label>
                    <div class="form-group text-center">
                      <button class="btn btn-xs btn-danger" v-on:click="remove(itm)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label>Jenis </label>

                    <select class="form-control" v-bind:name="'pendidikan_umum['+itm.id+'][tag]'" required="">
                        @foreach (config('websetting.meta.pendidikan_umum')??[] as $element)
                                <option value="{{$element['tag']}}" >{{$element['text']}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label>Label</label>
                    <input type="text" class="form-control" v-bind:name="'pendidikan_umum['+itm.id+'][label]'">
                  </div>
                  <div class="col-md-3">
                    <label>Ijazah/Sertifikat</label>
                    <input type="hidden" v-bind:name="'pendidikan_umum['+itm.id+'][file_recorded]'" v-model="itm.file_recorded">
                    <input type="file" accept="image/*" class="form-control" v-bind:name="'pendidikan_umum['+itm.id+'][file]'">
                  </div>
               </div>
              <hr>

            </div>
            
          </div>
        </div>
        <div class="form-group" id="content-pendidikan-bagain-personil">
          <label>PENDIDIKAN BAGIAN PERSONIL</label>
          <div>
            <button class="btn btn-primary btn-xs" v-on:click="add_row()" type="button">Tambah Pendidikan</button>
            <hr>
          </div>
          <div  >
             <div v-for="itm in items ">
                 <div class="row">
                  <div class="col-md-1">
                    <a  v-bind:href="itm.file_recorded"  >
                      <img v-bind:src="itm.file_recorded" class="img-thumbnail" style="width:100%">
                    </a>
                  </div>
                   <div class="col-md-1 text-center">
                    <label class="">AKSI</label>
                    <div class="form-group text-center">
                      <button class="btn btn-xs btn-danger" v-on:click="remove(itm)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </div>
                 <div class="col-md-3">
                    <label>Jenis </label>
                    <select class="form-control" v-bind:name="'pendidikan_bagian['+itm.id+'][tag]'" required="" v-model="itm.tag">
                        @foreach (config('websetting.meta.pendidikan_bagian_personil')??[] as $element)
                                <option value="{{$element['tag']}}" >{{$element['text']}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label>Label</label>
                    <input type="text" class="form-control" v-bind:name="'pendidikan_bagian['+itm.id+'][label]'" v-model="itm.label">
                  </div>
                  <div class="col-md-3">
                    <label>Ijazah/Sertifikat</label>
                       <input type="hidden" v-bind:name="'pendidikan_umum['+itm.id+'][file_recorded]'"  v-model="itm.file_recorded">
                    <input type="file"  accept="image/*"  class="form-control" v-bind:name="'pendidikan_bagian['+itm.id+'][file]'">
                  </div>
               </div>
            </div>
          </div>
        </div>
         <div class="form-group" id="content-data-lainya">
          <label>DATA PENDUKUNG</label>
          <div>
            <button class="btn btn-primary btn-xs" v-on:click="add_row()" type="button">Tambah Data Pendukung</button>
            <hr>
          </div>
          <div  >
             <div v-for="itm in items ">
                 <div class="row">
                  <div class="col-md-1">
                    <a  v-bind:href="itm.file_recorded"  >
                      <img v-bind:src="itm.file_recorded" class="img-thumbnail" style="width:100%">
                    </a>
                  </div>
                   <div class="col-md-1 text-center">
                    <label class="">AKSI</label>
                    <div class="form-group text-center">
                      <button class="btn btn-xs btn-danger" v-on:click="remove(itm)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </div>
                 <div class="col-md-3">
                    <label>Jenis </label>
                    <select class="form-control" v-bind:name="'order['+itm.id+'][tag]'" required="" v-model="itm.tag">
                        @foreach (config('websetting.meta.order_tag')??[] as $element)
                                <option value="{{$element}}" >{{$element}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label>Label</label>
                    <input type="text" class="form-control" v-bind:name="'order['+itm.id+'][label]'" v-model="itm.label">
                  </div>
                  <div class="col-md-3">
                    <label>File</label>
                       <input type="hidden" v-bind:name="'order['+itm.id+'][file_recorded]'"  v-model="itm.file_recorded">
                    <input type="file"  accept="image/*"  class="form-control" v-bind:name="'order['+itm.id+'][file]'">
                  </div>
               </div>
            </div>
          </div>
        </div>

  	 		
		</div>
		<div class="box-footer">
			<button class="btn btn-primary ">TAMBAH</button>
		</div>

	</form>
</div>



  @stop

  @section('js')
  <script type="text/javascript">
      var pendidikan_umum=new Vue({
        el:'#content-pendidikan-umum',
        data:{
          items:[]
        },
        methods:{
          add_row:function(){
            this.items.push({
              'tag':null,
              'id':this.items.length==0?0:this.items.length+1,
              'label':null,
              'file_recorded':null
            });
          },
          remove:function(item){
              this.items.splice(item.id,1);

              for (var i = 0; i < this.items.length; i++) {
                this.items[i].id=i;
              }
              
          }
        }
      });

       var pendidikan_bagian_personil=new Vue({
        el:'#content-pendidikan-bagain-personil',
        data:{
          items:[]
        },
        methods:{
          add_row:function(){
            this.items.push({
              'tag':null,
              'id':this.items.length==0?0:this.items.length+1,
              'label':null,
              'file_recorded':null
            });
          },
          remove:function(item){
              this.items.splice(item.id,1);
              for (var i = 0; i < this.items.length; i++) {
                this.items[i].id=i;
              }

          }


        }
      });

       var data_lainya=new Vue({
        el:'#content-data-lainya',
        data:{
          items:[]
        },
        methods:{
          add_row:function(){
            this.items.push({
              'tag':null,
              'id':this.items.length==0?0:this.items.length+1,
              'label':null,
              'file_recorded':null
            });
          },
          remove:function(item){
              this.items.splice(item.id,1);
              for (var i = 0; i < this.items.length; i++) {
                this.items[i].id=i;
              }

          }


        }
      });
  </script>
  @stop
