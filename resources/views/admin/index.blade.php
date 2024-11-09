@extends('layouts.dashboard.app')
@section('title', 'Home')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>

        @livewire('admin.statistcs')

        <!-- Content Row -->
        {{-- charts --}}
        <div class="row">

            <div class="card-body shadow col-6">

                <h4>{{ $chart1->options['chart_title'] }}</h4>
                {!! $chart1->renderHtml() !!}

            </div>
            <div class="card-body shadow col-6">

                <h4>{{ $chart2->options['chart_title'] }}</h4>
                {!! $chart2->renderHtml() !!}

            </div>
        </div>

        @livewire('admin.latest-posts-comments')

    </div>
    <!-- /.container-fluid -->
@endsection
@push('script')
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
    {!! $chart2->renderJs() !!}
@endpush
