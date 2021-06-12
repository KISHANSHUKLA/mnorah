@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.invitecode.title_singular') }}
    </div>

    <div class="card-body">
        <form id="formInviteCode" action="{{ route("admin.requestlist.update", [$invitecodeRequest->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
          
            <div class="form-group {{ $errors->has('invitecode') ? 'has-error' : '' }}">
                <label for="invitecode">Invite Code *
                    {{-- <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span> --}}
                </label>
                <select name="invitecode" id="invitecode" class="form-control select2" required>
                    @foreach($getInviteCodes as $id => $getInviteCode)
                   <option value="{{ $getInviteCode->id }}"  <?php if($getInviteCode->id == $invitecodeRequest->invitecode){ ?> selected <?php } ?>>{{ $getInviteCode->invitecode }}</option>
                    @endforeach
                </select>
                @if($errors->has('invitecode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('invitecode') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">Status *
                    {{-- <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span> --}}
                </label>
                <select name="status" id="status" class="form-control select2" required>
               
                   <option value="1"  <?php if($invitecodeRequest->status == 1){ ?> selected <?php } ?>> Reject </option>
                   <option value="2"  <?php if($invitecodeRequest->status == 2){ ?> selected <?php } ?>> Approve </option>
               
                </select>
                @if($errors->has('status'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.name_helper') }}
                </p>
            </div>
                                
            <div style="float: left;
            width: 100%;
            margin-top: 30px;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>

@endsection