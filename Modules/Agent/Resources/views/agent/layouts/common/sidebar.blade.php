<!-- Sidebar Start -->
<div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <div class="bg-secondary vh-100 position-fixed d-flex flex-column w-inherit drop-parent">
        <div>
            <a href="{{ url('/') }}"><img class="ml-40 mt-20 pay-logo img-fluid" src="{{ image(settings('logo'), 'logo') }}" alt="{{ settings('name') }}"></a>
        </div>
        <div class="flex-grow-1 px-4 px-res mt-43 bg-secondary position-relative overflow-auto hide-thin-scrollbar thin-scrollbar">
            <ul class="list-unstyled ps-0 accordion accordion-flush position-absolute w-268" id="accordion-menu">

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('agent.dashboard') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('agent.dashboard') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('agent.dashboard') !!}</span>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <!-- Wallets -->
                <li>
                    <a href="{{ route('agent.profile.wallet') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('agent.profile.wallet') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.wallets.*') !!}</span>
                        <span>{{ __('Wallets') }}</span>
                    </a>
                </li>

                <li class="mb-21 d-flex align-items-center res-trans text-warning f-13 ml-20 mt-39 gilroy-Semibold text-uppercase">{{ __('Transactions') }}</li>

                <!-- Transactions -->
                <li>
                    <a href="{{ route('agent.transaction.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('agent.transaction.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.transactions.*') !!}</span>
                        <span>{{ __('Transactions') }}</span>
                    </a>
                </li>

                <!-- Cash in -->
                <li>
                    <a href="{{ route('agent.cashin.create') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('agent.cashin.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('agent.deposit.create') !!}</span>
                        <span>{{ __('Cash In') }}</span>
                    </a>
                </li>

                <!-- Cash Out -->
                <li>
                    <a href="{{ route('agent.cashout.create') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('agent.cashout.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('agent.withdrawal.create') !!}</span>
                        <span>{{ __('Cash Out') }}</span>
                    </a>
                </li>

                <!-- Profile -->
                <li>
                    <a href="{{ route('agent.profile.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('agent.profile.index') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('agent.profiles.*') !!}</span>
                        <span>{{ __('Profile') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar End -->
