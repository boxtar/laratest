<div class="form-group">
	{!! Form::label('name', 'Name: ') !!}
	{!! Form::text('name', null, ['class'=>'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('email', 'E-mail: ') !!}
	{!! Form::text('email', null, ['class'=>'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('profile_link', 'Unique Profile ID: ') !!}
	{!! Form::text('profile_link', null, ['class'=>'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('password', 'Password: ') !!}
	{!! Form::password('password', ['class'=>'form-control', 'required' => 'required']) !!}
</div>

<div class="form_group">
	{!! Form::label('password_confirmation', 'Confirm Password: ') !!}
	{!! Form::password('password_confirmation', ['class'=>'form-control', 'required' => 'required']) !!}
</div>
<br>
<div class="form-group">
	{!! Form::submit($submitButtonText, ['class'=>'btn btn-primary form-control']) !!}
</div>