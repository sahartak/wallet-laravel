@extends('layouts.app', ['removeAppJs' => true ])
@section('content')
    @include('layouts._userNavbar')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-2">
                <form action="{{route('transactions-chart')}}" method="GET">
                    <select name="type" class="form-control" id="chart_type">
                        @foreach(\App\Models\Transaction::CHART_VARIANTS as $type => $name)
                            <option value="{{$type}}" @if($type == $periodType) selected @endif> {{$name}}</option>
                        @endforeach
                    </select>
                </form>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->


    <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description"></p>
    </figure>

@stop

@push('scripts')
    <script>

        const dates = @json($dates);
        const expense = @json($expense);
        const income = @json($income);
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="/js/chart.js"></script>
@endpush