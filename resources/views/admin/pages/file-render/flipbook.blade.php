
@extends('adminlte::page')
@section('content_header')
    <h1 class="text-center">{{'('.$data->no_dokumen.') '.$data->perihal.' '}}</h1>
    <p class="text-center">{{$data->name_post_type}} - {{$data->name_taxonomy}} - {{TM::parse($data->data_date)->format('d F y')}}</p>
    <hr>
    <a href="{{asset($data->path_file)}}" download="" class="btn btn-primary">DOWNLOAD DOKUMEN</a>
@stop

@section('content')
	<div class="wrapper-flip">
	  <div class="aspect">
	    <div class="aspect-inner">
	      <div class="flipbook" id="flipbook">
				@foreach ($flip_asset as $element)
					<div class="page" ><img src="{{asset($element.'?v='.date('his'))}}" draggable="false" alt=""></div>
				@endforeach
	
	      </div>
	    </div>
	  </div>
	</div>



<style type="text/css">
	
.wrapper-flip {
  align-items: center;
  display: flex;
  height: 90%;
  justify-content: center;
  width: 90%;
}
.turn-page-wrapper div div{
	border:1px solid #222;
}
.aspect {
  padding-bottom: 70%;
  position: relative;
  width: 100%;
}.aspect-inner {
  bottom: 0;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
}

.flipbook {
  height: 100%;
  transition: margin-left 0.25s ease-out;
  width: 100%;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.flipbook .page {
  height: 100%;
  width: 100%;
  background: #fff;

}
.flipbook .page img {
  max-width: 100%;
  height: 100%;
}
</style>
@stop


@section('js')
<script type="text/javascript" src="{{asset('bower_components/turnjs/turn.min.js')}}"></script>
<script type="text/javascript">

	$(window).ready(function() {

		var flipbookEL = document.getElementById('flipbook');window.addEventListener('resize', function (e) {
			  flipbookEL.style.width = '';
			  flipbookEL.style.height = '';

			  $(flipbookEL).turn('size', flipbookEL.clientWidth, flipbookEL.clientHeight);
		});

		$(flipbookEL).turn({
		    autoCenter: true
		});

		// $('#flipbook').turn({
		// 	display: 'single',
		// 	acceleration: true,
		// 	gradients: !$.isTouch,
		// 	elevation:50,
		// 	when: {
		// 		turned: function(e, page) {
		// 			console.log('Current view: ', $(this).turn('view'))
		// 		}
		// 	}
		// });
	});


	
</script>
@stop