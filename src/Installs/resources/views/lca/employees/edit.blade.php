@extends("lca.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laracrm.adminRoute') . '/employees') }}">Employees</a> :
@endsection
@section("contentheader_description", $employee->$view_col)
@section("section", "Employees")
@section("section_url", url(config('laracrm.adminRoute') . '/employees'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Employee Edit : ".$employee->$view_col)

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
				{!! Form::model($employee, ['route' => [config('laracrm.adminRoute') . '.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form']) !!}
					@lca_form($module)

					{{--
					@lca_input($module, 'name')
					@lca_input($module, 'designation')
					@lca_input($module, 'gender')
					@lca_input($module, 'mobile')
					@lca_input($module, 'mobile2')
					@lca_input($module, 'email')
					@lca_input($module, 'dept')
					@lca_input($module, 'city')
					@lca_input($module, 'address')
					@lca_input($module, 'about')
					@lca_input($module, 'date_birth')
					@lca_input($module, 'date_hire')
					@lca_input($module, 'date_left')
					@lca_input($module, 'salary_cur')
					--}}
                    <div class="form-group">
						<label for="role">Role* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							<?php $roles = App\Role::all(); ?>
							@foreach($roles as $role)
								@if($role->id != 1 || Entrust::hasRole(('SUPER_ADMIN')))
									@if($user->hasRole($role->name))
										<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
									@else
										<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endif
								@endif
							@endforeach
						</select>
					</div>
					<br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laracrm.adminRoute') . '/employees') }}">Cancel</a></button>
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
	$("#employee-edit-form").validate({

	});
});
</script>
@endpush
