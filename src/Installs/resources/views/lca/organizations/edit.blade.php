@extends("lca.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laracrm.adminRoute') . '/organizations') }}">Organizations</a> :
@endsection
@section("contentheader_description", $organization->$view_col)
@section("section", "Organizations")
@section("section_url", url(config('laracrm.adminRoute') . '/organizations'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Organization Edit : ".$organization->$view_col)

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
				{!! Form::model($organization, ['route' => [config('laracrm.adminRoute') . '.organizations.update', $organization->id ], 'method'=>'PUT', 'id' => 'organization-edit-form']) !!}
					@lca_form($module)

					{{--
					@lca_input($module, 'name')
					@lca_input($module, 'email')
					@lca_input($module, 'phone')
					@lca_input($module, 'website')
					@lca_input($module, 'assigned_to')
					@lca_input($module, 'connect_since')
					@lca_input($module, 'address')
					@lca_input($module, 'city')
					@lca_input($module, 'description')
					@lca_input($module, 'profile_image')
					@lca_input($module, 'profile')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laracrm.adminRoute') . '/organizations') }}">Cancel</a></button>
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
	$("#organization-edit-form").validate({

	});
});
</script>
@endpush
