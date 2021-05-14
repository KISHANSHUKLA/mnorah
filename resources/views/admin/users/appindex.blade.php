@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                      
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            Login Type
                        </th>
                        <th>
                            Leadership Team
                        </th>
                        <th>
                            Medically Verified
                        </th>
                        <th>
                            Community Verified
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                          
                            <td>
                                {{ $user->name ?? '' }}
                            </td>
                            <td>
                                {{ $user->email ?? '' }}
                            </td>
                            <td>
                                {{ $user->appuser->usertype ?? '' }}
                            </td>
                          
                                <td>
                                    <?php if($user->appuser->Leadershipteam == 0){ ?>
                                        <a class="btn btn-xs btn-warning" href="{{ route('admin.leadership', $user->appuser->id) }}">
                                            Deactive </a>
                                    <?php } else {?>
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.leadership', $user->appuser->id) }}">
                                            Active </a>
                                        <?php } ?>
                                
                                 
                            </td>
                                 <td>
                                    <?php if($user->appuser->medicallyverified == 0){ ?>
                                        <a class="btn btn-xs btn-warning" href="{{ route('admin.medically', $user->appuser->id) }}">
                                            Deactive </a>
                                    <?php } else {?>
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.medically', $user->appuser->id) }}">
                                            Active </a>
                                        <?php } ?>
                                
                                 
                            </td>

                            <td>
                                <?php if($user->appuser->communityverified == 0){ ?>
                                    <a class="btn btn-xs btn-warning" href="{{ route('admin.community', $user->appuser->id) }}">
                                        Deactive </a>
                                <?php } else {?>
                                    <a class="btn btn-xs btn-success" href="{{ route('admin.community', $user->appuser->id) }}">
                                        Active </a>
                                    <?php } ?>
                            
                             
                        </td>
                            
                          
                            <td>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.users.mass_destroy') }}",
//     className: 'btn-danger',
//     action: function (e, dt, node, config) {
//       var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
//           return $(entry).data('entry-id')
//       });

//       if (ids.length === 0) {
//         alert('{{ trans('global.datatables.zero_selected') }}')

//         return
//       }

//       if (confirm('{{ trans('global.areYouSure') }}')) {
//         $.ajax({
//           headers: {'x-csrf-token': _token},
//           method: 'POST',
//           url: config.url,
//           data: { ids: ids, _method: 'DELETE' }})
//           .done(function () { location.reload() })
//       }
//     }
//   }
//   dtButtons.push(deleteButton)
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
<style>
    table.dataTable tbody td.select-checkbox:before{
        display: none;
    }
</style>
@endsection
