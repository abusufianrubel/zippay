{{-- <!-- Sidebar Start -->
<div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <div class="bg-secondary vh-100 position-fixed d-flex flex-column w-inherit drop-parent">
        <div>
            <a href="{{ url('/') }}"><img class="ml-40 mt-20 pay-logo img-fluid" src="{{ image(settings('logo'), 'logo') }}" alt="{{ settings('name') }}"></a>
        </div>
        <div class="flex-grow-1 px-4 px-res mt-43 bg-secondary position-relative overflow-auto hide-thin-scrollbar thin-scrollbar">
            <ul class="list-unstyled ps-0 accordion accordion-flush position-absolute w-268" id="accordion-menu">

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('user.dashboard') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.dashboard') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.dashboard') !!}</span>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <!-- Wallets -->
                <li>
                    <a href="{{ route('user.wallets.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.wallets.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.wallets.*') !!}</span>
                        <span>{{ __('Wallets') }}</span>
                    </a>
                </li>

                <li class="mb-21 d-flex align-items-center res-trans text-warning f-13 ml-20 mt-39 gilroy-Semibold text-uppercase">{{ __('Activities') }}</li>

                <!-- Transactions -->
                <li>
                    <a href="{{ route('user.transactions.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.transactions.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.transactions.*') !!}</span>
                        <span>{{ __('Transactions') }}</span>
                    </a>
                </li>

                <!-- Deposit Money -->
                @if(Common::has_permission(auth()->id(),'manage_deposit'))
                <li>
                    <a href="{{ route('user.deposit.create') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.deposit.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.deposit.*') !!}</span>
                        <span>{{ __('Deposit Money') }}</span>
                    </a>
                </li>
                @endif

                <!-- Send Money -->
                @if(Common::has_permission(auth()->id(),'manage_transfer'))
                <li>
                    <a href="{{ route('user.send_money.create') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.send_money.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.send_money.*') !!}</span>
                        <span>{{ __('Send Money') }}</span>
                    </a>
                </li>
                @endif

                <!-- Request Money -->
                @if(Common::has_permission(auth()->id(),'manage_request_payment'))
                <li>
                    <a href="{{ route('user.request_money.create') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.request_money.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.request_money.*') !!}</span>
                        <span>{{ __('Request Money') }}</span>
                    </a>
                </li>
                @endif

                <!-- Exchange Money -->
                @if(Common::has_permission(auth()->id(),'manage_exchange'))
                <li>
                    <a href="{{ route('user.exchange_money.create') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.exchange_money.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.exchange_money.*') !!}</span>
                        <span>{{ __('Exchange Money') }}</span>
                    </a>
                </li>
                @endif

                <!-- Withdraw Money -->
                @if(Common::has_permission(auth()->id(),'manage_withdrawal'))
                <li class="accordion-item bg-secondary border-0">
                    <div class="accordion-header {{  request()->route()->named('user.withdrawal.*') ? 'bg-info' : '' }}" id="flush-headtwo">
                        <button class="mb-1 shadow-none bg-transparent p-0 d-flex align-items-center list-option h-46 accordion-button accordion-icon collapsed {{  request()->route()->named('user.withdrawal.*') ? 'text-white bg-info' : 'text-info-100' }}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            <span class="ms-3 mr-20">{!! menuSvgIcon('user.withdrawal.*') !!}</span>
                            <span class="child-currency">{{ __('Withdrawals') }}</span>
                        </button>
                    </div>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse {{ request()->route()->named('user.withdrawal.*') ? 'show' : '' }}" aria-labelledby="flush-headtwo" data-bs-parent="#accordion-menu">
                        <ul class="accordion-body collapse-child ml-28 p-0 pl-16 mr-20">

                            <!-- Withdraw Money -->
                            <li><a href="{{ route('user.withdrawal.create') }}" class="mb-2 ml-34 pl-14 f-14 d-flex align-items-center list-option h-46 {{  request()->route()->named('user.withdrawal.create') | request()->route()->named('user.withdrawal.confirm') | request()->route()->named('user.withdrawal.success') ? 'text-white bg-info' : 'text-info-100' }}">{{ __('Withdraw Money') }}</a></li>
                            
                            <!-- Withdraw List -->
                            <li><a href="{{ route('user.withdrawal.index') }}" class="mb-2 ml-34 pl-14 f-14 d-flex align-items-center list-option h-46 {{  request()->route()->named('user.withdrawal.index') ? 'text-white bg-info' : 'text-info-100' }}">{{ __('Withdrawal List') }}</a></li>

                            <!-- Withdraw Settings -->
                            <li><a href="{{ route('user.withdrawal.setting') }}" class="mb-2 ml-34 pl-14 f-14 d-flex align-items-center list-option h-46 {{  request()->route()->named('user.withdrawal.setting') ? 'text-white bg-info' : 'text-info-100' }}">{{ __('Withdrawal Settings') }}</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Merchant Payments -->
                @if(Common::has_permission(auth()->id(),'manage_merchant'))
                <li class="accordion-item bg-secondary border-0">
                    <div class="accordion-header {{  request()->route()->named('user.merchants.*') ? 'bg-info' : '' }}" id="flush-headthree">
                        <button class="mb-1 shadow-none bg-transparent p-0 d-flex align-items-center list-option h-46 accordion-button accordion-icon  collapsed {{  request()->route()->named('user.merchants.*') ? 'text-white bg-info' : 'text-info-100' }}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            <span class="ms-3 mr-20">{!! menuSvgIcon('user.merchants.*') !!}</span>
                            <span class="child-currency">{{ __('Merchants') }}</span>
                        </button>
                    </div>
                    <div id="flush-collapseThree" class="accordion-collapse collapse {{ request()->route()->named('user.merchants.*') ? 'show' : '' }}" aria-labelledby="flush-headthree" data-bs-parent="#accordion-menu">
                        <ul class="accordion-body collapse-child ml-28 p-0 pl-16 mr-20">

                            <!-- Merchants List -->
                            <li><a href="{{ route('user.merchants.index') }}" class="mb-2 ml-34 pl-14 f-14 d-flex align-items-center list-option h-46 {{ request()->route()->named('user.merchants.index') || request()->route()->named('user.merchants.edit') || request()->route()->named('user.merchants.create') ? 'text-white bg-info' : 'text-info-100' }}">{{ __('Merchants') }}</a></li>

                            <!-- Merchant Payments List -->
                            <li><a href="{{ route('user.merchants.payments') }}" class="mb-2 ml-34 pl-14 f-14 d-flex align-items-center list-option h-46 {{  request()->route()->named('user.merchants.payments') ? 'text-white bg-info' : 'text-info-100' }}">{{ __('Payments') }}</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @foreach (getAddons() as $addon)
                    @if (isActive($addon) && view()->exists(strtolower($addon) . '::user.layouts.sidebar'))
                        @include(strtolower($addon) . '::user.layouts.sidebar')
                    @endif
                @endforeach

                <li class="mb-20 d-flex align-items-center text-warning f-13 ml-20 mt-38 gilroy-Semibold res-other text-uppercase">{{ __('Others') }}</li>

                <!-- Dispute -->
                <li>
                    <a href="{{ route('user.disputes.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.disputes.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.disputes.*') !!}</span>
                        <span>{{ __('Disputes') }}</span>
                    </a>
                </li>

                <!-- Tickets -->
                <li>
                    <a href="{{ route('user.tickets.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.tickets.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.tickets.*') !!}</span>
                        <span>{{ __('Tickets') }}</span>
                    </a>
                </li>

                <!-- Profile -->
                <li>
                    <a href="{{ route('user.profiles.index') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.profiles.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.profiles.*') !!}</span>
                        <span>{{ __('Profile') }}</span>
                    </a>
                </li>

                <!-- Verifications -->
                <li>
                    <a href="{{ route('user.kyc.verifications.initiate') }}" class="mb-1 d-flex align-items-center list-option h-46 mt-7 {{ request()->route()->named('user.setting.*') || request()->route()->named('user.kyc.verifications.*') ? 'text-white bg-info' : 'text-info-100' }}">
                        <span class="ms-3 mr-20">{!! menuSvgIcon('user.setting.*') !!}</span>
                        <span>{{ __('Verifications') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar End --> --}}

