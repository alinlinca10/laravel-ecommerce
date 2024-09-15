<?php flash($msg)->success() ?>
@if(isset($url))
<p class="text-center">{!! __('partials.redirectioning') !!}...</p>
<script type="text/javascript">
    window.location.href = '{!! $url !!}';
</script>
@endif
@if(isset($reload))
  @if($reload == true)
  <p class="text-center">{!! __('partials.reload') !!}...</p>
  <script type="text/javascript">
      location.reload();
  </script>
  @endif
@endif
