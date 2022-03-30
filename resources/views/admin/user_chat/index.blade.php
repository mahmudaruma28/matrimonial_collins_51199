@extends('admin.layouts.app')
@section('content')

<div class="card">
    <div class="card-header row gutters-5">
        <div class="col text-center text-md-left">
            <h5 class="mb-md-0 h6">{{translate('Create New Chat')}}</h5>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('user_chat.create') }}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="name">{{translate('Member 1')}}</label>
                    <select class="form-control aiz-selectpicker" data-live-search="true" name="member1" required>
                        <option value="">{{ translate('Select Member') }}</option>
                        @foreach($members as $member)
                            <option value="{{$member->id}}">{{ $member->first_name.' '.$member->last_name }} ({{ translate('Code').': '.$member->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="name">{{translate('Member 2')}}</label>
                    <select class="form-control aiz-selectpicker" data-live-search="true" name="member2" required>
                        <option value="">{{ translate('Select Member') }}</option>
                        @foreach($members as $member)
                            <option value="{{$member->id}}">{{ $member->first_name.' '.$member->last_name }} ({{ translate('Code').': '.$member->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mt-4">
                    <button type="submit" class="btn btn-primary">{{translate('Create')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <form class="" id="chat_list" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{translate('Chat Lists')}}</h5>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="{{ translate('Search by Name') }}" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
                    <div class="input-group-append">
                        <button class="btn btn-light" type="submit">
                            <i class="las la-search la-rotate-270"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Member 1')}}</th>
                    <th>{{translate('Member 2')}}</th>
                    <th>{{translate('Date')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chat_threads as $key => $chat_thread)
                  <tr>
                        <td>{{ ($key+1) + ($chat_threads->currentPage() - 1)*$chat_threads->perPage() }}</td>
                        <td>{{ $chat_thread->sender->first_name.' '.$chat_thread->sender->last_name ?? translate('Member Deleted') }}</td>
                        <td>{{ $chat_thread->receiver->first_name.' '.$chat_thread->receiver->last_name ?? translate('Member Deleted') }}</td>
                        <td>{{ $chat_thread->created_at }}</td>
                  </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $chat_threads->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')
    @include('modals.create_edit_modal')
@endsection

@section('script')
<script>
  
</script>
@endsection
