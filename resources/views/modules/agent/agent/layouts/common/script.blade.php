<script src="{{ asset('dist/libraries/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('dist/libraries/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('user/templates/js/chart.umd.min.js') }}"></script>
<script src="{{ asset('user/templates/js/main.min.js') }}"></script>
<script src="{{ asset('user/customs/js/common.min.js') }}"></script>

<script type="text/javascript">
    var SITE_URL = "{{ url('/') }}";
    var FIATDP = "{{ number_format(0, preference('decimal_format_amount', 2)) }}";
    var CRYPTODP = "{{ number_format(0, preference('decimal_format_amount_crypto', 8)) }}";
	var languageSwitchUrl = "{{ url('change-lang') }}";
</script>

<script src="{{ asset('Modules/Agent/Resources/assets/js/agent/language-switch.min.js') }}"></script>

@stack('js')