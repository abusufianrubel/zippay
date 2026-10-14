@extends('admin.layouts.master')

@section('title', __('Agent Cashout'))

@section('head_style')
    <!-- Bootstrap daterangepicker -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/daterangepicker/daterangepicker.min.css')}}">

    <link rel="stylesheet" href="{{ asset('dist/plugins/DataTables/DataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/DataTables/Responsive/css/responsive.dataTables.min.css') }}">

    <!-- jquery-ui -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/libraries/jquery-ui/jquery-ui.min.css')}}">
@endsection

@section('page_content')
    <div class="box" id="cashout">
        <div class="box-body pb-20">
            <form action="{{ route('admin.agents.cashout.index') }}" method="get" class="form-horizontal">
                @csrf
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
                                        <option value="all">{{ __('All') }}</option>
                                        @foreach($transactionCurrencies as $cashout)
                                            <option value="{{ $cashout->currency_id }}" {{ ($cashout->currency_id == $currency) ? 'selected' : '' }}>
                                                {{ $cashout->currency?->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="pr-25">
                                    <label class="f-14 fw-bold mb-1" for="status">{{ __('Status') }}</label><br>
                                    <select class="form-control select2" name="status" id="status">
                                        <option value="all">{{ __('All') }}</option>
                                        @foreach($transactionStatus as $cashout)
                                            <option value="{{ $cashout->status }}" {{ ($cashout->status == $status) ? 'selected' : '' }}>
                                                {{ ($cashout->status == 'Blocked') ? 'Cancelled' : $cashout->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- User -->
                                <div class="pr-25">
                                    <label class="f-14 fw-bold mb-1" for="user_input">{{ __('User') }}</label><br>
                                    <div class="input-group">
                                        <input id="user_input" type="text" name="user" placeholder="{{ __('Enter Name') }}" class="form-control f-14" value="{{ !empty($getName) ? getColumnValue($getName) : null }}">
                                    </div>
                                    <span class="f-12"  id="error-user"></span>
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

    <div class="row">
        <div class="col-md-8">
            <p class="panel-title f-14 fw-bold ml-5 f-14">{{ __('All CashOut') }}</p>
        </div>
        <div class="col-md-4">
            <div class="btn-group pull-right">
                <a href="" class="btn btn-sm btn-default btn-flat f-14" id="csv">{{ __('CSV') }}</a>
                <a href="" class="btn btn-sm btn-default btn-flat f-14" id="pdf">{{ __('PDF') }}</a>
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
@endsection

@push('extra_body_scripts')

    <!-- Bootstrap daterangepicker -->
    <script type="text/javascript" src="{{ asset('dist/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('dist/plugins/DataTables/DataTables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/plugins/DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>

    <!-- jquery-ui -->
    <script src="{{ asset('dist/libraries/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>

    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var csvUrl = "{{ route('admin.agents.cashout.printcsv') }}";
        var pdfUrl = "{{ route('admin.agents.cashout.printpdf') }}";
        var user_input = $('form').find("input[type='text']").val();
        var userSearchUrl = "{{ route('admin.agents.cashout.search.user') }}";
        var userNotExistText = "{{ __('User Does Not Exist!') }}";
        let dateRangePickerText = '{{ __("Pick a date range") }}';
        var sessionDateFormateType = '{{ Session::get("date_format_type") }}'
        var startDate = "{!! $from !!}";
        var endDate = "{!! $to !!}";
    </script>

    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/cashout.min.js') }}"></script>
    <script src="{{ asset('admin/customs/js/csv-pdf.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/customs/js/daterange-select.min.js') }}" type="text/javascript"></script>
@endpush
