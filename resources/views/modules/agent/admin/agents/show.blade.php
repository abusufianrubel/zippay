@extends('admin.layouts.master')

@section('title', __('Agent Details'))

@section('head_style')
    <link rel="stylesheet" href="{{ asset('Modules/Agent/Resources/assets/css/agent-details.min.css') }}">
@endsection

@section('page_content')
    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @php
                                    $img_path = public_path('Modules/Agent/Resources/assets/images/profile/' . $agent->photo);
                                @endphp
                                @if ($agent->photo && file_exists($img_path))
                                    <img class="profile-user-img img-fluid img-circle" 
                                    src="{{ asset('Modules/Agent/Resources/assets/images/profile/' . $agent->photo) }}"
                                     alt="{{ __('User profile picture') }}">
                                @else
                                    <img class="profile-user-img img-fluid img-circle" 
                                    src="{{ asset('Modules/Agent/Resources/assets/images/agent.png') }}" 
                                    alt="{{ __('User profile picture') }}">
                                @endif
                            </div>
                            <p class="mb-0 profile-tittle mt-2">{{ getColumnValue($agent) }}</p>
                            <p class="text-muted text-center info-tittle mt-1">{{ getStatus($agent->status) }}</p>
                            <ul class="list-group list-group-unbordered mb-3 mt-4">
                                @foreach ($agentWallet as $item)
                                <li class="list-group-item d-flex justify-content-between">
                                    <b class="profile-subtittle">{{ optional($item->currency)->name }}</b> 
                                    <a class="float-right profile-subtittle">
                                        {{ moneyFormat(optional($item->currency)->symbol, 
                                        formatNumber($item->balance, $item->currency_id)) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <p>{{ __('Agent Details') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <form>
                                        <div class="card-body">
                                            <div class="min-[1230px]:flex gap-[40px]">
                                                <div class="flex-1 d-flex gap-3 justify-content-between">
                                                    <label for="firstName" class="form-label info-tittle">{{ __('First Name') }}</label>
                                                    <p id="firstName" class="mb-0 info-tittle">{{ $agent->first_name }}</p>
                                                </div>
                                                <div class="flex-1 d-flex gap-3 justify-content-between">
                                                    <label for="lastName" class="form-label info-tittle">{{ __('Last Name') }}</label>
                                                    <p id="lastName" class="mb-0 info-tittle">{{ $agent->last_name }}</p>
                                                </div>
                                            </div>

                                            <div class="min-[1230px]:flex gap-[40px]">
                                                <div class="flex-1 d-flex gap-3 justify-content-between">
                                                    <label for="email" class="form-label info-tittle">{{ __('Email') }}</label>
                                                    <p id="email" class="mb-0 info-tittle">{{ $agent->email }}</p>
                                                </div>
                                                <div class="flex-1 d-flex gap-3 justify-content-between">
                                                    <label for="phone" class="form-label info-tittle">{{ __('Phone') }}</label>
                                                    <p id="phone" class="mb-0 info-tittle">{{ $agent->formatted_phone }}</p>
                                                </div>
                                            </div>

                                            <div class="min-[1230px]:flex gap-[40px]">
                                                <div class="flex-1 d-flex gap-3 justify-content-between">
                                                    <label for="businessName" class="form-label info-tittle">{{ __('Business Name') }}</label>
                                                    <p id="businessName" class="mb-0 info-tittle">{{ $agent->business_name }}</p>
                                                </div>
                                                <div class="flex-1 d-flex gap-3 justify-content-between">
                                                    <label for="packageName" class="form-label info-tittle">{{ __('Package Name') }}</label>
                                                    <p id="packageName" class="mb-0 info-tittle">{{ $agent->agentPackage->name }}</p>
                                                </div>
                                            </div>

                                            <div class="min-[1230px]:flex gap-[40px]">
                                                <div class="flex-1 d-flex gap-3 justify-content-between mt-1">
                                                    <label for="city" class="form-label info-tittle">{{ __('City') }}</label>
                                                    <p id="city" class="mb-0 info-tittle">{{ $agent->city }}</p>
                                                </div>
                                                <div class="flex-1 d-flex gap-3 justify-content-between mt-1">
                                                    <label for="state" class="form-label info-tittle">{{ __('State') }}</label>
                                                    <p id="state" class="mb-0 info-tittle">{{ $agent->state }}</p>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="min-[1230px]:flex gap-[40px]">
                                                <div class="flex-1 d-flex gap-3 justify-content-between mt-1">
                                                    <label for="country" class="form-label info-tittle">{{ __('Country') }}</label>
                                                    <p id="country" class="mb-0 info-tittle">{{ $agent->country->name }}</p>
                                                </div>
                                                <div class="flex-1 d-flex gap-3 justify-content-between mt-1">
                                                    <label for="state" class="form-label info-tittle">{{ __('Time zone') }}</label>
                                                    <p id="state" class="mb-0 info-tittle">{{ $agent->timezone }}</p>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="mt-3 bg-white mx-0 p-[28px]">
                        <p class="wallet-tittle">{{ __('Wallets') }}</p>
                        <p class="wallet-subtittle mt-2 mb-0">{{ __('Agent wallet list') }}
                        </p>
                    </div>

                    <div class="grid min-[1230px]:grid-cols-2 min-[1550px]:grid-cols-4 gap-[30px] bg-white mx-0 p-[28px]">
                        @foreach ($walletLists as $key => $wallet)
                        <div class="">
                            <div class="wallet-container bg-[#F8F6FF]">
                                <div class="d-flex justify-content-between gap-1 align-items-center">
                                    <p class="currency-tittle pb-0">{{ $key }}</p>
                                    @if ($wallet['default'] == 'Yes')
                                        <p class="digit-tittle">{{ __('Default')}}</p>
                                    @endif
                                    
                                    <div class="dash-currency-sign d-flex justify-content-center align-items-center">
                                        <img src="{{ image($wallet['logo'], 'currency') }}" alt="Currency" class="img-fluid" height="60" width="60">
                                    </div>
                                </div>
                                <p class="digit-tittle">{{ moneyFormat($wallet['symbol'], formatNumber($wallet['balance'], $wallet['currency_id'])) }}</p>

                                <div class="d-flex justify-content-between gap-1 align-items-center">
                                    <div>
                                        <p class="mb-0 ammount-tittle">{{ moneyFormat($wallet['symbol'], formatNumber($wallet['cashin'], $wallet['currency_id'])) }}</p>
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="currency-label">{{ __('Cash In') }}</span>
                                            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5 5.38752L4.24889 4.60262L3.03111 5.87519L3.03111 0.555007C3.03111 0.248485 2.79333 -2.63143e-08 2.5 -2.98122e-08C2.20668 -3.33101e-08 1.96889 0.248485 1.96889 0.555007L1.96889 5.87519L0.751105 4.60262L3.11535e-08 5.38752L2.5 8L5 5.38752Z" fill="#009651"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 ammount-tittle">{{ moneyFormat($wallet['symbol'], formatNumber($wallet['cashout'], $wallet['currency_id'])) }}</p>
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="currency-label">{{ __('Cash Out') }}</span>
                                            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M-1.14195e-07 2.61248L0.751105 3.39738L1.96889 2.12481L1.96889 7.44499C1.96889 7.75151 2.20667 8 2.5 8C2.79332 8 3.03111 7.75152 3.03111 7.44499L3.03111 2.12481L4.2489 3.39738L5 2.61248L2.5 1.09278e-07L-1.14195e-07 2.61248Z" fill="#C8191C"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="mb-0 ammount-tittle">{{ moneyFormat($wallet['symbol'], formatNumber($wallet['revenue'], $wallet['currency_id'])) }}</p>
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="currency-label">{{ __('Revenue') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection