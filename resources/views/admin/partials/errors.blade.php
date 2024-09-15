@if($errors->any())
  <script type="text/javascript">
  removeNotifications();
   @foreach($errors->all() as $key => $error)
     notification("{!! $error !!}", "danger");
   @endforeach
   </script>
@endif
