@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Members')}}</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row gutters-5">
  				<div class="col text-center text-md-left">
  					<h5 class="mb-md-0 h6">{{ translate('All members') }}</h5>
  				</div>
		    </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Image')}}</th>
                            <th>{{translate('Member Code')}}</th>
                            <th data-breakpoints="md">{{translate('Name')}}</th>
                            <th data-breakpoints="md" class="text-right">{{translate('View Verification Info')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($verification_requests as $key => $user)
                            <tr>
                                <td>{{ ($key+1) + ($verification_requests->currentPage() - 1)*$verification_requests->perPage() }}</td>
                                <td>
                                    @if(uploaded_asset($user->photo) != null)
                                        <img class="img-md" src="{{ uploaded_asset($user->photo) }}" height="45px"  alt="{{translate('photo')}}">
                                    @else
                                        <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"  alt="{{translate('photo')}}">
                                    @endif
                                </td>
                                <td>{{ $user->code }}</td>
                                <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                <td class="text-right">
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        onclick="kcy_verification_information('{{ $user->id }}');"
                                        title="{{ translate('Refund Request Info') }}" href="javascript:void(0)">
                                        <i class="las la-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $verification_requests->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    <div class="modal fade" id="kcy_verification_information_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="kcy_verification_information_modal_content">

            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    
    function kcy_verification_information(user_id) {
            $.post('{{ route('user.kcy_informations') }}', {
                _token: '{{ @csrf_token() }}',
                user_id: user_id
            }, function(data) {
                $('#kcy_verification_information_modal_content').html(data);
                $('#kcy_verification_information_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }
</script>
@endsection
