@extends('template')
@section('view')
<div class="row">
    <div class="col-12">
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target=".modalAdd"><i class="fas fa-plus-square"></i> Tambah Data</button>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Category</h4>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Tambah Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="add">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name">
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
                    <h5 class="modal-title h4" id="myLargeModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="status" value="edit">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
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
        ajax: "{{ url('/data/category') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
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
        axios.post("{{url('ajax/category')}}", form)
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
            url: "{{url('data/category')}}/" + id,
            success: function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
            }
        })
    }
    $("#edit").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/category')}}", form)
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
            url: "{{url('data/category')}}/" + id,
            success: function(data) {
                $("#hapus_id").val(data.id);
                $("#hapus_name").val(data.name);
            }
        })
    }
    $("#hapus").submit(function(event) {
        event.preventDefault();
        var form = new FormData(this);
        form.append('_token', token);
        axios.post("{{url('ajax/category')}}", form)
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