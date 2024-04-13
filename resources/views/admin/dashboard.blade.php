@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tableau de bord !/li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #005564;">
            <div class="inner">
                <h3>{{ $Batiment }}</h3>

                <p>Total Batiment</p>
            </div>
            <div class="icon">
                <i class="fa fa-cube"></i>
            </div>
            <a href="{{ route('batiment.index') }}" class="small-box-footer">Vue<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #FFFBF0;">
            <div class="inner">
                <h3>{{ $Departement }}</h3>

                <p>Total Departement</p>
            </div>
            <div class="icon">
                <i class="fa fa-home"></i>
            </div>
            <a href="{{ route('departement.index') }}" class="small-box-footer">Vue<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #005564;">
            <div class="inner">
                <h3>{{ $salle }}</h3>

                <p>Totale Salle</p>
            </div>
            <div class="icon">
                <i class="fa fa-university"></i>
            </div>
            <a href="{{ route('salle.index') }}" class="small-box-footer">Vue <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #FFFBF0;">
            <div class="inner">
                <h3>{{ $professeur }}</h3>

                <p>Total Professeur</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{ route('professeur.index') }}" class="small-box-footer">Vue <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #005564;">
            <div class="inner">
                <h3>{{ $supplier }}</h3>

                <p>Total Cours</p>
            </div>
            <div class="icon">
                <i class="fa fa-book"></i>
            </div>
            <a href="{{ route('supplier.index') }}" class="small-box-footer">Vue <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #FFFBF0;">
            <div class="inner">
                <h3>{{ $penjualan }}</h3>

                <p>Ventes</p>
            </div>
            <div class="icon">
                <i class="fa fa-dollarp"></i> 
            </div>
            <a href="{{ route('penjualan.index') }}" class="small-box-footer">Vue <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #005564;">
            <div class="inner">
                <h3>{{ $pengeluaran }}</h3>

                <p>Totale EDTemps</p>
            </div>
            <div class="icon">
                <i class="fa fa-clock-o"></i> Horaire
            </div>
            <a href="{{ route('pengeluaran.index') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box" style="background-color: #FFFBF0;">
            <div class="inner">
                <h3>{{ $pembelian }}</h3>

                <p>Achat total</p>
            </div>
            <div class="icon">
                <i class="fa fa-dollarp"></i>
            </div>
            <a href="{{ route('pembelian.index') }}" class="small-box-footer">Vue<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Evolution des heures de cours !</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="chart">
                    <canvas id="salesChart" style="height: 250px;"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row (main row) -->
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('AdminLTE-2/bower_components/chart.js/Chart.js') }}"></script>
<script>
$(function() {
    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var salesChart = new Chart(salesChartCanvas);

    var salesChartData = {
        labels: {{ json_encode($data_tanggal) }},
        datasets: [
            {
                label: 'Pendapatan',
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: {{ json_encode($data_pendapatan) }}
            }
        ]
    };

    var salesChartOptions = {
        pointDot : false,
        responsive : true
    };

    salesChart.Line(salesChartData, salesChartOptions);
});
</script>
<style>
    .small-box.bg-brown:hover .inner h3,
    .small-box.bg-brown:hover .inner p {
        color: black;
    }
</style>
@endpush
