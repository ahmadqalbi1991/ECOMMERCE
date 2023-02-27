<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/parsley.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="{{ asset('assets/js/extensions/datatables.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/rvycvj06b5wb6aw8kx5gxthyfx5mb7iql0vnxsorwfhmyj56/tinymce/6/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

@stack('scripts')
<script>
        @if(Session::has('message'))
        @php
            $alert = explode('=', Session::get('message'));
        @endphp
    const Toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', swal.stopTimer);
                toast.addEventListener('mouseleave', swal.resumeTimer)
            }
        });

    Toast.fire({
        icon: '{{ $alert[0] }}',
        title: '{{ $alert[1] }}'
    });
    @endif

</script>
