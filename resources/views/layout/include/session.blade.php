
@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: 'Success',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK',
        confirmButtonColor: '#4f46e5',
        allowOutsideClick: false,
        width: '350px',
        customClass: {
            title: 'success-title'

        }
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: 'Error',
        text: "{{ session('error') }}",
        confirmButtonText: 'OK',
        confirmButtonColor: '#4f46e5',
        allowOutsideClick: false,
        width: '350px',
        customClass: {
            title: 'error-title'
        }
    });
});
</script>
@endif
