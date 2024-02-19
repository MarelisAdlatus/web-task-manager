@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verify_email_container') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.fresh_verification_link_has_been_sent_message') }}
                        </div>
                    @endif

                    {{ __('auth.check_your_email_for_verification_message') }}
                    {{ __('auth.if_you_did_not_receive_email_message') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.click_here_to_request_another_submit') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
