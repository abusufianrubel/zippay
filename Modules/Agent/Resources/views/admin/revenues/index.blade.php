@extends('admin.layouts.master')

@section('title', __('Revenues list'))

@section('head_style')
  <!-- Bootstrap daterangepicker -->
  <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/plugins/daterangepicker/daterangepicker.min.css')}}">

  <!-- dataTables -->
  <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/plugins/DataTables/DataTables/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/plugins/DataTables/Responsive/css/responsive.dataTables.min.css') }}">
@endsection

@section('page_content')
<div class="section" id="revenue">
    <div class="box">
        <div class="box-body pb-20">
            <form action="{{ route('admin.agents.revenues.index') }}" method="get" class="form-horizontal">

                <input type="hidden" name="from" id="startfrom" value="{{ isset($from) ? $from : '' }}">
                <input type="hidden" name="to" id="endto" value="{{ isset($to) ? $to : '' }}">
                <input type="hidden" name="user_id" id="user_id" value="{{ isset($user) ? $user : '' }}">

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex flex-wrap">
                                
                                <!-- Date and time range -->
                                <div class="pr-25">
                                    <label class="f-14 fw-bold mb-1" for="daterange-btn">{{ __('Date Range') }}</label><br>
                                    <button type="button" class="btn btn-default f-14" id="daterange-btn">
                                        <span id="drp"><i class="fa fa-calendar"></i></span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>

                                <!-- Currency -->
                                <div class="pr-25">
                                    <label class="f-14 fw-bold mb-1" for="currency">{{ __('Currency') }}</label><br>
                                    <select class="form-control select2" name="currency" id="currency">
                                        <option value="all" {{ ($currency == 'all' ) ? 'selected' : '' }} >{{ __('All') }}</option>
                                        @foreach($revenues_currency as $revenue)
                                        <option value="{{ $revenue->currency_id }}" {{ ($revenue->currency_id == $currency) ? 'selected' : '' }}>
                                            {{ $revenue->currency?->code }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Transaction Type -->
                                <div class="pr-25">
                                    <label class="f-14 fw-bold mb-1" for="type">{{ __('Transaction Type') }}</label><br>
                                    <select class="form-control select2" name="type" id="type">
                                        <option value="all" {{ ($type == 'all') ? 'selected' : '' }} >{{ __('All') }}</option>
                                        @foreach($revenues_type as $revenue)
                                        <option value="{{ $revenue->transaction_type_id }}" {{ ($revenue->transaction_type_id == $type) ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', $revenue->transaction_type?->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div class="input-group mt-3">
                                    <button type="submit" name="btn" class="btn btn-theme f-14" id="btn">{{ __('Filter') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Total Charge Boxes -->
    @if ($currencyInfo)
        <div class="box">
            <div class="box-body">
                <div class="row">
                    @forelse ($currencyInfo as $currencyCode => $currency)
                            <div class="col-md-3">
                                <div class="panel panel-primary">
                                    <div class="panel-body text-center revenue-pd">
                                        <span class="text-info revenue-text-size">{{ __('Total :x Revenue', ['x'=> $currencyCode]) }}</span>
                                        <strong>
                                            <h4>{{ moneyFormat($currencyCode , formatNumber($currency['revenue'], $currency['currency_id'])) }}</h4>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                    @empty
                        <h3 class="panel-title text-center">{{ __('Data not available.') }}</h3>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <p class="panel-title f-14 fw-bold ml-5 f-14">{{ __('All Revenues') }}</p>
        </div>
        <div class="col-md-4">
            <div class="btn-group pull-right">
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat f-14" id="csv" target="_blank">{{ __('CSV') }}</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat f-14" id="pdf" target="_blank">{{ __('PDF') }}</a>
            </div>
        </div>
    </div>

    <div class="box mt-20">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 f-14">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <div class="table-responsive">
                                {!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra_body_scripts')
    <!-- Bootstrap daterangepicker -->
    <script src="{{ asset('public/dist/plugins/daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>

    <!-- jquery.dataTables js -->
    <script src="{{ asset('public/dist/plugins/DataTables/DataTables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/DataTables/Responsive/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>

    {!! $dataTable->scripts() !!}
    
    <script type="text/javascript">
        var csvUrl = "{{ route('admin.agents.revenues.printcsv') }}";
        var pdfUrl = "{{ route('admin.agents.revenues.printpdf') }}";
        let dateRangePickerText = '{{ __("Pick a date range") }}';
        var sessionDateFormateType = '{{ Session::get("date_format_type") }}'
        var startDate = "{!! $from !!}";
        var endDate = "{!! $to !!}";
    </script>

    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/revenues.min.js') }}"></script>
    <script src="{{ asset('public/admin/customs/js/daterange-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/admin/customs/js/csv-pdf.min.js') }}" type="text/javascript"></script>
@endpush
