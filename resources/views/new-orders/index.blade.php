<x-layout>
    <x-slot name="title">
        Orders - SG.id
    </x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orders</h1>
    </div>

    @if(session('success'))
        {{-- Alert Component --}}
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-4">
                    <div class="form-group my-0">
                        <select class="form-control" id="select-outlet">
                            <option value="0">All Outlets</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->number }}">{{ $outlet->number }}: {{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-8">
                    <a href="{{ route('new-orders.create') }}" class="btn btn-success float-right">Add</a>
                    <button class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#modal-import">Import</button>
                    <button class="btn btn-danger float-right mr-2" data-toggle="modal" data-target="#modal-wipe">Wipe</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Order Date</th>
                            <th class="d-none">Outlet No.</th>
                            <th>Outlet Name</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Order Date</th>
                            <th class="d-none">Outlet No.</th>
                            <th>Outlet Name</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</td>
                                <td>{{ $order->date }}</td>
                                <td class="d-none">{{ $order->outlet_number}}</td>
                                <td>{{ $order->outlet_name }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('new-orders.editx', ['outlet' => $order->outlet_id, 'date' => $order->date]) }}" class="btn btn-sm btn-info btn-edit">Edit</a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete" data-outlet="{{ $order->outlet_id }}" data-date="{{ $order->date }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <x-modal id="modal-import" label="modal-import-label" header="Import File">
        <form action="{{ route('new-orders.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="file-new-orders">Excel file</label>
                    <input type="file" class="form-control-file" id="file-new-orders" name="file_new_orders">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Wipe -->
    <x-modal id="modal-wipe" label="modal-wipe-label" header="Wipe All Data">
        <form action="{{ route('new-orders.wipe') }}" method="post">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <p>Are you sure you want to wipe all data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Wipe</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Delete -->
    <x-modal id="modal-delete" label="modal-delete-label" header="Delete Order">
        <form id="form-delete" action="{{ route('new-orders.destroyx', ['outlet' => ':outlet', 'date' => ':date']) }}" method="post">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <p>Are you sure you want to delete this order?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </x-modal>

    <x-slot name="scripts">
        <script>
            $(() => {
                var table = $('#dataTable').DataTable();
                var deleteAction = $('#form-delete').attr('action');

                // Filter tabel berdasarkan outlet
                $('#select-outlet').on('change', (e) => {
                    var number = $(e.target).val();

                    if (number == 0) {
                        table.column(2).search('').draw();
                    } else {
                        table.column(2).search(`^${number}$`, true).draw();
                    }
                });

                // Ubah placeholder pada form action delete
                $('table').on('click', '.btn-delete',(e) => {
                    var outletId = $(e.target).data('outlet');
                    var date = $(e.target).data('date');
                    $('#form-delete').attr('action', deleteAction.replace(':outlet', outletId).replace(':date', date));
                });
            });
        </script>
    </x-slot>
</x-layout>
