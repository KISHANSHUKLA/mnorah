@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.church.title_singular') }}
    </div>

    <div class="card-body">
        <form id="formEvent" action="{{ route("admin.churches.update", [$church->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user_id">{{ trans('cruds.church.fields.name') }} *
                    {{-- <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span> --}}
                </label>
                <select name="user_id" id="user_id" class="form-control select2" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" <?php if($church->user_id == $user->id){?> selected <?php } ?>>{{ $user->name }}</option>
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
            <div class="form-group {{ $errors->has('venue') ? 'has-error' : '' }}">
                <label for="venue">{{ trans('cruds.church.fields.venue') }} *</label>
                <input type="text" id="venue" name="venue" class="form-control" value="{{ old('venue', isset($church) ? $church->venue : '') }}">
                @if($errors->has('venue'))
                    <em class="invalid-feedback">
                        {{ $errors->first('venue') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.venue_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
                <label for="days">{{ trans('cruds.church.fields.day') }} *</label>
                <input type="text" id="days" name="days" class="form-control date" value="{{ old('days', isset($church) ? $church->days : '') }}">
                @if($errors->has('days'))
                    <em class="invalid-feedback">
                        {{ $errors->first('days') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.day_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('language') ? 'has-error' : '' }}">
                <label for="language">{{ trans('cruds.church.fields.language') }} *</label>
                <input type="text" id="language" name="language" class="form-control" value="{{ old('language', isset($church) ? $church->language : '') }}">
                @if($errors->has('language'))
                    <em class="invalid-feedback">
                        {{ $errors->first('language') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.language_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('Social') ? 'has-error' : '' }}">
                <label for="Social">{{ trans('cruds.church.fields.Social') }} *</label>
                <input type="text" id="Social" name="Social" class="form-control" value="{{ old('Social', isset($church) ? $church->Social : '') }}">
                @if($errors->has('Social'))
                    <em class="invalid-feedback">
                        {{ $errors->first('Social') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.Social_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('vision') ? 'has-error' : '' }}">
                <label for="vision">{{ trans('cruds.church.fields.vision') }} *</label>
                <input type="text" id="vision" name="vision" class="form-control" value="{{ old('vision', isset($church) ? $church->vision : '') }}">
                @if($errors->has('vision'))
                    <em class="invalid-feedback">
                        {{ $errors->first('vision') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.vision_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('leadership') ? 'has-error' : '' }}">
                <label for="leadership">{{ trans('cruds.church.fields.leadership') }} *</label>
                <input type="text" id="leadership" name="leadership" class="form-control" value="{{ old('leadership', isset($church) ? $church->leadership : '') }}">
                @if($errors->has('leadership'))
                    <em class="invalid-feedback">
                        {{ $errors->first('leadership') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.leadership_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('ministries') ? 'has-error' : '' }}">
                <label for="ministries">{{ trans('cruds.church.fields.ministries') }} *</label>
                <input type="text" id="ministries" name="ministries" class="form-control" value="{{ old('ministries', isset($church) ? $church->ministries : '') }}">
                @if($errors->has('ministries'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ministries') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.ministries_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('event') ? 'has-error' : '' }}">
                <label for="event">{{ trans('cruds.church.fields.event') }} *</label>
                <input type="text" id="event" name="event" class="form-control" value="{{ old('event', isset($church) ? $church->event : '') }}">
                @if($errors->has('event'))
                    <em class="invalid-feedback">
                        {{ $errors->first('event') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.church.fields.event_helper') }}
                </p>
            </div>
            <div class="custom-file form-group {{ $errors->has('eventimage') ? 'has-error' : '' }}">
                <label for="eventimage">Event Image Upload *</label>
                <input type="file" name="eventimage[]" multiple value="{{ old('eventimage', isset($church) ? $church->eventimage : '') }}" class="custom-file-input" id="eventimage">
                <label style="margin-top: 28px;" class="custom-file-label" for="eventimage">Choose file</label>
                @if($errors->has('eventimage'))
                <em class="invalid-feedback">
                    {{ $errors->first('eventimage') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('cruds.church.fields.event_helper') }}
            </p>
              </div>
              <?php 
                                    if(is_array(json_decode($church->eventimage))){
                                        $jsonDecodeImages = json_decode($church->eventimage);
                                    }else{
                                        $jsonDecodeImages = $church->eventimage;
                                    }
                                    ?> 
               <?php foreach ($jsonDecodeImages as $key => $jsonDecodeImage) { ?>
                <img width="30px" onclick="onClick(this)" style="    border-radius: 100px;float: right;
                margin-top: 20px;" height="30px" src="{{ asset($jsonDecodeImage) }}">
               <?php } ?>                    
                                
                                
            <div style="float: left;
            width: 100%;
            margin-top: 30px;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
<div id="modal01" class="w3-modal" onclick="this.style.display='none'">
    <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
    <div class="w3-modal-content w3-animate-zoom">
      <img id="img01">
    </div>
  </div>
@endsection