{{-- jquery --}}

<script src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>

{{-- jquery validate --}}

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>

{{-- DataTables --}}

<script src="{{ asset('/js/datatables.min.js') }}"></script>
<script src="{{ asset('/js/dataTables.dateTime.min.js') }}"></script>
<script src="{{ asset('/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/js/dataTables.editor.min.js') }}"></script>

{{-- bootstrap --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

{{-- Toastr --}}
<script src="{{ asset('/js/toastr.min.js') }}"></script>

<script>
    @if(session()->has('feedback'))
        @php $feedback = session()->get('feedback'); @endphp

        @if(session()->get('feedback.type') == 'toastr')
            toastr.{{ $feedback['action'] }}('{{ $feedback["message"] }}')
        @else
            swal(
                '{{ $feedback["message"] }}',
                '{{ $feedback["action"] }}'
            )
        @endif
    @endif
</script>