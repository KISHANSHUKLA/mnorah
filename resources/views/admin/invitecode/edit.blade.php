@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.invitecode.title_singular') }}
    </div>

    <div class="card-body">
        <form id="formInviteCode" action="{{ route("admin.invitecode.update", [$invitecode->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
          
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
            

                           
                                
                                
            <div style="float: left;
            width: 100%;
            margin-top: 30px;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>

@endsection