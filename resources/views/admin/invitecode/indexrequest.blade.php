@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.invitecode.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.invitecode.fields.id') }}
                        </th>
                        <th>
                            User Name
                        </th>
                        <th>
                            {{ trans('cruds.invitecode.fields.invitecode') }}
                        </th>
                        <th>
                            Church Name
                        </th>
                        <th>
                           Status
                        </th>
                     
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invitecodes as $key => $invitecode)
                        <tr data-entry-id="{{ $invitecode->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $invitecode->id ?? '' }}
                            </td>
                            <td>
                                {{ $invitecode->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $invitecode->invitecodedata->invitecode ?? '' }}
                            </td>
                            <td>
                                {{ $invitecode->church->name ?? '' }}
                            </td>
                            <td>
                                <?php if($invitecode->status == 0 ){ ?>
                                        Pending
                                   <?php }elseif($invitecode->status == 1){
                                       
                                       ?>
                                       Rejected
                                    <?php }else{?>
                                    Approved
                                    <?php 
                                } ?>   
                                 
                            </td>
                          
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.requestlist.edit', $invitecode->id) }}">
                                    Permmision
                                </a>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
<div id="modal01" class="w3-modal" onclick="this.style.display='none'">
    <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
    <div class="w3-modal-content w3-animate-zoom">
      <img id="img01">
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