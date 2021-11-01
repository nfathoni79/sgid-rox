<x-layout>
    <x-slot name="title">
        Dashboard - SG.id
    </x-slot>

    <x-slot name="styles">
        <style media="screen">
            .chart-pie.chart-pie-product {
                height: 30rem !important;
            }
        </style>
    </x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        {{-- Best Outlet --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <x-dash-card title="Best Outlet" icon="fas fa-store" color="primary">
                {{ $bestOutlet->number ?? '-' }}: {{ $bestOutlet->name ?? '-' }}
            </x-dash-card>
        </div>

        {{-- Best Product --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <x-dash-card title="Best Product" icon="fas fa-fish" color="success">
                {{ $bestProduct->name ?? '-' }}
            </x-dash-card>
        </div>

        {{-- Total Orders --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <x-dash-card title="Total Orders" icon="fas fa-redo" color="info">
                Rp {{ number_format($totalOrders, 0, ',', '.') }}
            </x-dash-card>
        </div>

        {{-- Total Product Orders --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <x-dash-card title="Total Product Orders" icon="fas fa-fish" color="danger">
                {{ $totalProducts }}
            </x-dash-card>
        </div>
    </div>

    {{-- RO Summary Chart --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Repeat Orders Summary</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartRoSummary"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RO Outlet Chart --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-md-8">
                        <h6 class="m-0 font-weight-bold text-primary">Repeat Orders per Outlet</h6>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <select class="form-control" id="selectOutlet">
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->number }}: {{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartRoOutlet"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RO Product Chart --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div
                    class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Product Orders Summary</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie chart-pie-product pt-4 pb-2">
                        <canvas id="chartProductSummary"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary">Product Orders per Outlet</h6>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <select class="form-control" id="selectOutletProduct">
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->number }}: {{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie chart-pie-product pt-4 pb-2">
                        <canvas id="chartProductOutlet"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function updateRoSummaryChart(chart) {
                $.ajax({
                    url: '{{ route("chart.summary") }}',
                    success: (result) => {
                        updateChart(chart, result.labels, result.data);
                    }
                });
            }

            function updateRoOutletChart(chart, outletId) {
                var route = "{{ route('chart.outlet', ['id' => ':outletId']) }}";
                route = route.replace(':outletId', outletId);

                $.ajax({
                    url: route,
                    success: (result) => {
                        updateChart(chart, result.labels, result.data);
                    }
                })
            }

            function updateProductSummaryChart(chart) {
                $.ajax({
                    url: '{{ route("chart.product-summary") }}',
                    success: (result) => {
                        updateChart(chart, result.labels, result.data);
                    }
                });
            }

            function updateProductOutletChart(chart, outletId) {
                var route = "{{ route('chart.product-outlet', ['id' => ':outletId']) }}";
                route = route.replace(':outletId', outletId);

                $.ajax({
                    url: route,
                    success: (result) => {
                        updateChart(chart, result.labels, result.data);
                    }
                })
            }
        </script>
    </x-slot>
</x-layout>