<div class="sidebar-wrapper">
    <div class="close-btn">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <div class="sidebar-logo">
        <a href="{{ url('/') }}"><img src="{{ asset('public/user') }}/assets/images/logo.png" alt="{{ __('logo') }}"></a>
    </div>
    <ul>
        <li class="{{ request()->route()->named('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/dashboard.png" alt="{{ __('Dashboard') }}"> <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li class="{{ request()->route()->named('user.transactions.*') ? 'active' : '' }}">
            <a href="{{ route('user.transactions.index') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/transactions.png" alt="{{ __('Transactions') }}"> <span>{{ __('Transactions') }}</span>
            </a>
        </li>
        <li class="{{ request()->route()->named('user.wallets.*') ? 'active' : '' }}">
            <a href="pay.html">
                <img src="{{ asset('public/user') }}/assets/images/icon/pay.png" alt="Pay"> <span>Pay</span>
            </a>
        </li>
        <li class="{{ request()->route()->named('user.receives.*') ? 'active' : '' }}">
            <a href="{{ route('user.request_money.create') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/receive.png" alt="Receive"> <span>Receive</span>
            </a>
        </li>
        <li class="{{ request()->route()->named('user.exchange_money.*') ? 'active' : '' }}">
            <a href="{{ route('user.exchange_money.create') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/exchange.png" alt="{{ __('Exchange') }}"> <span>{{ __('Exchange') }}</span>
            </a>
        </li>
        <li>
            <a href="recipients.html">
                <img src="{{ asset('public/user') }}/assets/images/icon/recipients.png" alt="Recipients"> <span>Recipients</span>
            </a>
        </li>
        <li>
            <a href="crypto.html">
                <img src="{{ asset('public/user') }}/assets/images/icon/crypto.png" alt="Crypto"> <span>Crypto</span>
            </a>
        </li>
        <li class="{{ request()->route()->named('user.deposits.*') ? 'active' : '' }}">
            <a href="{{ route('user.deposit.create') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/deposit.png" alt="Deposit"> <span>Deposit Money</span>
            </a>
        </li>
        <li class="{{ request()->route()->named('user.withdrawals.*') ? 'active' : '' }}">
            <a href="{{ route('user.withdrawal.create') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/withdraw.png" alt="Withdraw"> <span>Withdraw Money</span>
            </a>
        </li>
    </ul>
    <ul class="bottom-item">
        <li>
            <a href="{{ route('user.profiles.index') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/account.png" alt="Account"> <span>Account</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.tickets.create') }}">
                <img src="{{ asset('public/user') }}/assets/images/icon/support.png" alt="Support"> <span>Support</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <img src="{{ asset('public/user') }}/assets/images/icon/quit.png" alt="Quit"> <span>Quit</span>
            </a>
        </li>
    </ul>
    <div class="pt-120">
        <div class="invite-now">
            <div class="img-area">
                <img src="{{ asset('public/user') }}/assets/images/invite-now-illus.png" alt="user-1">
            </div>
            <p>Invite your friend and get $25</p>
            <a href="javascript:void(0)" class="cmn-btn">Invite Now</a>
        </div>
    </div>
</div>