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
        <x-alert type="success" :message="session('success')"/>
        {{-- End of Alert Component --}}
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalImport">Import</button>
            <button type="button" class="btn btn-danger float-right mr-3" data-toggle="modal" data-target="#modalWipe">Wipe</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Outlet</th>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Outlet</th>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($productOrders as $productOrder)
                            <tr>
                                <td>{{ $productOrder->outlet->name }}</td>
                                <td>{{ $productOrder->product->name }}</td>
                                <td>{{ $productOrder->quantity }}</td>
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
                    <input type="file" class="form-control-file" id="fileProductOrders" name="file_product_orders">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Delete -->
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
</x-layout>
