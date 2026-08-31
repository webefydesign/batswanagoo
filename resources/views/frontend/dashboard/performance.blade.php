@extends('layouts.frontend')
@section('title', 'Performance | Batswana Goo')
@section('customStyles')
    <style>
        .alert-success {
            position: fixed;
            bottom: 10px;
            right: 30px;
            z-index: 999999;
            min-width: 400px;
            font-size: 13px;
            background: green;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .full-bot-book {
            display: none;
        }
        .form_date_filter{

        }
        .per_inp{
            font-size: 12px;
            width: 100px;
            height: 29px;
            border-radius: 4px;
            padding: 4px;
            border: solid 1px #1eaf38;
            color: #1eaf38;
        }
        .filter-date-btn{
            background: #1eaf38;
            color: white;
            border: solid 1px #1eaf38;
            font-size: 12px;
            border-radius: 4px;
            width: 83px;
            height: 30px;

        }
        .v3-list-ql {}
    </style>
@endsection

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif



    <div class="m-container forprfile">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            @include('frontend.dashboard.profile_main_nav')
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="tab-heads df_area" style="justify-content: space-between;">
                                    <h3>Performance</h3>
                                    <div class="form_date_filter">
                                        <form action="" method="get">
                                            <select name="month" class="per_inp">
                                                <option value="01"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '01') selected="" @elseif(!isset($_GET['month']) && date('m') == '01') selected="" @endif>
                                                    January</option>
                                                <option value="02"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '02') selected="" @elseif(!isset($_GET['month']) && date('m') == '02') selected="" @endif>
                                                    February</option>
                                                <option value="03"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '03') selected="" @elseif(!isset($_GET['month']) && date('m') == '03') selected="" @endif>
                                                    March</option>
                                                <option value="04"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '04') selected="" @elseif(!isset($_GET['month']) && date('m') == '04') selected="" @endif>
                                                    April</option>
                                                <option value="05"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '05') selected="" @elseif(!isset($_GET['month']) && date('m') == '05') selected="" @endif>
                                                    May
                                                </option>
                                                <option value="06"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '06') selected="" @elseif(!isset($_GET['month']) && date('m') == '06') selected="" @endif>
                                                    June
                                                </option>
                                                <option value="07"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '07') selected="" @elseif(!isset($_GET['month']) && date('m') == '07') selected="" @endif>
                                                    July
                                                </option>
                                                <option value="08"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '08') selected="" @elseif(!isset($_GET['month']) && date('m') == '08') selected="" @endif>
                                                    August</option>
                                                <option value="09"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '09') selected="" @elseif(!isset($_GET['month']) && date('m') == '09') selected="" @endif>
                                                    September</option>
                                                <option value="10"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '10') selected="" @elseif(!isset($_GET['month']) && date('m') == '10') selected="" @endif>
                                                    October</option>
                                                <option value="11"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '11') selected="" @elseif(!isset($_GET['month']) && date('m') == '11') selected="" @endif>
                                                    November</option>
                                                <option value="12"
                                                    @if (isset($_GET['month']) && $_GET['month'] == '12') selected="" @elseif(!isset($_GET['month']) && date('m') == '12') selected="" @endif>
                                                    December</option>
                                            </select>
                                            <select name="year" class="per_inp">
                                                @for ($i = '2022'; $i < date('Y') + 1; $i++)
                                                    <option value="{{ $i }}"
                                                        @if (isset($_GET['year']) && $_GET['year'] == $i) selected @elseif(!isset($_GET['year']) && $i == date('Y')) selected @endif>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                            <button type="submit" class="filter-date-btn"> <span
                                                    class="filter-date"></span> Search </button>
                                        </form>
                                    </div>
                                </div><!-- tab-heads -->
                            </div><!-- panel-heading -->
                            <div class="panel-body">
                                <div class="chart-container">
                                    <div class="legend-container" id="legend-container"></div>
                                    <div id="myChart"></div>
                                    <div id="stats-container" class="stats"></div>
                                </div>
                            </div><!-- panl-body -->
                        </div>
                    </div><!-- sm8 -->
                </div>
            </div><!-- sm4 -->
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var dates = JSON.parse('{!! json_encode($mydates) !!}')
        var impression = JSON.parse('{!! json_encode($impression) !!}')
        var visitor = JSON.parse('{!! json_encode($visitor) !!}')
        var phone_view = JSON.parse('{!! json_encode($phone_view) !!}')
        var chat_request = JSON.parse('{!! json_encode($chat_request) !!}')
        var max = {!! $max !!}
        var options = {
            series: [{
                    name: "Impression",
                    data: impression,
                },
                {
                    name: "Visitor",
                    data: visitor,
                },
                {
                    name: "Phone View",
                    data: phone_view,
                },
                {
                    name: "Chat Request",
                    data: chat_request,
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#77B6EA', '#545454', 'red', 'green'],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'smooth'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },

            yaxis: {
                title: {
                    text: 'Views'
                },
                min: 0,
                max: max
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart = new ApexCharts(document.querySelector("#myChart"), options);
        chart.render();
    </script>
@endsection
