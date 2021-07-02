<x-layout>
    <x-slot name="title">
        Product Orders - SG.id
    </x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product Orders</h1>
    </div>

    @if(session('success'))
        {{-- Alert Component --}}
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if ($errors->any())
        <x-alert type="danger">
            <p>Errors:</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
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
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Outlet No.</th>
                            <th>Outlet</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($productOrders as $productOrder)
                            <tr>
                                <td>{{ $productOrder->outlet->number }}</td>
                                <td>{{ $productOrder->outlet->name }}</td>
                                <td>{{ $productOrder->product->name }}</td>
                                <td>{{ $productOrder->quantity }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-toggle="modal" data-target="#modal-edit" data-id="{{ $productOrder->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $productOrder->id }}">Delete</button>
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
        <form action="{{ route('product-orders.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="fileOutlets">Excel file</label>
                    <input type="file" class="form-control-file" id="fileProductOrders" name="file_product_orders" required>
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
        <form action="{{ route('product-orders.wipe') }}" method="post">
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
    <x-modal id="modal-add" label="modal-add-label" header="Add Product Order">
        <form id="form-add" action="{{ route('product-orders.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add-productorder-outlet">Outlet</label>
                    <select class="form-control" id="add-productorder-outlet" name="outlet_id">
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->number }}: {{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-productorder-product">Product</label>
                    <select class="form-control" id="add-productorder-product" name="product_id">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->number }}: {{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-productorder-quantity">Quantity</label>
                    <input type="number" class="form-control" id="add-productorder-quantity" name="quantity" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Edit -->
    <x-modal id="modal-edit" label="modal-edit-label" header="Edit Product Order">
        <form id="form-edit" action="{{ route('product-orders.update', ['product_order' => ':productorder']) }}" method="post">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-productorder-quantity">Quantity</label>
                    <input type="number" class="form-control" id="edit-productorder-quantity" name="quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit-productorder-change">Quantity Change</label>
                    <input type="number" class="form-control" id="edit-productorder-change" name="change">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info">Edit</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Delete -->
    <x-modal id="modal-delete" label="modal-delete-label" header="Delete Product Order">
        <form id="form-delete" action="{{ route('product-orders.destroy', ['product_order' => ':productorder']) }}" method="post">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <p>Are you sure you want to delete this product order?</p>
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

                $('table').on('click', '.btn-edit', (e) => {
                    var id = $(e.target).data('id');
                    $('#form-edit').attr('action', editAction.replace(':productorder', id));

                    $.ajax({
                        url: '/api/product-orders/' + id,
                        success: (result) => {
                            $('#edit-productorder-quantity').val(result.quantity);
                            $('#edit-productorder-change').val('');
                        },
                    });
                });

                $('table').on('click', '.btn-delete', (e) => {
                    var id = $(e.target).data('id');
                    $('#form-delete').attr('action', deleteAction.replace(':productorder', id));
                });

                $('#select-outlet').on('change', (e) => {
                    var number = $(e.target).val();

                    if (number == 0) {
                        table.column(0).search('').draw();
                    } else {
                        table.column(0).search(`^${number}$`, true).draw();
                    }
                });
            });
        </script>
    </x-slot>
</x-layout>
