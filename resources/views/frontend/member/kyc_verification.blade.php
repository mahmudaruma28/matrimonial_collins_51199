@extends('frontend.layouts.member_panel')
@section('panel_content')


    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('KYC Verification Informations')}}</h5>
        </div>
        <div class="card-body">
            @php $user = Auth::user(); @endphp
            @if ($user->kyc_verified == 0 && $user->kyc_verification_info == null)
                <form action="{{ route('kyc_verification_info_store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Verification Informations')}}</label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="kyc_verification_info" class="selected-files" required>
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-sm">{{translate('Save')}}</button>
                    </div>
                </form>
            @elseif($user->kyc_verification_info != null)
                <div class="gutters-5 mb-3">
                    <div class="alert alert-warning">
                        {{ translate('Verification Information Sent. Please wait for the admin verification.') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
