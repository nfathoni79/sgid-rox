<x-layout>
    <x-slot name="title">
        @if ($method == 'edit')
            Edit Orders - SG.id
        @else
            Add Orders - SG.id
        @endif
    </x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @if ($method == 'edit')
                Edit Orders
            @else
                Add Orders
            @endif
        </h1>
    </div>

    @if($errors->any())
        {{-- Alert Component --}}
        <x-alert type="danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </x-alert>
    @endif

    <form action="{{ $method == 'edit' ? route('new-orders.updatex', ['outlet' => $currentOutlet, 'date' => $date]) : route('new-orders.store') }}" method="post">
        @if ($method == 'edit') @method('PUT') @endif
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-date">Order Date</label>
                    <input type="date" class="form-control" id="input-date" name="date" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="select-outlet">Outlet</label>
                    <select class="form-control" id="select-outlet" name="outlet_id">
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->number }}: {{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <label>Products</label>
        <table id='table-products' class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($method == 'edit')
                    @foreach ($currentProducts as $key => $currentProduct)
                        <tr class="row-product">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <select class="form-control select-product" name="product_ids[]">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $currentProduct->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->number }}: {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" class="form-control" name="quantities[]" min="1" value="{{ $currentProduct->quantity }}" required></td>
                            <td><input type="number" class="form-control" name="prices[]" min="500" value="{{ $currentProduct->price }}" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger btn-product-remove">Remove</button></td>
                        </tr>
                    @endforeach
                @endif
                <tr id="row-product-add">
                    <td colspan="5">
                        <button id="btn-product-add" class="btn btn-primary" type="button">Add Product</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <input type="submit" class="btn btn-success" name="order_submit" value="Submit">
    </form>

    <x-slot name="scripts">
        <script>
            $(() => {
                var method = '{{ $method }}';
                var productIndex = 1;

                // Product select template
                var productSelect = `
                    <select class="form-control select-product" name="product_ids[]">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->number }}: {{ $product->name }}</option>
                    @endforeach
                    </select>`;

                // Quantity input template
                var quantityInput = `<input type="number" class="form-control"
                    name="quantities[]" min="1" required>`;

                // Price input template
                var priceInput = `<input type="number" class="form-control"
                    name="prices[]" min="500" required>`;

                // Tambah baris tabel untuk input produk
                $('#btn-product-add').on('click', () => {
                    $('#table-products #row-product-add').before(
                        `<tr class="row-product">
                        <td>${productIndex}</td>
                        <td>${productSelect}</td>
                        <td>${quantityInput}</td>
                        <td>${priceInput}</td>
                        <td><button type="button" class="btn btn-sm btn-danger btn-product-remove">Remove</button></td>
                        </tr>`
                    );

                    productIndex++;
                });

                // Hapus salah satu baris produk
                $('#table-products').on('click', '.btn-product-remove', (e) => {
                    $(e.target).closest('tr').remove();

                    $('.row-product').each(function (index) {
                        $(this).children().first().text(index + 1);
                    })

                    productIndex--;
                });

                // Jika method edit, set pilihan outlet dan tanggal, sesuaikan productIndex
                if (method == 'edit') {
                    $('#select-outlet').val({{ $currentOutlet->id ?? 1 }});
                    $('#select-outlet').prop('disabled', 'true');
                    $('#input-date').val('{{ $date ?? '' }}');
                    $('#input-date').prop('disabled', 'true');
                    productIndex = {{ isset($currentProducts) ? count($currentProducts) + 1 : 1}};
                }
            });
        </script>
    </x-slot>
</x-layout>
