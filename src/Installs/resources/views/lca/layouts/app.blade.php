<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('lca.layouts.partials.htmlheader')
@show
<body class="{{ LCAConfigs::getByKey('skin') }} {{ LCAConfigs::getByKey('layout') }} @if(LCAConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" bsurl="{{ url('') }}" adminRoute="{{ config('laraadmin.adminRoute') }}">
<div class="wrapper">

	@include('lca.layouts.partials.mainheader')

	@if(LCAConfigs::getByKey('layout') != 'layout-top-nav')
		@include('lca.layouts.partials.sidebar')
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(LCAConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif
		@if(!isset($no_header))
			@include('la.layouts.partials.contentheader')
		@endif

		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		@if(LCAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
	</div><!-- /.content-wrapper -->

	@include('lca.layouts.partials.controlsidebar')

	@include('lca.layouts.partials.footer')

</div><!-- ./wrapper -->

@include('lca.layouts.partials.file_manager')

@section('scripts')
	@include('lca.layouts.partials.scripts')
@show

</body>
</html>
