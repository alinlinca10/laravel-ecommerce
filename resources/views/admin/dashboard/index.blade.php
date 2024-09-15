@extends('admin.layouts.app')

@section('scripts')
    <script>
        // Chart revenue
        var options = {
            series: [{
                name: 'series1',
                data: {!! json_encode($monthlyRevenues) !!},
            }],
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false // Ascunde bara de instrumente (opțiunile de grafic)
                },
                offsetY: 30,
            },
            dataLabels: {
                enabled: false // Dezactivează etichetele de date
            },
            legend: {
                show: false // Ascunde legenda
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                colors: [
                    '{{ $current_month_revenue - $last_month_revenue == 0 ? '#fac357' : ($current_month_revenue - $last_month_revenue > 0 ? '#2ac764' : '#f04e4e') }}'
                ], // Culoarea gradientului (verde)
            },
            grid: {
                show: false, // Ascunde dungi orizontale din fundalul graficului
                padding: {
                    left: -10,
                    right: 0,
                },
            },
            tooltip: {
                enabled: false // Dezactivează tooltip-ul (hover)
            },
            fill: {
                colors: [
                    '{{ $current_month_revenue - $last_month_revenue == 0 ? '#fac357' : ($current_month_revenue - $last_month_revenue > 0 ? '#2ac764' : '#f04e4e') }}'
                ], // Culoarea gradientului (verde)
                // colors: ['#2ac764'], // Culoarea gradientului (verde)
            },
            xaxis: {
                labels: {
                    show: false // Ascunde etichetele de pe axa orizontală
                },
                axisTicks: {
                    show: false // Ascunde indicatorii pe axa de jos
                },
            },
            yaxis: {
                labels: {
                    show: false // Ascunde etichetele de pe axa verticală
                },
                axisTicks: {
                    show: false // Ascunde indicatorii pe axa de jos
                },
            }
        };
        var chart = new ApexCharts(document.querySelector("#apex-chart-revenue"), options);
        chart.render();

        // Chart customers
        var options = {
            series: [{
                name: 'series1',
                data: {!! json_encode($monthlyUsers) !!}
            }],
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false // Ascunde bara de instrumente (opțiunile de grafic)
                },
                offsetY: 30,
            },
            dataLabels: {
                enabled: false // Dezactivează etichetele de date
            },
            legend: {
                show: false // Ascunde legenda
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                colors: [
                    '{{ $current_month_users - $last_month_users == 0 ? '#fac357' : ($current_month_users - $last_month_users > 0 ? '#2ac764' : '#f04e4e') }}'
                ], // Culoarea gradientului (verde)
            },
            grid: {
                show: false, // Ascunde dungi orizontale din fundalul graficului
                padding: {
                    left: -10,
                    right: 0,
                },
            },
            tooltip: {
                enabled: false // Dezactivează tooltip-ul (hover)
            },
            fill: {
                colors: [
                    '{{ $current_month_users - $last_month_users == 0 ? '#fac357' : ($current_month_users - $last_month_users > 0 ? '#2ac764' : '#f04e4e') }}'
                ],
            },
            xaxis: {
                labels: {
                    show: false // Ascunde etichetele de pe axa orizontală
                },
                axisTicks: {
                    show: false // Ascunde indicatorii pe axa de jos
                },
            },
            yaxis: {
                labels: {
                    show: false // Ascunde etichetele de pe axa verticală
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#apex-chart-customers"), options);
        chart.render();

        // Chart orders
        var options = {
            series: [{
                name: 'series1',
                data: {!! json_encode($monthlyOrders) !!}
            }],
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false // Ascunde bara de instrumente (opțiunile de grafic)
                },
                offsetY: 30,
            },
            dataLabels: {
                enabled: false // Dezactivează etichetele de date
            },
            legend: {
                show: false // Ascunde legenda
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                colors: [
                    '{{ $current_month_orders - $last_month_orders == 0 ? '#fac357' : ($current_month_orders - $last_month_orders > 0 ? '#2ac764' : '#f04e4e') }}'
                ],
            },
            grid: {
                show: false, // Ascunde dungi orizontale din fundalul graficului
                padding: {
                    left: -10,
                    right: 0,
                },
            },
            tooltip: {
                enabled: false // Dezactivează tooltip-ul (hover)
            },
            fill: {
                colors: [
                    '{{ $current_month_orders - $last_month_orders == 0 ? '#fac357' : ($current_month_orders - $last_month_orders > 0 ? '#2ac764' : '#f04e4e') }}'
                ],
            },
            xaxis: {
                labels: {
                    show: false // Ascunde etichetele de pe axa orizontală
                },
                axisTicks: {
                    show: false // Ascunde indicatorii pe axa de jos
                },
            },
            yaxis: {
                labels: {
                    show: false // Ascunde etichetele de pe axa verticală
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#apex-chart-orders"), options);
        chart.render();
    </script>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3 id="table-group-dividers">
                <strong>Dashboard</strong>
                <a class="anchor-link" href="#table-group-dividers"></a>
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card w-100 p-4">
                <div class="d-flex align-items-center justify-content-center">
                    @php
                        $words = explode(' ', Auth::user()->name);
                        $acronyms = '';

                        foreach ($words as $w) {
                            $acronyms .= mb_substr($w, 0, 1);
                        }
                    @endphp
                    <div style="background-image: url('https://ui-avatars.com/api/?name={!! $acronyms !!}&amp;color=FFFFFF&amp;background=09090b&amp;bold=true&amp;size=128'); height: 2.5rem; width: 2.5rem; background-size: contain;"
                        class="rounded-circle"></div>
                    <div class="d-flex w-100 align-items-center justify-content-between ms-3">
                        <div>
                            <h5 class="card-title mb-0">Welcome</h5>
                            <p class="card-text text-body-tertiary">{!! Auth::user()->name !!}</p>
                        </div>
                        <a href="/logout" class="btn btn-outline-danger d-flex align-items-center text-end px-4"><i
                                class="bi bi-box-arrow-left me-1"></i> Sign out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card w-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="d-flex w-100 justify-content-between ms-3">
                        <div>
                            <h5 class="card-title mb-0">Shop</h5>
                            <p class="card-text">v.1.0.0</p>
                        </div>
                        <a href="/" class="btn btn-outline-secondary d-flex align-items-center px-4">See website</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h6 class="card-subtitle mb-3 fs-7 text-body-tertiary">Revenue</h6>
                    <h2 class="card-title"><strong>{{ number_format($current_month_revenue, 0, ',', '.') }} RON</strong>
                    </h2>
                    @php
                        $difference = $current_month_revenue - $last_month_revenue;
                        $negativeDiff = $difference < 0;
                    @endphp
                    <p class="card-text fs-7 {!! $negativeDiff ? 'text-danger' : ($difference == 0 ? 'text-warning' : 'text-success') !!}">
                        {!! number_format(abs($difference), 0, ',', '.') !!} RON {!! $negativeDiff ? 'decrease' : ($difference == 0 ? 'no difference' : 'increase') !!}
                        @if ($negativeDiff)
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M1.22 5.222a.75.75 0 011.06 0L7 9.942l3.768-3.769a.75.75 0 011.113.058 20.908 20.908 0 013.813 7.254l1.574-2.727a.75.75 0 011.3.75l-2.475 4.286a.75.75 0 01-1.025.275l-4.287-2.475a.75.75 0 01.75-1.3l2.71 1.565a19.422 19.422 0 00-3.013-6.024L7.53 11.533a.75.75 0 01-1.06 0l-5.25-5.25a.75.75 0 010-1.06z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @elseif($difference == 0)
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        {{-- <i class="bi bi-arrow-{!! $negativeDiff ? 'down' : ($difference == 0 ? '' : 'up') !!}-right"></i> --}}
                    </p>
                </div>
                <div class="rounded-3 overflow-hidden" id="apex-chart-revenue"></div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h6 class="card-subtitle mb-3 fs-7 text-body-tertiary">New customers</h6>
                    <h2 class="card-title"><strong>{!! $current_month_users !!}</strong></h2>
                    @if ($last_month_users != 0)
                        @php
                            $difference = (($current_month_users - $last_month_users) / $last_month_users) * 100;
                            $negativeDiff = $difference < 0;
                        @endphp
                    @endif
                    {{-- @dd($last_month_users) --}}
                    <p class="card-text fs-7 {!! $negativeDiff ? 'text-danger' : ($difference == 0 ? 'text-warning' : 'text-success') !!}">
                        {!! number_format(abs($difference), 2) . '%' !!} {!! $negativeDiff ? 'decrease' : ($difference == 0 ? 'no difference' : 'increase') !!}
                        @if ($negativeDiff)
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M1.22 5.222a.75.75 0 011.06 0L7 9.942l3.768-3.769a.75.75 0 011.113.058 20.908 20.908 0 013.813 7.254l1.574-2.727a.75.75 0 011.3.75l-2.475 4.286a.75.75 0 01-1.025.275l-4.287-2.475a.75.75 0 01.75-1.3l2.71 1.565a19.422 19.422 0 00-3.013-6.024L7.53 11.533a.75.75 0 01-1.06 0l-5.25-5.25a.75.75 0 010-1.06z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @elseif($difference == 0)
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        {{-- <i class="bi bi-arrow-{!! $negativeDiff ? 'down' : ($difference == 0 ? '' : 'up') !!}-right"></i> --}}
                    </p>
                    {{-- <p class="card-text fs-7 text-danger">
                        3% decrease <i class="bi bi-arrow-down-right"></i>
                    </p> --}}
                </div>
                <div class="rounded-3 overflow-hidden" id="apex-chart-customers"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h6 class="card-subtitle mb-3 fs-7 text-body-tertiary">New orders</h6>
                    <h2 class="card-title"><strong>{!! $current_month_orders !!}</strong></h2>
                    @if ($last_month_orders == 0)
                        @php
                            $difference = (($current_month_orders - $last_month_orders) / 1) * 100;
                            $negativeDiff = $difference < 0;
                        @endphp
                    @else
                        @php
                            $difference = (($current_month_orders - $last_month_orders) / $last_month_orders) * 100;
                            $negativeDiff = $difference < 0;
                        @endphp
                    @endif
                    <p class="card-text fs-7 {!! $negativeDiff ? 'text-danger' : ($difference == 0 ? 'text-warning' : 'text-success') !!}">
                        {!! number_format(abs($difference), 2) . '%' !!} {!! $negativeDiff ? 'decrease' : ($difference == 0 ? 'no difference' : 'increase') !!}
                        @if ($negativeDiff)
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M1.22 5.222a.75.75 0 011.06 0L7 9.942l3.768-3.769a.75.75 0 011.113.058 20.908 20.908 0 013.813 7.254l1.574-2.727a.75.75 0 011.3.75l-2.475 4.286a.75.75 0 01-1.025.275l-4.287-2.475a.75.75 0 01.75-1.3l2.71 1.565a19.422 19.422 0 00-3.013-6.024L7.53 11.533a.75.75 0 01-1.06 0l-5.25-5.25a.75.75 0 010-1.06z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @elseif($difference == 0)
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="h-20px w-20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        {{-- <i class="bi bi-arrow-{!! $negativeDiff ? 'down' : ($difference == 0 ? '' : 'up') !!}-right"></i> --}}
                    </p>
                </div>
                <div class="rounded-3 overflow-hidden" id="apex-chart-orders"></div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <canvas class="my-4 w-100" id="myChart" width="1552" height="655"
                style="display: block; box-sizing: border-box; height: 655px; width: 1552px;"></canvas>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Orders
                    <p class="fs-9 fw-light text-muted mb-0">The last 5 orders placed by users.</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive treefy">
                        <table class="table table-hover align-middle">
                            <thead class="bg-body-tertiary">
                                <tr>
                                    <th class="text-center">#ID</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Delivery</th>
                                    <th>Payment</th>
                                    <th>Placed on</th>
                                    {{-- <th wire:click="setSortBy('created_at')" class="sortable">Created at<span class="table-sort-{!! $sortBy !== 'created_at' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th> --}}
                                    {{-- <th wire:click="setSortBy('updated_at')" class="sortable">Updated at<span class="table-sort-{!! $sortBy !== 'updated_at' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th> --}}
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $item)
                                    <tr id="{!! $item->id !!}">
                                        <td class="text-center">{!! $item->id !!}</td>
                                        <td>
                                            @if ($item->creator)
                                                {{ $item->creator->name }}
                                                <p class="mb-0 fs-9"><a href="tel:{{ $item->creator->phone }}"
                                                        class="text-decoration-none"><i class="bi bi-telephone-fill"></i>
                                                        {{ $item->creator->phone }}</a>
                                                </p>
                                                <p class="mb-0 fs-9"><a href="mailto:{{ $item->creator->email }}"
                                                        class="text-decoration-none"><i class="bi bi-envelope-fill"></i>
                                                        {{ $item->creator->email }}</a>
                                                </p>
                                            @else
                                                Without account.
                                            @endif
                                        </td>
                                        <td>&euro;{!! $item->total_price !!}</td>
                                        <td><span
                                                class="badge text-bg-{{ $item->statusDeliveryColor() }}">{!! $item->statusDelivery() !!}</span>
                                        </td>
                                        <td><span
                                                class="badge text-bg-{!! $item->status_payment == 'unpaid' ? 'danger' : 'success' !!}">{!! Str::ucfirst($item->status_payment) !!}</span>
                                        </td>
                                        <td>
                                            <small>{!! $item->created_at->format('d.m.Y - H:i:s') !!}</small>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{!! route('orders.edit', $item->id) !!}" class="btn btn-sm btn-success"><i
                                                        class="bi bi-eye"></i> View order</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        @if ($orders->isEmpty())
                            <div class="col-md-auto">
                                <p class="text-center">No records.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
