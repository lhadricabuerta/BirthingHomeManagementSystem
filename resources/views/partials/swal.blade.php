@php($swal = session('swal'))
@if($swal)
    <script>
        Swal.fire({
            icon: @json($swal['icon'] ?? 'info'),
            title: @json($swal['title'] ?? ''),
            text: @json($swal['text'] ?? ''),
            confirmButtonColor: 'var(--primary-color)'
        });
    </script>
@endif
