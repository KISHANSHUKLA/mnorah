@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.invitecode.title_singular') }}
    </div>

    <div class="card-body">
        <form id="formInviteCode" action="{{ route("admin.invitecode.store") }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="form-group {{ $errors->has('invitecode') ? 'has-error' : '' }}">
                <label for="invitecode">{{ trans('cruds.invitecode.fields.invitecode') }} *</label>
                <input type="text" id="invitecode" name="invitecode" class="form-control" value="{{ old('invitecode', isset($invitecode) ? $invitecode->invitecode : '') }}">
                @if($errors->has('invitecode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('invitecode') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.invitecode.fields.invitecode_helper') }}
                </p>
            </div>

            
                <div class="form-group {{ $errors->has('church_id') ? 'has-error' : '' }}">
                 <label for="church_id">Church *
                     {{-- <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                     <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span> --}}
                 </label>
                 <select name="church_id" id="church_id" class="form-control select2" required>
                     @foreach($churchs as $id => $church)
                    <option value="{{ $church->id }}" {{ (in_array($id, old('roles', [])) || isset($church) && $church->id) ? 'selected' : '' }}>{{ $church->name }}</option>
                     @endforeach
                 </select>
                 @if($errors->has('church_id'))
                     <em class="invalid-feedback">
                         {{ $errors->first('church_id') }}
                     </em>
                 @endif
                 <p class="helper-block">
                     {{ trans('cruds.church.fields.name_helper') }}
                 </p>
             
         </div>

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
         
       
            <div style="float: left;
            width: 100%;
            margin-top: 30px;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>


@endsection
