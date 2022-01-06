@extends('template')
@section('view')
<div class="row">
    <div class="col-12">
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Tambah Data</button>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Warga</h4>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Status Perkawinan</th>
                            <th>Status Warga</th>
                            <th>KTP</th>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Warga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="L">
                            <label class="form-check-label">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="P">
                            <label class="form-check-label">
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_perkawinan" value="Single">
                            <label class="form-check-label">
                                Single
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_perkawinan" value="Menikah">
                            <label class="form-check-label">
                                Menikah
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>KTP</label>
                        <input type="file" class="form-control" name="ktp">
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Warga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="edit_jenis_kelamin" name="jenis_kelamin" value="L">
                            <label class="form-check-label">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="edit_jenis_kelamin" name="jenis_kelamin" value="P">
                            <label class="form-check-label">
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="edit_status_perkawinan" name="status_perkawinan" value="Single">
                            <label class="form-check-label">
                                Single
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="edit_status_perkawinan" name="status_perkawinan" value="Menikah">
                            <label class="form-check-label">
                                Menikah
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status Warga</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="edit_status_warga" name="status_warga" value="Sudah Pindah">
                            <label class="form-check-label">
                                Sudah Pindah
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="edit_status_warga" name="status_warga" value="Warga">
                            <label class="form-check-label">
                                Warga
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>KTP</label>
                        <input type="file" class="form-control" id="edit_" name="ktp">
                        <small class="text-danger">*untuk merubah foto ktp silahkan upload ulang ktp, jika tidak tidak perlu upload</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Edit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Hapus Category</h5>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="hapus_id" value="">
                    <input type="hidden" name="status" value="hapus">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="hapus_name" name="name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="hapus_email" name="email" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" id="hapus_tanggal_lahir" name="tanggal_lahir" disabled>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" id="hapus_alamat" name="alamat" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="hapus_jenis_kelamin" name="jenis_kelamin" value="L" disabled>
                            <label class="form-check-label">
                                Laki Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="hapus_jenis_kelamin" name="jenis_kelamin" value="P" disabled>
                            <label class="form-check-label">
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="hapus_status_perkawinan" name="status_perkawinan" value="Single" disabled>
                            <label class="form-check-label">
                                Single
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="hapus_status_perkawinan" name="status_perkawinan" value="Menikah" disabled>
                            <label class="form-check-label">
                                Menikah
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status Warga</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="hapus_status_warga" name="status_warga" value="Sudah Pindah" disabled>
                            <label class="form-check-label">
                                Sudah Pindah
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="hapus_status_warga" name="status_warga" value="Warga" disabled>
                            <label class="form-check-label">
                                Warga
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>KTP</label>
                        <input type="file" class="form-control" id="hapus_" name="ktp" disabled>
                        <small class="text-danger">*untuk merubah foto ktp silahkan upload ulang ktp, jika tidak tidak perlu upload</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    var token = '{{ csrf_token() }}'
    var table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/data/warga') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'tanggal_lahir',
                name: 'tanggal_lahir'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'jenis_kelamin',
                name: 'jenis_kelamin'
            },
            {
                data: 'status_perkawinan',
                name: 'status_perkawinan'
            },
            {
                data: 'status_warga',
                name: 'status_warga'
            },
            {
                data: 'ktp',
                name: 'ktp'
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
        axios.post("{{url('ajax/warga')}}", form)
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
                            $("#add").trigger("reset")
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
            url: "{{url('data/warga')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_email").val(data.email);
                $("#edit_tanggal_lahir").val(data.tanggal_lahir);
                $("#edit_alamat").val(data.alamat);
                $("input[id=edit_jenis_kelamin][value='" + data.jenis_kelamin + "']").prop("checked", true);
                $("input[id=edit_status_perkawinan][value='" + data.status_perkawinan + "']").prop("checked", true);
                $("input[id=edit_status_warga][value='" + data.status_warga + "']").prop("checked", true);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/warga')}}", form)
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
            url: "{{url('data/warga')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_name").val(data.name);
                $("#hapus_email").val(data.email);
                $("#hapus_tanggal_lahir").val(data.tanggal_lahir);
                $("#hapus_alamat").val(data.alamat);
                $("input[id=hapus_jenis_kelamin][value='" + data.jenis_kelamin + "']").prop("checked", true);
                $("input[id=hapus_status_perkawinan][value='" + data.status_perkawinan + "']").prop("checked", true);
                $("input[id=hapus_status_warga][value='" + data.status_warga + "']").prop("checked", true);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/warga')}}", form)
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