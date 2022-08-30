@extends('themes/layout')

@section('title') Panel Principal @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard Registro Civil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row mb-3">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-baby"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Nacimientos</span>
                <span class="info-box-number">
                    {{ $totalNacimientos }} <small>(total registrados)</small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-ring"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Matrimonios</span>
                <span class="info-box-number">
                    {{ $totalMatrimonios }} <small>(total registrados)</small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-skull"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Defunciones</span>
                <span class="info-box-number">
                    {{ $totalDefunciones }} <small>(total registrados)</small>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function () {

        });
    </script>
@endsection