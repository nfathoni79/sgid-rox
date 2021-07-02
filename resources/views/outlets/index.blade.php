<x-layout>
    <x-slot name="title">
        Outlets - SG.id
    </x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Outlets</h1>
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
                            <th>Owner</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Owner</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($outlets as $outlet)
                            <tr>
                                <td>{{ $outlet->number }}</td>
                                <td>{{ $outlet->name }}</td>
                                <td>{{ $outlet->owner }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-toggle="modal" data-target="#modal-edit" data-id="{{ $outlet->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#modal-delete" data-id="{{ $outlet->id }}">Delete</button>
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
        <form action="{{ route('outlets.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="fileOutlets">Excel file</label>
                    <input type="file" class="form-control-file" id="fileOutlets" name="file_outlets">
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
        <form action="{{ route('outlets.wipe') }}" method="post">
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
    <x-modal id="modal-add" label="modal-add-label" header="Add Outlet">
        <form id="form-add" action="{{ route('outlets.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add-outlet-number">Number</label>
                    <input type="number" class="form-control" id="add-outlet-id" name="number" min="1" required>
                </div>

                <div class="form-group">
                    <label for="add-outlet-name">Name</label>
                    <input type="text" class="form-control" id="add-outlet-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="add-outlet-owner">Owner</label>
                    <input type="text" class="form-control" id="add-outlet-owner" name="owner" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Edit -->
    <x-modal id="modal-edit" label="modal-edit-label" header="Edit Outlet">
        <form id="form-edit" action="{{ route('outlets.update', ['outlet' => ':outlet']) }}" method="post">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-outlet-number">Number</label>
                    <input type="number" class="form-control" id="edit-outlet-number" name="number" min="1" required>
                </div>

                <div class="form-group">
                    <label for="edit-outlet-name">Name</label>
                    <input type="text" class="form-control" id="edit-outlet-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="edit-outlet-owner">Owner</label>
                    <input type="text" class="form-control" id="edit-outlet-owner" name="owner" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info">Edit</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Delete -->
    <x-modal id="modal-delete" label="modal-delete-label" header="Delete Outlet">
        <form id="form-delete" action="{{ route('outlets.destroy', ['outlet' => ':outlet']) }}" method="post">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <p>Are you sure you want to delete this outlet?</p>
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

                $('table').on('click', '.btn-edit', (e) => {
                    var id = $(e.target).data('id');
                    $('#form-edit').attr('action', editAction.replace(':outlet', id));

                    $.ajax({
                        url: '/api/outlets/' + id,
                        success: (result) => {
                            $('#edit-outlet-number').val(result.number);
                            $('#edit-outlet-name').val(result.name);
                            $('#edit-outlet-owner').val(result.owner);
                        },
                    })
                });

                $('table').on('click', '.btn-delete', (e) => {
                    var id = $(e.target).data('id');
                    $('#form-delete').attr('action', deleteAction.replace(':outlet', id));
                });
            });
        </script>
    </x-slot>
</x-layout>
