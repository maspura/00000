@extends('admin.layouts.index')

@include('admin.layouts.components.asset_datatables')
@include('admin.layouts.components.jquery_ui')
@section('title')
<h1>
    Menu
</h1>
@endsection

@section('breadcrumb')
<li class="active">Daftar Menu</li>
@endsection

@section('content')
@include('admin.layouts.components.notifikasi')
<div class="box box-info">
    <div class="box-header with-border">
        @if (can('u'))
        <a href="{{ ci_route('menu.ajax_menu', $parent) }}" data-remote="false" data-toggle="modal"
            data-target="#modalBox" data-title="Tambah <?= $judul ?>"
            class="btn btn-social btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i
                class='fa fa-plus'></i> Tambah</a>
        @endif
        @if (can('h'))
        <a href="#confirm-delete" title="Hapus Data"
            onclick="deleteAllBox('mainform', '{{ ci_route('menu.delete', $parent) }}')"
            class="btn btn-social btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i
                class='fa fa-trash-o'></i>
            Hapus</a>
        @endif
        @if ($parent)
        <a href="{{ ci_route('menu') }}"
            class="btn btn-social btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
            <i class="fa fa-arrow-circle-left "></i>Kembali ke Daftar Menu
        </a>
        @endif
    </div>
    @if ($subtitle)
    <div class="box-header with-border">
        <strong>{!! $subtitle !!}</strong>
    </div>
    @endif
    <div class="box-body">
        <div class="row">
            <div class="col-sm-2">
                <select id="status" class="form-control input-sm select2" name="status">
                    <option value="">Pilih Status</option>
                    @foreach ($status as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        {!! form_open(null, 'id="mainform" name="mainform"') !!}
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabeldata">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkall" /></th>
                        <th class="padat">NO</th>
                        <th class="padat">AKSI</th>
                        <th nowrap>NAMA {{ $parent ? 'SUBMENU' : 'MENU' }}</th>
                        <th nowrap>LINK</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody id="dragable">
                </tbody>
            </table>
        </div>
        </form>
    </div>
</div>

@include('admin.layouts.components.konfirmasi_hapus')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
            var TableData = $('#tabeldata').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ ci_route('menu.datatables') }}?parent={{ $parent }}",
                    data: function(req) {
                        req.status = $('#status').val();
                    }
                },
                columns: [{
                        data: 'ceklist',
                        class: 'padat',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        class: 'padat',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'aksi',
                        class: 'aksi',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        searchable: true,
                        orderable: false
                    },
                    {
                        data: 'link',
                        name: 'link',
                        searchable: true,
                        orderable: false
                    },
                    {
                        data: 'enabled',
                        name: 'enabled',
                        searchable: true,
                        orderable: false,
                        visible: false
                    }
                ],
                aaSorting: [],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id)
                    $(row).addClass('dragable-handle');
                },
            });

            $('#status').change(function() {
                TableData.draw();
            })


            if (hapus == 0) {
                TableData.column(0).visible(false);
            }

            if (ubah == 0) {
                TableData.column(2).visible(false);
            }

            // harus diletakkan didalam blok ini, jika tidak maka object TableData tidak dikenal
            @include('admin.layouts.components.draggable', ['urlDraggable' => ci_route('menu.tukar')])
        });
</script>
@endpush