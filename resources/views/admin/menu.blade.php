@php
    $admin_logo = getSettingsValByName('company_logo');
    $ids = parentId();
    $authUser = \App\Models\User::find($ids);
    $subscription = \App\Models\Subscription::find($authUser->subscription);
    $routeName = \Request::route() ? \Request::route()->getName() : '';
    $pricing_feature_settings = getSettingsValByIdName(1, 'pricing_feature');

    $theme_mode = getSettingsValByName('theme_mode');
    $light_logo = getSettingsValByName('light_logo');
    if (auth()->user()->type != 'super admin') {
        $light_logo = getSettingsValByName('company_light_logo');
    }

@endphp
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand text-primary">
                @if ($theme_mode == 'dark')
                    <img src="{{ asset(Storage::url('upload/logo/')) . '/' . (isset($light_logo) && !empty($light_logo) ? $light_logo : 'logo.png') }}"
                        alt="" class="logo logo-lg" />
                @else
                    <img src="{{ asset(Storage::url('upload/logo/')) . '/' . (isset($admin_logo) && !empty($admin_logo) ? $admin_logo : 'logo.png') }}"
                        alt="" class="logo logo-lg" />
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>{{ __('Home') }}</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item {{ in_array($routeName, ['dashboard', 'home', '']) ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @if (\Auth::user()->type == 'super admin')
                    @if (Gate::check('manage user'))
                        <li class="pc-item {{ in_array($routeName, ['users.index', 'users.show']) ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                                <span class="pc-mtext">{{ __('Customers') }}</span>
                            </a>
                        </li>
                    @endif
                @else
                    @if (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage logged history'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="pc-mtext">{{ __('User Management') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['users.index', 'logged.history', 'role.index', 'role.create', 'role.edit']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage user'))
                                    <li class="pc-item {{ in_array($routeName, ['users.index']) ? 'active' : '' }}">
                                        <a class="pc-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage role'))
                                    <li
                                        class="pc-item  {{ in_array($routeName, ['role.index', 'role.create', 'role.edit']) ? 'active' : '' }}">
                                        <a class="pc-link" href="{{ route('role.index') }}">{{ __('Roles') }} </a>
                                    </li>
                                @endif
                                @if ($pricing_feature_settings == 'off' || optional($subscription)->enabled_logged_history == 1)

                                    @if (Gate::check('manage logged history'))
                                        <li
                                            class="pc-item  {{ in_array($routeName, ['logged.history']) ? 'active' : '' }}">
                                            <a class="pc-link"
                                                href="{{ route('logged.history') }}">{{ __('Logged History') }}</a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

                @if (Gate::check('manage order calendar') ||
                        Gate::check('manage expense') ||
                        Gate::check('manage invoice') ||
                        Gate::check('manage customer') ||
                        Gate::check('manage measurement') ||
                        Gate::check('manage order') ||
                        Gate::check('manage today order delivery') ||
                        Gate::check('manage today order') ||
                        Gate::check('manage contact') ||
                        Gate::check('manage note'))
                    <li class="pc-item pc-caption">
                        <label>{{ __('Business Management') }}</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>

                    @if (Gate::check('manage customer'))
                        <li class="pc-item {{ in_array($routeName, ['customer.index']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('customer.index') }}">
                                <span class="pc-micon"><i data-feather="user-check"></i></span>
                                <span class="pc-mtext">{{ __('Customer') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage measurement'))
                        <li
                            class="pc-item {{ in_array($routeName, ['measurement.index', 'measurement.create', 'measurement.edit', 'measurement.show']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('measurement.index') }}">
                                <span class="pc-micon"><i data-feather="bookmark"></i></span>
                                <span class="pc-mtext">{{ __('Measurement') }}</span>
                            </a>
                        </li>
                    @endif


                    @if (Gate::check('manage order') || Gate::check('manage today order delivery') || Gate::check('manage today order'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['order.index', 'order.create', 'order.edit', 'order.show', 'order.today.delivery', 'order.today']) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i data-feather="shopping-cart"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Order') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>


                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['order.index', 'order.create', 'order.edit', 'order.show', 'order.today.delivery', 'order.today']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage order'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['order.index', 'order.create', 'order.edit', 'order.show']) ? 'active' : '' }}">
                                        <a class="pc-link" href="{{ route('order.index') }}">{{ __('All') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage today order'))
                                    <li class="pc-item {{ in_array($routeName, ['order.today']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('order.today') }}">{{ __('Today Order') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage today order delivery'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['order.today.delivery']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('order.today.delivery') }}">{{ __('Today Delivery') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage order'))
                                    <li class="pc-item {{ in_array($routeName, ['order.kanban']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('order.kanban') }}">{{ __('Order Kanban') }}</a>
                                    </li>
                                    <li class="pc-item {{ in_array($routeName, ['production.kanban']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('production.kanban') }}">{{ __('Production Board') }}</a>
                                    </li>
                                    <li class="pc-item {{ in_array($routeName, ['worker-assignments.index']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('worker-assignments.index') }}">{{ __('Tailor Tasks') }}</a>
                                    </li>
                                    <li class="pc-item {{ in_array($routeName, ['materials.index']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('materials.index') }}">{{ __('Fabric Inventory') }}</a>
                                    </li>
                                    <li class="pc-item {{ in_array($routeName, ['pos.index']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('pos.index') }}">{{ __('POS Billing') }}</a>
                                    </li>
                                    <li class="pc-item {{ in_array($routeName, ['financials.analytics']) ? 'active' : '' }} ">
                                        <a class="pc-link"
                                            href="{{ route('financials.analytics') }}">{{ __('Financial Analytics') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Gate::check('manage order calendar'))
                        <li class="pc-item {{ in_array($routeName, ['calendar']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('calendar') }}">
                                <span class="pc-micon"><i data-feather="calendar"></i></span>
                                <span class="pc-mtext">{{ __('Calendar') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Gate::check('manage invoice'))
                        <li
                            class="pc-item {{ in_array($routeName, ['invoice.index', 'invoice.show']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('invoice.index') }}">
                                <span class="pc-micon"><i data-feather="file-minus"></i></span>
                                <span class="pc-mtext">{{ __('Invoice') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage expense'))
                        <li class="pc-item {{ in_array($routeName, ['expense.index']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('expense.index') }}">
                                <span class="pc-micon"><i data-feather="file"></i></span>
                                <span class="pc-mtext">{{ __('Expense') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage order report') ||
                            Gate::check('manage income report') ||
                            Gate::check('manage expense report') ||
                            Gate::check('manage profit loss report'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['order.data', 'income.data', 'expense.data', 'yearly.profit.loss'] ) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-report"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Report') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['order.data']) ? 'block' : 'none' }}">
                                <li class="pc-item {{ in_array($routeName, ['order.data']) ? 'active' : '' }}">
                                    <a class="pc-link" href="{{ route('order.data') }}">{{ __('Order') }}</a>
                                </li>
                                <li class="pc-item {{ in_array($routeName, ['income.data']) ? 'active' : '' }}">
                                    <a class="pc-link" href="{{ route('income.data') }}">{{ __('Income') }}</a>
                                </li>
                                <li class="pc-item {{ in_array($routeName, ['expense.data']) ? 'active' : '' }}">
                                    <a class="pc-link" href="{{ route('expense.data') }}">{{ __('Expense') }}</a>
                                </li>
                                <li
                                    class="pc-item {{ in_array($routeName, ['yearly.profit.loss']) ? 'active' : '' }}">
                                    <a class="pc-link"
                                        href="{{ route('yearly.profit.loss') }}">{{ __('Year Profit Loss') }}</a>
                                </li>

                            </ul>
                        </li>
                    @endif
                    @if (Gate::check('manage contact'))
                        <li class="pc-item {{ in_array($routeName, ['contact.index']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('contact.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-phone-call"></i></span>
                                <span class="pc-mtext" class="pc-mtext">{{ __('Contact Diary') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage note'))
                        <li class="pc-item {{ in_array($routeName, ['note.index']) ? 'active' : '' }} ">
                            <a class="pc-link" href="{{ route('note.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-notebook"></i></span>
                                <span class="pc-mtext" class="pc-mtext">{{ __('Notice Board') }}</span>
                            </a>
                        </li>
                    @endif
                @endif

                @if (Gate::check('manage measurement unit') ||
                        Gate::check('manage tax') ||
                        Gate::check('manage cloth type') ||
                        Gate::check('manage notification'))
                    <li class="pc-item pc-caption">
                        <label>{{ __('System Configuration') }}</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>


                    @if (Gate::check('manage cloth type'))
                        <li
                            class="pc-item {{ in_array($routeName, ['cloth-type.index', 'cloth-type.create', 'cloth-type.edit', 'cloth-type.show']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('cloth-type.index') }}">
                                <span class="pc-micon"><i data-feather="shield"></i></span>
                                <span class="pc-mtext">{{ __('Cloth Type') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage measurement unit'))
                        <li class="pc-item {{ in_array($routeName, ['measurement-unit.index']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('measurement-unit.index') }}">
                                <span class="pc-micon"><i data-feather="wind"></i></span>
                                <span class="pc-mtext">{{ __('Measurement Unit') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage tax'))
                        <li class="pc-item {{ in_array($routeName, ['tax.index']) ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('tax.index') }}">
                                <span class="pc-micon"><i data-feather="anchor"></i></span>
                                <span class="pc-mtext">{{ __('Tax') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (Gate::check('manage expense category') || Gate::check('manage expense sub category'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['expense-category.index', 'expense-sub-category.index']) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Expense') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['expense-category.index']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage expense category'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['expense-category.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('expense-category.index') }}">{{ __('Category') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage expense sub category'))
                                    <li
                                        class="pc-item  {{ in_array($routeName, ['expense-sub-category.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('expense-sub-category.index') }}">{{ __('Sub Category') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Gate::check('manage notification'))
                        <li class="pc-item {{ in_array($routeName, ['notification.index']) ? 'active' : '' }} ">
                            <a href="{{ route('notification.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-bell"></i></span>
                                <span class="pc-mtext">{{ __('Email Notification') }}</span>
                            </a>
                        </li>
                    @endif
                @endif


                @if (Auth::user()->type == 'super admin')
                    <li class="pc-item pc-caption">
                        <label>{{ __('System Settings') }}</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>

                    @if (Gate::check('manage FAQ') || Gate::check('manage Page'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-layout-rows"></i>
                                </span>
                                <span class="pc-mtext">{{ __('CMS') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['homepage.index', 'FAQ.index', 'pages.index', 'footerSetting']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage home page'))
                                    <li class="pc-item {{ in_array($routeName, ['homepage.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('homepage.index') }}"
                                            class="pc-link">{{ __('Home Page') }}</a>
                                    </li>
                                @endif
                                <li class="pc-item {{ in_array($routeName, ['blog.admin.index', 'blog.create', 'blog.edit']) ? 'active' : '' }} ">
                                    <a href="{{ route('blog.admin.index') }}"
                                        class="pc-link">{{ __('Blog') }}</a>
                                </li>
                                @if (Gate::check('manage Page'))
                                    <li class="pc-item {{ in_array($routeName, ['pages.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('pages.index') }}"
                                            class="pc-link">{{ __('Custom Page') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage FAQ'))
                                    <li class="pc-item {{ in_array($routeName, ['FAQ.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('FAQ.index') }}" class="pc-link">{{ __('FAQ') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage footer'))
                                    <li class="pc-item {{ in_array($routeName, ['footerSetting']) ? 'active' : '' }} ">
                                        <a href="{{ route('footerSetting') }}"
                                            class="pc-link">{{ __('Footer') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage auth page'))
                                    <li class="pc-item {{ in_array($routeName, ['authPage.index']) ? 'active' : '' }} ">
                                        <a href="{{ route('authPage.index') }}"
                                            class="pc-link">{{ __('Auth Page') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Gate::check('manage pricing packages') || Gate::check('manage pricing transation'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['subscriptions.index', 'subscriptions.show', 'subscription.transaction']) ? 'pc-trigger active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-package"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Pricing') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['subscriptions.index', 'subscriptions.show', 'subscription.transaction']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage pricing packages'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['subscriptions.index', 'subscriptions.show']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('subscriptions.index') }}">{{ __('Packages') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage pricing transation'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['subscription.transaction']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('subscription.transaction') }}">{{ __('Transactions') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Gate::check('manage coupon') || Gate::check('manage coupon history'))
                        <li
                            class="pc-item pc-hasmenu {{ in_array($routeName, ['coupons.index', 'coupons.history']) ? 'active' : '' }}">
                            <a href="#!" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-shopping-cart-discount"></i>
                                </span>
                                <span class="pc-mtext">{{ __('Coupons') }}</span>
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="pc-submenu"
                                style="display: {{ in_array($routeName, ['coupons.index', 'coupons.history']) ? 'block' : 'none' }}">
                                @if (Gate::check('manage coupon'))
                                    <li class="pc-item {{ in_array($routeName, ['coupons.index']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('coupons.index') }}">{{ __('All Coupon') }}</a>
                                    </li>
                                @endif
                                @if (Gate::check('manage coupon history'))
                                    <li
                                        class="pc-item {{ in_array($routeName, ['coupons.history']) ? 'active' : '' }}">
                                        <a class="pc-link"
                                            href="{{ route('coupons.history') }}">{{ __('Coupon History') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Gate::check('manage account settings') ||
                            Gate::check('manage password settings') ||
                            Gate::check('manage general settings') ||
                            Gate::check('manage email settings') ||
                            Gate::check('manage payment settings') ||
                            Gate::check('manage company settings') ||
                            Gate::check('manage seo settings') ||
                            Gate::check('manage google recaptcha settings'))
                        <li class="pc-item {{ in_array($routeName, ['setting.index']) ? 'active' : '' }} ">
                            <a href="{{ route('setting.index') }}" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-settings"></i></span>
                                <span class="pc-mtext">{{ __('Settings') }}</span>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
            <div class="w-100 text-center">
                <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"></div>
            </div>
        </div>
    </div>
</nav>
