@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.invitecode.title_singular') }}
    </div>

    <div class="card-body">
        <form id="formInviteCodeImport" action="{{ route("admin.invitecode.import") }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="custom-file form-group {{ $errors->has('import') ? 'has-error' : '' }}">
                <label for="eventimage">Import *</label>
                <input type="file" name="import" class="custom-file-input" id="eventimage">
                <label style="    margin-top: 28px;" class="custom-file-label" for="eventimage">Choose file</label>
                @if($errors->has('import'))
                <em class="invalid-feedback">
                    {{ $errors->first('import') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('cruds.church.fields.import_helper') }}
            </p>
              </div>
         
       
            <div style="float: left;
            width: 100%;
            margin-top: 30px;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>

        <a href="{{ asset('uploads/dummy.xlsx') }}" download>Simple excel file</a>
    </div>

</div>


@endsection
