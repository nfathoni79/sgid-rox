<x-layout>
    <x-slot name="title">
        Products - SG.id
    </x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
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
            <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal-add">Add</button>
            <button class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#modalImport">Import</button>
            <button class="btn btn-danger float-right mr-2" data-toggle="modal" data-target="#modalWipe">Wipe</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->number }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-toggle="modal" data-target="#modal-edit" data-id="{{ $product->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $product->id }}">Delete</button>
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
        <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="fileOutlets">Excel file</label>
                    <input type="file" class="form-control-file" id="fileProducts" name="file_products">
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
        <form action="{{ route('products.wipe') }}" method="post">
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
    <x-modal id="modal-add" label="modal-add-label" header="Add Product">
        <form id="form-add" action="{{ route('products.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add-product-number">Number</label>
                    <input type="number" class="form-control" id="add-product-number" name="number" min="1" required>
                </div>

                <div class="form-group">
                    <label for="add-product-name">Name</label>
                    <input type="text" class="form-control" id="add-product-name" name="name" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Edit -->
    <x-modal id="modal-edit" label="modal-edit-label" header="Edit Product">
        <form id="form-edit" action="{{ route('products.update', ['product' => ':product']) }}" method="post">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-product-number">Number</label>
                    <input type="number" class="form-control" id="edit-product-number" name="number" min="1" required>
                </div>

                <div class="form-group">
                    <label for="edit-product-name">Name</label>
                    <input type="text" class="form-control" id="edit-product-name" name="name" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info">Edit</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Delete -->
    <x-modal id="modal-delete" label="modal-delete-label" header="Delete Product">
        <form id="form-delete" action="{{ route('products.destroy', ['product' => ':product']) }}" method="post">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
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
                var editAction = $('#form-edit').attr('action');
                var deleteAction = $('#form-delete').attr('action');

                $('table').on('click', '.btn-edit',(e) => {
                    var id = $(e.target).data('id');
                    $('#form-edit').attr('action', editAction.replace(':product', id));

                    $.ajax({
                        url: '/api/products/' + id,
                        success: (result) => {
                            $('#edit-product-number').val(result.number);
                            $('#edit-product-name').val(result.name);
                        },
                    })
                });

                $('table').on('click', '.btn-delete',(e) => {
                    var id = $(e.target).data('id');
                    $('#form-delete').attr('action', deleteAction.replace(':product', id));
                });
            });
        </script>
    </x-slot>
</x-layout>
