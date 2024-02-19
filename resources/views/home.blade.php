@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('app.dashboard_container') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('app.you_are_logged_in_message') }}
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="test-button">{{ __('app.click_to_test_jquery_and_sweetalert2_message') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
$('#test-button').on('click', function(event) {
    event.preventDefault();
    Swal.fire({
        title: "{{ __('app.save_changes_message') }}",
        icon: 'warning',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "{{ __('app.save_confirm_button') }}",
        denyButtonText: "{{ __('app.save_deny_button') }}",
        cancelButtonText: "{{ __('app.save_cancel_button') }}"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("{{ __('app.saved_message') }}", "", "success");
        } else if (result.isDenied) {
            Swal.fire("{{ __('app.changes_not_saved_message') }}", "", "info");
        }
    });
});
</script>
@endsection
