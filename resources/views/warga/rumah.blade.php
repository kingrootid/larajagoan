@extends('template')
@section('view')
<link href="{{ asset('assets') }}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-12">
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Tambah Data</button>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Rumah Warga</h4>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Alamat</th>
                            <th>Nomor Rumah</th>
                            <th>Anggota Lain</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div class="modal fade modalAdd" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Data Rumah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label>Kepala Keluarga</label>
                        <select class="form-control kk_select" name="kepala_keluarga">
                            <option value="null">Pilih Kepala Keluarga</option>
                            @foreach ($warga as $kk)
                            <option value="{{ $kk['id'] }}">{{$kk['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Anggota Keluarga</label>
                        <select class="form-control ps_select2" multiple name="penghuni[]">
                            @foreach ($warga as $kk)
                            <option value="{{ $kk['id'] }}">{{$kk['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Rumah</label>
                        <input type="text" class="form-control" name="nomor">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade modalEdit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="edit" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Data Rumah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group">
                        <label>Kepala Keluarga</label>
                        <select class="form-control" id="edit_kepala_keluarga" name="kepala_keluarga">
                            <option value="null">Pilih Kepala Keluarga</option>
                            @foreach ($allWarga as $kk)
                            <option value="{{ $kk['id'] }}">{{$kk['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Anggota Keluarga</label>
                        <select class="form-control ps_select2" id="edit_penghuni" multiple name="penghuni[]">
                            @foreach ($allWarga as $kk)
                            <option value="{{ $kk['id'] }}">{{$kk['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Rumah</label>
                        <input type="text" class="form-control" id="edit_nomor" name="nomor">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Edit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade modalHapus" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="hapus" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Data Rumah</h5>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hapus_id" value="">
                    <input type="hidden" name="status" value="hapus">
                    <div class="form-group">
                        <label>Kepala Keluarga</label>
                        <select class="form-control" id="hapus_kepala_keluarga" name="kepala_keluarga" disabled>
                            <option value="null">Pilih Kepala Keluarga</option>
                            @foreach ($allWarga as $kk)
                            <option value="{{ $kk['id'] }}">{{$kk['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Anggota Keluarga</label>
                        <select class="form-control ps_select2" id="hapus_penghuni" multiple name="penghuni[]" disabled>
                            @foreach ($allWarga as $kk)
                            <option value="{{ $kk['id'] }}">{{$kk['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Rumah</label>
                        <input type="text" class="form-control" id="hapus_nomor" name="nomor" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets') }}/libs/select2/js/select2.min.js"></script>
<script>
    $(".kk_select").select2({
        dropdownParent: $('.modalAdd')
    });
    $(".ps_select2").select2({
        dropdownParent: $('.modalAdd'),
        placeholder: 'Pilih Kepala Keluarga terlebih dahulu',
        multiple: true
    });
    $("#edit_kepala_keluarga").select2({
        dropdownParent: $('.modalEdit')
    });
    $("#edit_penghuni").select2({
        dropdownParent: $('.modalEdit'),
        multiple: true
    });
    $("#hapus_kepala_keluarga").select2({
        dropdownParent: $('.modalHapus')
    });
    $("#hapus_penghuni").select2({
        dropdownParent: $('.modalHapus'),
        multiple: true
    });
    var token = '{{ csrf_token() }}'
    var table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/data/rumah') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'kepala_keluarga',
                name: 'kepala_keluarga'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'nomor',
                name: 'nomor'
            },
            {
                data: 'penghuni',
                name: 'penghuni'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });
    $("#add").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/rumah')}}", form)
            .then(response => {
                if (response.data.error == 0) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalAdd").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                console.log(error);
                $(".modalAdd").modal('hide')
                setTimeout(function() {
                    swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })

    function edit(id) {
        $(".modalEdit").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/rumah')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_nomor").val(data.nomor);
                $("#edit_kepala_keluarga").val(data.kepala_keluarga);
                $('#edit_kepala_keluarga').trigger('change');
                $("#edit_penghuni").val(data.penghuni);
                $('#edit_penghuni').trigger('change');

            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/rumah')}}", form)
            .then(response => {
                $(".modalEdit").modal('hide');
                if (response.data.error == 0) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalEdit").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalEdit").modal('hide')
                setTimeout(function() {
                    swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })

    function hapus(id) {
        $(".modalHapus").modal('show');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('data/rumah')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_nomor").val(data.nomor);
                $("#hapus_kepala_keluarga").val(data.kepala_keluarga);
                $('#hapus_kepala_keluarga').trigger('change');
                $("#hapus_penghuni").val(data.penghuni);
                $('#hapus_penghuni').trigger('change');
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/rumah')}}", form)
            .then(response => {
                $(".modalHapus").modal('hide');
                if (response.data.error == 0) {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function() {
                            $(".modalHapus").modal('hide');
                            table.ajax.reload();
                        });
                    }, 200);
                } else {
                    setTimeout(function() {
                        swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }, 200);
                }
            })
            .catch(error => {
                $(".modalHapus").modal('hide')
                setTimeout(function() {
                    swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                }, 200)
            });
    })
</script>
@endsection