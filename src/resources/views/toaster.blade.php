@if(session('flash_message'))
<script>
    $(function() {
        toastr.success("{{ session('flash_message') }}");
    });
</script>
@endif
