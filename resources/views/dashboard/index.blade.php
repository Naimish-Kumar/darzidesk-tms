@extends('layouts.app')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Dashboard') }}</li>
@endsection

@push('script-page')
    @if (\Auth::user()->type == 'owner')
        <script>
            var options = {
                chart: {
                    type: 'area',
                    height: 450,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#2ca58d', '#e74c3c'], // Income (green), Expense (red)
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'top'
                },
                markers: {
                    size: 1,
                    colors: ['#fff'],
                    strokeColors: ['#2ca58d', '#e74c3c'],
                    strokeWidth: 1,
                    shape: 'circle',
                    hover: {
                        size: 4
                    }
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        type: 'vertical',
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0
                    }
                },
                grid: {
                    show: false
                },
                series: [{
                        name: "Income",
                        data: {!! json_encode($result['incomeExpenseByMonth']['income']) !!}
                    },
                    {
                        name: "Expense",
                        data: {!! json_encode($result['incomeExpenseByMonth']['expense']) !!}
                    }
                ],
                xaxis: {
                    categories: {!! json_encode(@$result['incomeExpenseByMonth']['label']) !!},
                    tooltip: {
                        enabled: false
                    },
                    labels: {
                        hideOverlappingLabels: true
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector('#incomeExpenseByMonth'), options);
            chart.render();
        </script>
    @elseif (\Auth::user()->type == 'employee')
        <script>
            var options = {
                chart: {
                    type: 'bar',
                    height: 450,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#4CAF50', '#F44336'], // Completed (green), Pending (red)
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'top'
                },
                markers: {
                    size: 1,
                    colors: ['#fff'],
                    strokeColors: ['#4CAF50', '#F44336'],
                    strokeWidth: 1,
                    shape: 'circle',
                    hover: {
                        size: 4
                    }
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        type: 'vertical',
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0
                    }
                },
                grid: {
                    show: false
                },
                series: [{
                        name: "Completed",
                        data: {!! json_encode($result['totalOrderStatus']['completed']) !!}
                    },
                    {
                        name: "Pending",
                        data: {!! json_encode($result['totalOrderStatus']['pending']) !!}
                    }
                ],
                xaxis: {
                    categories: {!! json_encode(@$result['totalOrderStatus']['label']) !!},
                    tooltip: {
                        enabled: false
                    },
                    labels: {
                        hideOverlappingLabels: true
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    min: 0,
                    tickAmount: 5, // max 5 ticks
                    forceNiceScale: false,
                    labels: {
                        formatter: function(val) {
                            return Number.isInteger(val) ? val : ''; // only integers
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector('#totalOrderStatus'), options);
            chart.render();
        </script>
    @endif
@endpush
@section('content')
    <div class="row">
        @if (\Auth::user()->type == 'owner')
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-info">
                                    <i class="ti ti-package f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Subscription Plan') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ !empty($result['subscription']) ? $result['subscription']->title : __('No Plan') }}</h4>
                                    <a href="{{ route('subscriptions.index') }}" class="btn btn-sm btn-info btn-rounded">{{ __('Upgrade') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary">
                                    <i class="ti ti-settings f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('System Settings') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ __('Configuration') }}</h4>
                                    <a href="{{ route('setting.index') }}" class="btn btn-sm btn-primary btn-rounded">{{ __('Manage') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-secondary">
                                    <i class="ti ti-users f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Customer') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalCustomer'] }}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-warning">
                                    <i class="ti ti-package f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Cloth Type') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalClothType'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary">
                                    <i class="ti ti-history f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Income') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalIncome'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-danger">
                                    <i class="ti ti-credit-card f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Expense') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalExpense'] }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h5 class="mb-1">{{ __('Analysis Report') }}</h5>
                                <p class="text-muted mb-2">{{ __('Income and Expense Overview') }}</p>
                            </div>

                        </div>
                        <div id="incomeExpenseByMonth"></div>
                    </div>
                </div>
            </div>
        @elseif (\Auth::user()->type == 'employee')
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-secondary">
                                    <i class="ti ti-users f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Customer') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalCustomer'] }}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-warning">
                                    <i class="ti ti-ruler-2 f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Measurement') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalMeasurement'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary">
                                    <i class="ti ti-shopping-cart f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Orders') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalOrder'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-danger">
                                    <i class="ti ti-calendar-time f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Today Orders') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalTodayOrder'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h5 class="mb-1">{{ __('Analysis Report') }}</h5>
                                <p class="text-muted mb-2">{{ __('Order Pending and Completed Overview') }}</p>
                            </div>

                        </div>
                        <div id="totalOrderStatus"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center g-2">
                                <div class="col">
                                    <h5>{{ __('Order List') }}</h5>
                                </div>

                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-hover advance-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Order Date') }}</th>
                                            <th>{{ __('Deadline') }}</th>
                                            <th>{{ __('Cloth Type') }}</th>
                                            <th>{{ __('Gender') }}</th>
                                            <th>{{ __('Responsible') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result['notifyOrder'] as $order)
                                            <tr>
                                                <td>{{ orderPrefix() . $order->order_id }} </td>
                                                <td>{{ !empty($order->customers) ? $order->customers->name : '-' }} </td>
                                                <td>{{ dateFormat($order->order_date) }}</td>
                                                <td>{{ dateFormat($order->deadline_date) }}</td>
                                                <td>{{ !empty($order->clothTypes) ? $order->clothTypes->title : '-' }}</td>
                                                <td>{{ $order->gender }}</td>
                                                <td>{{ !empty($order->users) ? $order->users->name : '-' }}</td>
                                                <td>
                                                    @if ($order->status == 'pending')
                                                        <span
                                                            class="badge text-bg-warning">{{ \App\Models\Order::$status[$order->status] }}</span>
                                                    @elseif($order->status == 'in_progress')
                                                        <span
                                                            class="badge text-bg-primary">{{ \App\Models\Order::$status[$order->status] }}</span>
                                                    @elseif($order->status == 'completed')
                                                        <span
                                                            class="badge text-bg-success">{{ \App\Models\Order::$status[$order->status] }}</span>
                                                    @elseif($order->status == 'delivered')
                                                        <span
                                                            class="badge text-bg-danger">{{ \App\Models\Order::$status[$order->status] }}</span>
                                                    @else
                                                        <span
                                                            class="badge text-bg-info">{{ \App\Models\Order::$status[$order->status] }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="cart-action">
                                                        @can('show order')
                                                            <a class="avtar avtar-xs btn-link-warning text-warning"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ __('Details') }}"
                                                                href="{{ route('order.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Auth::user()->type == 'customer')
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-secondary">
                                    <i class="ti ti-ruler f-24"></i> {{-- Measurement --}}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Measurement') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalMeasurement'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-warning">
                                    <i class="ti ti-shopping-cart f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Order') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ $result['totalOrder'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary">
                                    <i class="ti ti-cash f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Paid Amount') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ priceFormat($result['totalPaidAmount'] ?? 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-danger">
                                    <i class="ti ti-alert-circle f-24"></i> {{-- Unpaid Amount --}}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Today Unpaid Amount') }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ priceFormat($result['totalUnpaidAmount'] ?? 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($result['notifyOrder'] as $order)
                    @php
                        // Only show orders that are not delivered, on hold, or cancelled
                        $allowedStatuses = ['pending', 'in_progress', 'completed'];
                        if (!in_array($order->status, $allowedStatuses)) {
                            continue; // skip this iteration
                        }

                        // Define status colors
                        $statusColors = [
                            'pending' => 'warning',
                            'in_progress' => 'info',
                            'completed' => 'success',
                        ];
                    @endphp

                    <div class="col-12 mb-3">
                        <div class="alert alert-danger d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between shadow-sm border-0"
                            style="border-left: 5px solid #dc3545; background-color: #fff0f0;">
                            <div
                                class="d-flex flex-column flex-md-row w-100 align-items-md-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                                    <i class="ti ti-alert-triangle text-danger fs-5"></i>
                                    <span class="fw-semibold text-danger mb-0">{{ __('Order Notification') }}</span>
                                </div>

                                <div class="d-flex flex-wrap fz-md gap-3 mb-2 mb-md-0">
                                    <div><strong>Order ID :</strong> {{ orderPrefix() . $order->id }}</div>
                                    <div><strong>{{ __('Order Date') }} :</strong>
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</div>
                                    <div><strong>{{ __('Deadline Date') }} :</strong>
                                        {{ \Carbon\Carbon::parse($order->deadline_date)->format('d M Y') }}</div>
                                    <div>
                                        <strong>{{ __('Status') }} :</strong>
                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('order.show', encrypt($order->id)) }}"
                                        class="btn btn-sm btn-danger">
                                        <i class="ti ti-shopping-cart"></i> View Order
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
