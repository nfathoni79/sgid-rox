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

    <!-- DataTales Example -->
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
                    <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal-add">Add</button>
                    <button class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#modalImport">Import</button>
                    <button class="btn btn-danger float-right mr-2" data-toggle="modal" data-target="#modalWipe">Wipe</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Outlet No.</th>
                            <th>Outlet</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Outlet No.</th>
                            <th>Outlet</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->outlet->number }}</td>
                                <td>{{ $order->outlet->name }}</td>
                                <td>{{ $order->date }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-toggle="modal" data-target="#modal-edit" data-id="{{ $order->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $order->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <x-modal id="modalImport" label="modalImportLabel" header="Import File">
        <form action="{{ route('orders.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="fileOrders">Excel file</label>
                    <input type="file" class="form-control-file" id="fileOrders" name="file_orders">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Wipe -->
    <x-modal id="modalWipe" label="modalWipeLabel" header="Wipe All Data">
        <form action="{{ route('orders.wipe') }}" method="post">
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

    <!-- Modal Add -->
    <x-modal id="modal-add" label="modal-add-label" header="Add Order">
        <form id="form-add" action="{{ route('orders.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add-order-outlet">Outlet</label>
                    <select class="form-control" id="add-order-outlet" name="outlet_id">
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->number }}: {{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="add-order-date">Date</label>
                    <input type="date" class="form-control" id="add-order-date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="add-order-total">Total</label>
                    <input type="number" class="form-control" id="add-order-total" name="total" min="1000" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Edit -->
    <x-modal id="modal-edit" label="modal-edit-label" header="Edit Order">
        <form id="form-edit" action="{{ route('orders.update', ['order' => ':order']) }}" method="post">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-order-date">Date</label>
                    <input type="date" class="form-control" id="edit-order-date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="edit-order-total">Total</label>
                    <input type="number" class="form-control" id="edit-order-total" name="total" min="1000" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info">Edit</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Delete -->
    <x-modal id="modal-delete" label="modal-delete-label" header="Delete Order">
        <form id="form-delete" action="{{ route('orders.destroy', ['order' => ':order']) }}" method="post">
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
                var editAction = $('#form-edit').attr('action');
                var deleteAction = $('#form-delete').attr('action');

                $('#select-outlet').on('change', (e) => {
                    var number = $(e.target).val();

                    if (number == 0) {
                        table.column(0).search('').draw();
                    } else {
                        table.column(0).search(`^${number}$`, true).draw();
                    }
                });

                $('table').on('click', '.btn-edit', (e) => {
                    var id = $(e.target).data('id');
                    $('#form-edit').attr('action', editAction.replace(':order', id));

                    $.ajax({
                        url: `/api/orders/${id}`,
                        success: (result) => {
                            $('#edit-order-date').val(result.date);
                            $('#edit-order-total').val(result.total);
                        },
                    })
                });

                $('table').on('click', '.btn-delete',(e) => {
                    var id = $(e.target).data('id');
                    $('#form-delete').attr('action', deleteAction.replace(':order', id));
                });
            });
        </script>
    </x-slot>
</x-layout>
