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
                            <th>No</th>
                            <th>Name</th>
                            <th>Owner</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Owner</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($outlets as $outlet)
                            <tr>
                                <td>{{ $outlet->number }}</td>
                                <td>{{ $outlet->name }}</td>
                                <td>{{ $outlet->owner }}</td>
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

    <!-- Modal Delete -->
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
</x-layout>
