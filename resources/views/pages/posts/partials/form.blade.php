<div class="form-group">
	{!! Form::label('message', 'Message: ') !!}
	{!! Form::textarea('message', null, ['class'=>'form-control', 'maxlength'=>'150']) !!}
</div>

<div class="form-group">
	{!! Form::label('tag_list', 'Tags: ') !!}
	{!! Form::select('tag_list[]', $tags, null, ['class'=>'form-control', 'id'=>'tag_list', 'multiple']) !!}
</div>

<div class="form-group">
	{!! Form::submit($submitButtonText, ['class'=>'btn btn-primary']) !!}
</div>

@section('footer')
	<script>
		$('#tag_list').select2({
			placeholder: 'Select Tags'
		});
	</script>
@endsection