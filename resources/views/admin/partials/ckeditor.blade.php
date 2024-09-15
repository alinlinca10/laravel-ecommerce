@if(isset($name) && isset($content))
  <input type="textarea" name="{{ $name }}" value="{{ $content }}" id="{{ $name }}" class="form-control ckeditor">

  {{-- {!! Form::textarea($name, $content ,['class' => 'form-control ckeditor','id' => $name]) !!} --}}

  {{-- @section('ckeditor')
    @parent
    <script type="text/javascript">
      loadCKEditor('{!! $name !!}',{!! isset($height) ? $height : 400 !!});
    </script>
  @stop --}}
@endif
