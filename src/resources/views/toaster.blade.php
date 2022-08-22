@if(session('flash_message'))
<script>
    $(function() {
        toastr.success("{{ session('flash_message') }}");
    });
</script>
@elseif(session('error_message'))
<script>
    $(function() {
        toastr.error("{{ session('error_message') }}");
    });
</script>
@endif
