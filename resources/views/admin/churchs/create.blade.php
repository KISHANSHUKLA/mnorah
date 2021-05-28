@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.church.title_singular') }}
    </div>

    <div class="card-body">
        <form id="formEvent" action="{{ route("admin.churches.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="col-md-6 float-left">
               <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user_id">{{ trans('cruds.church.fields.name') }} *
                    {{-- <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span> --}}
                </label>
                <select name="user_id" id="user_id" class="form-control select2" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.name_helper') }}
                </p>
            </div>
        </div>

         <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($church) ? $church->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.denomination_helper') }}
                </p>
            </div>
        </div>

         <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                <label for="location">Location *</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ old('location', isset($church) ? $church->location : '') }}">
                @if($errors->has('location'))
                    <em class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.denomination_helper') }}
                </p>
            </div>
        </div>
        <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('denomination') ? 'has-error' : '' }}">
                <label for="denomination">{{ trans('cruds.church.fields.denomination') }} *</label>
                <input type="text" id="denomination" name="denomination" class="form-control" value="{{ old('denomination', isset($church) ? $church->denomination : '') }}">
                @if($errors->has('denomination'))
                    <em class="invalid-feedback">
                        {{ $errors->first('denomination') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.denomination_helper') }}
                </p>
            </div>
        </div>
        <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('venue') ? 'has-error' : '' }}">
                <label for="venue">{{ trans('cruds.church.fields.venue') }} *</label>
                <input type="text" id="venue" name="venue" class="form-control">
                @if($errors->has('venue'))
                    <em class="invalid-feedback">
                        {{ $errors->first('venue') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.venue_helper') }}
                </p>
            </div>
        </div>
        <div class="col-md-6 float-left">

            <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
                <label for="days">days *
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="days[]" id="days" class="form-control select2" multiple="multiple" required>
                    @foreach($days as $id => $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
                @if($errors->has('days'))
                    <em class="invalid-feedback">
                        {{ $errors->first('days') }}
                    </em>
                @endif
                
            </div>

        </div>
        <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('language') ? 'has-error' : '' }}">
                <label for="language">{{ trans('cruds.church.fields.language') }} *</label>
                <input type="text" id="language" name="language" class="form-control">
                @if($errors->has('language'))
                    <em class="invalid-feedback">
                        {{ $errors->first('language') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.language_helper') }}
                </p>
            </div>
        </div>
        <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('Social') ? 'has-error' : '' }}">
                <label for="Social">{{ trans('cruds.church.fields.Social') }} *</label>
                <input type="text" id="Social" name="Social" class="form-control">
                @if($errors->has('Social'))
                    <em class="invalid-feedback">
                        {{ $errors->first('Social') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.Social_helper') }}
                </p>
            </div>
        </div>
            <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('vision') ? 'has-error' : '' }}">
                <label for="vision">{{ trans('cruds.church.fields.vision') }} *</label>
                <input type="text" id="vision" name="vision" class="form-control">
                @if($errors->has('vision'))
                    <em class="invalid-feedback">
                        {{ $errors->first('vision') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.vision_helper') }}
                </p>
            </div>
            </div>
            <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('leadership') ? 'has-error' : '' }}">
                <label for="leadership">{{ trans('cruds.church.fields.leadership') }} *</label>
                <input type="text" id="leadership" name="leadership" class="form-control" >
                @if($errors->has('leadership'))
                    <em class="invalid-feedback">
                        {{ $errors->first('leadership') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.leadership_helper') }}
                </p>
            </div>
            </div>
            <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('ministries') ? 'has-error' : '' }}">
                <label for="ministries">{{ trans('cruds.church.fields.ministries') }} *</label>
                <input type="text" id="ministries" name="ministries" class="form-control" >
                @if($errors->has('ministries'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ministries') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.ministries_helper') }}
                </p>
            </div>
            </div>
            <div class="col-md-6 float-left">
            <div class="form-group {{ $errors->has('event') ? 'has-error' : '' }}">
                <label for="event">{{ trans('cruds.church.fields.event') }} *</label>
                <input type="text" id="event" name="event" class="form-control" >
                @if($errors->has('event'))
                    <em class="invalid-feedback">
                        {{ $errors->first('event') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.event_helper') }}
                </p>
            </div>
            </div>
            <div class="col-md-6 float-left">
            <div class="custom-file form-group {{ $errors->has('eventimage') ? 'has-error' : '' }}">
                <label for="eventimage">Event Image Upload *</label>
                <input type="file" multiple name="eventimage[]" class="custom-file-input" id="eventimage">
                <label style="    margin-top: 28px;" class="custom-file-label" for="eventimage">Choose file</label>
                @if($errors->has('eventimage'))
                <em class="invalid-feedback">
                    {{ $errors->first('eventimage') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('cruds.church.fields.event_helper') }}
            </p>
              </div>
            </div>

            {{-- <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('cruds.church.fields.roles') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <em class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.roles_helper') }}
                </p>
            </div> --}}
            <div style="float: left;
            width: 100%;
            margin-top: 30px;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>


@endsection
