@extends('layouts.admin')
@section('content')
@can('users_manage')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.churches.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.church.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.church.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.church.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.denomination') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.venue') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.day') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.language') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.Social') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.vision') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.leadership') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.ministries') }}
                        </th>
                        <th>
                            {{ trans('cruds.church.fields.event') }}
                        </th>
                       
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($churches as $key => $church)
                        <tr data-entry-id="{{ $church->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $church->id ?? '' }}
                            </td>
                            <td>
                                {{ $church->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $church->denomination ?? '' }}
                            </td>
                            <td>
                                {{ $church->venue ?? '' }}
                            </td>
                            <td>
                                <?php 
                                $date = date('l', strtotime($church->days));
                                ?>
                                {{ $date ?? '' }}
                            </td>
                            <td>
                                {{ $church->language ?? '' }}
                            </td>
                            <td>
                                {{ $church->Social ?? '' }}
                            </td>
                            <td>
                                {{ $church->vision ?? '' }}
                            </td>
                            <td>
                                {{ $church->leadership ?? '' }}
                            </td>
                            <td>
                                {{ $church->ministries ?? '' }}
                            </td>
                            <td>
                                {{ $church->event ?? '' }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.churches.edit', $church->id) }}">
                                    {{ trans('global.edit') }}
                                </a>

                                <form action="{{ route('admin.churches.destroy', $church->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('users_manage')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.mass_destroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 20,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection