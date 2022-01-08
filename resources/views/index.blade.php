@extends('template')
@section('view')
<div class="row">
    <div class="col-xs-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup">{{$kas['pemasukan'] -  $kas['pengeluaran']}}</span></h4>
                    <p class="text-muted mb-0">Total Saldo</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
    <div class="col-xs-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup">{{$kas['pemasukan']}}</span></h4>
                    <p class="text-muted mb-0">Total Pemasukan</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
    <div class="col-xs-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup">{{$kas['pengeluaran']}}</span></h4>
                    <p class="text-muted mb-0">Total Pengeluran</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div>
@endsection
@section('js')
@endsection