@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tableau de bord !</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body text-center">
                <h1>BIENVENUE,</h1>
                <h2>Vous êtes connecté en tant que CAISSIER</h2>
                <br><br>
                <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg">Nouvelle Transaction</a>
                <br><br><br>
            </div>
        </div>
    </div>
</div><!-- visit "codeastro" for more projects! -->
<!-- /.row (main row) -->
@endsection