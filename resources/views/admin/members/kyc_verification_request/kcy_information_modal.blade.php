<div class="modal-header">
    <h5 class="modal-title h6">{{ translate('KCY Verification Informations') }}</h5>
    <button type="button" class="close" data-dismiss="modal">
    </button>
</div>

<div class="modal-body">
    <div class="table-responsive">
        <table class="table mar-no">
            <tbody>
                <tr>
                    <td>{{ translate('Attachements') }}</td>
                    <td>
                        @foreach (explode(',', $user->kyc_verification_info) as $key => $attachment_id)
                            @php $attachment = \App\Upload::find($attachment_id);  @endphp
                            @if ($attachment)
                                @if ($attachment->type == 'image')
                                    <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" title="{{ $attachment->file_name }}">
                                        <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block text-reset">
                                            <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                <img src="{{ uploaded_asset($attachment->id) }}">
                                            </div>
                                            <div class="col body">
                                                <h6 class="d-flex">
                                                    <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                    <span class="ext flex-shrink-0">.{{ $attachment->extension }}</span>
                                                </h6>
                                            </div>
                                        </a>
                                    </div>                                    
                                @else
                                    <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" title="{{ $attachment->file_name }}">
                                        <a href="{{ route('download_attachment', $attachment->id) }}" target="_blank" class="d-block text-reset">
                                            <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                <i class="la la-file-text"></i>
                                            </div>
                                            <div class="col body">
                                                <h6 class="d-flex">
                                                    <span class="text-truncate title">{{ $attachment->file_original_name }}</span>
                                                    <span class="ext flex-shrink-0">.{{ $attachment->extension }}</span>
                                                </h6>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-secondary" role="alert">
                                    {{ translate('No attachment') }}
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <a href="{{ route('key_verification_accept', $user->id) }}" class="btn btn-sm btn-outline-success">{{translate('Accept')}}</a>
    <a href="{{ route('key_verification_reject', $user->id) }}" class="btn btn-sm btn-outline-danger">{{translate('Reject')}}</a>
</div>


