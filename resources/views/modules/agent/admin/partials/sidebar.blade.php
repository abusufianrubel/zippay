@if ((Common::has_permission(auth('admin')->id(), 'view_agent') ))
    <li class="treeview {{ isset($menu) && $menu == 'agents' ? 'active' : '' }}">
        <a href="javascript:void(0)">
            <i class="fa fa-user-times"></i><span>{{ __('Agent') }}</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <!-- Agent Packages -->
            @if (Common::has_permission(auth('admin')->id(), 'view_package'))
                <li class="child {{ isset($sub_menu) && $sub_menu == 'packages' ? 'active' : '' }}">
                    <a href="{{ route('admin.agents.packages.index') }}"><i class="fa fa-archive"></i><span>{{ __('Packages') }}</span></a>
                </li>
            @endif

            <!-- Agent -->
            @if (Common::has_permission(auth('admin')->id(), 'view_agent'))
                <li class="child {{ isset($sub_menu) && $sub_menu == 'agents' ? 'active' : '' }}">
                    <a href="{{ route('admin.agents.agents.index') }}"><i class="fa fa-user"></i><span>{{ __('Agents') }}</span></a>
                </li>
            @endif

            <!-- Agent Fees & Limit -->
            @if (Common::has_permission(auth('admin')->id(), 'view_agent_feeslimit'))
                <li class="child {{ isset($sub_menu) && $sub_menu == 'feeslimit' ? 'active' : '' }}">
                    <a href="{{ route('admin.agents.feeslimits.index') }}"><i class="fa fa-money"></i><span>{{ __('Fees & Limits') }}</span></a>
                </li>
            @endif

            <!-- Agent Cashin list -->
            @if (Common::has_permission(auth('admin')->id(), 'view_cashin'))
                <li class="child {{ isset($sub_menu) && $sub_menu == 'cashin' ? 'active' : '' }}">
                    <a href="{{ route('admin.agents.cashin.index') }}"><i class="fa fa-arrow-down"></i><span>{{ __('Cash In') }}</span></a>
                </li>
            @endif

            <!-- Agent Cashout list -->
            @if (Common::has_permission(auth('admin')->id(), 'view_cashout'))
                <li class="child {{ isset($sub_menu) && $sub_menu == 'cashout' ? 'active' : '' }}">
                    <a href="{{ route('admin.agents.cashout.index') }}"><i class="fa fa-arrow-up"></i><span>{{ __('Cash Out') }}</span></a>
                </li>
            @endif

            <!-- Agent Revenue list -->
            @if (Common::has_permission(auth('admin')->id(), 'view_agent_revenue'))
                <li class="child {{ isset($sub_menu) && $sub_menu == 'revenues' ? 'active' : '' }}">
                    <a href="{{ route('admin.agents.revenues.index') }}"><i class="fa fa-line-chart"></i><span>{{ __('Revenues') }}</span></a>
                </li>
            @endif
        </ul>
    </li>
@endif