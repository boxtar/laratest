<div class="form-group">
    {!! Form::label('name', 'Name: ') !!}
    {!! Form::text('name', null, ['required', 'class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('profile_link', 'Link to Profile: ') !!}
    {!! Form::text('profile_link', null, ['required', 'class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('type', 'Group Type: ') !!}
    {!! Form::select('group_type_id', ['1'=>'Music', '2'=>'Dance', '3'=>'Comedy'], null, ['required', 'class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary']) !!}
</div>