@extends('template')
@section('view')
<link href="{{ asset('assets') }}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .datepicker {
        z-index: 1151 !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Tambah Data</button>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Iuran Warga</h4>
                <div class="row justify-content-end">
                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" name="periode" id="periode" placeholder="cari bedasarkan periode">
                        </div>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success w-100" id="search"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </div>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th>Periode</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
@section('js')
<script src="{{ asset('assets') }}/libs/select2/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var token = '{{ csrf_token() }}'
    $(".datepicker").datepicker({
        format: 'mm/yyyy',
        startView: "months",
        minViewMode: "months",
        autoclose: true
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });
    var table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        bInfo: false,
        ajax: {
            url: "{{ url('/data/history') }}",
            data: function(d) {
                d.periode = $('#periode').val();
            }
        },
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'deskripsi',
                name: 'deskripsi'
            },
            {
                data: 'saldo',
                name: 'saldo'
            },
            {
                data: 'periode',
                name: 'periode'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });
    $("#search").click(function() {
        table.draw();
    })
</script>
@endsection