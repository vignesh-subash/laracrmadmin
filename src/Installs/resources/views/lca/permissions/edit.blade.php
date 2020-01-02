@extends("lca.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laracrm.adminRoute') . '/permissions') }}">Permissions</a> :
@endsection
@section("contentheader_description", $permission->$view_col)
@section("section", "Permissions")
@section("section_url", url(config('laracrm.adminRoute') . '/permissions'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Permission Edit : ".$permission->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">

	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($permission, ['route' => [config('laracrm.adminRoute') . '.permissions.update', $permission->id ], 'method'=>'PUT', 'id' => 'permission-edit-form']) !!}
					@lca_form($module)

					{{--
					@lca_input($module, 'name')
					@lca_input($module, 'display_name')
					@lca_input($module, 'description')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laracrm.adminRoute') . '/permissions') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#permission-edit-form").validate({

	});
});
</script>
@endpush
