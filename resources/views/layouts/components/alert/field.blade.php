@if($errors->first($field))
    {!! $errors->first($field, '<p><span class="text-danger">:message</span></p>') !!}
@endif
