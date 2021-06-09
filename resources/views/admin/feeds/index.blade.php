@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Feeds List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Message
                        </th>
                        <th>
                            Image
                        </th>
                        <th>
                            Medically Verified
                        </th>
                     
                        <th>
                            Community Verified
                        </th>
                       
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeds as $key => $feed)
                        <tr data-entry-id="{{ $feed->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $feed->message ?? '' }}
                            </td>
                            <td>
                                {{ $feed->image ?? '' }}
                            </td>
                           
                                <td>
                                    <?php if($feed->medicallyverified == 0){ ?>
                                        <a class="btn btn-xs btn-warning" href="{{ route('admin.medically', $feed->id) }}">
                                            Deactive </a>
                                    <?php } else {?>
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.medically', $feed->id) }}">
                                            Active </a>
                                        <?php } ?>
                                
                                 
                            </td>
                                
                            <td>
                                <?php if($feed->communityverified == 0){ ?>
                                    <a class="btn btn-xs btn-warning" href="{{ route('admin.community', $feed->id) }}">
                                        Deactive </a>
                                <?php } else {?>
                                    <a class="btn btn-xs btn-success" href="{{ route('admin.community', $feed->id) }}">
                                        Active </a>
                                    <?php } ?>
                               
                            </td>
                         
                            {{-- <td>
                              
                                <form action="{{ route('admin.feeds.destroy', $feed->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>

                            </td> --}}

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