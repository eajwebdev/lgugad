@extends('layouts.master')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-dashboard"></i> Dashboard</a></li>
                </ol> 
            </nav>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $citizen }}</h3>
                    <p>Senior Citizen</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gray">
                <div class="inner">
                    <h3>{{ $maleCount }}</h3>
                    <p>Male</p>
                </div>
                <div class="icon">
                    <i class="fa fa-male"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $femaleCount }}</h3>
                    <p>Female</p>
                </div>
                <div class="icon">
                    <i class="fa fa-female"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users-gear"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Female Age Bracket</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="fas fa-square" style="color: #f56954"></i> 60-69</li>
                                <li><i class="fas fa-square" style="color: #00a65a"></i> 70-79</li>
                                <li><i class="fas fa-square" style="color: #f39c12"></i> 80-89</li>
                                <li><i class="fas fa-square" style="color: #00c0ef"></i> 90-99</li>
                                <li><i class="fas fa-square" style="color: #3c8dbc"></i> 100-109</li>
                                <li><i class="fas fa-square" style="color: #d2d6de"></i> 110-119</li>
                                <li><i class="fas fa-square" style="color: #6c757d"></i> 120-129</li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChart"
                                        data-female-age-60-69="{{ $femaleAge6069Count }}"
                                        data-female-age-70-79="{{ $femaleAge7079Count }}"
                                        data-female-age-80-89="{{ $femaleAge8089Count }}"
                                        data-female-age-90-99="{{ $femaleAge9099Count }}"
                                        data-female-age-100-109="{{ $femaleAge100109Count }}"
                                        data-female-age-110-119="{{ $femaleAge110119Count }}"
                                        data-female-age-120-129="{{ $femaleAge120129Count }}"
                                        style="height: 150;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box mb-2" style="background-color: #f56954;">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Female Age 60-69</h6></span>
                            <span class="info-box-number">{{ $femaleAge6069Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #00a65a;">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Female Age 70-79</h6></span>
                            <span class="info-box-number">{{ $femaleAge7079Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #f39c12;">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Female Age 80-89</h6></span>
                            <span class="info-box-number">{{ $femaleAge8089Count }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box mb-2" style="background-color: #00c0ef;">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Female Age 90-99</h6></span>
                            <span class="info-box-number">{{ $femaleAge9099Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #3c8dbc;">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Female Age 100-109</h6></span>
                            <span class="info-box-number">{{ $femaleAge100109Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #d2d6de;">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Female Age 110-119</h6></span>
                            <span class="info-box-number">{{ $femaleAge110119Count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Male Age Bracket</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="fas fa-square" style="color: #f56954"></i> 60-69</li>
                                <li><i class="fas fa-square" style="color: #00a65a"></i> 70-79</li>
                                <li><i class="fas fa-square" style="color: #f39c12"></i> 80-89</li>
                                <li><i class="fas fa-square" style="color: #00c0ef"></i> 90-99</li>
                                <li><i class="fas fa-square" style="color: #3c8dbc"></i> 100-109</li>
                                <li><i class="fas fa-square" style="color: #d2d6de"></i> 110-119</li>
                                <li><i class="fas fa-square" style="color: #6c757d"></i> 120-129</li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChart1"
                                        data-male-age-60-69="{{ $maleAge6069Count }}"
                                        data-male-age-70-79="{{ $maleAge7079Count }}"
                                        data-male-age-80-89="{{ $maleAge8089Count }}"
                                        data-male-age-90-99="{{ $maleAge9099Count }}"
                                        data-male-age-100-109="{{ $maleAge100109Count }}"
                                        data-male-age-110-119="{{ $maleAge110119Count }}"
                                        style="height: 150;">
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box mb-2" style="background-color: #f56954;">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Male Age 60-69</h6></span>
                            <span class="info-box-number">{{ $maleAge6069Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #00a65a;">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Male Age 70-79</h6></span>
                            <span class="info-box-number">{{ $maleAge7079Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #f39c12;">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Male Age 80-89</h6></span>
                            <span class="info-box-number">{{ $maleAge8089Count }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box mb-2" style="background-color: #00c0ef;">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Male Age 90-99</h6></span>
                            <span class="info-box-number">{{ $maleAge9099Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #3c8dbc;">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Male Age 100-109</h6></span>
                            <span class="info-box-number">{{ $maleAge100109Count }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2" style="background-color: #d2d6de;">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><h6>Male Age 110-119</h6></span>
                            <span class="info-box-number">{{ $maleAge110119Count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection