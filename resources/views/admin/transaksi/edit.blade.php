@extends('app')
@section('title','Tambah Transaksi Baru')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mb-4">
                        <h3 class="card-title text-bold">Tambah Transaksi Baru</h3>
                    </div>
                </div>
                <form action="{{ route('transaksi.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Nomor Pesanan</label>
                                <input type="text" name="order_code" id="order_code" class="form-control" readonly
                                    value="{{ $transNumber ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="id_customer">Pelanggan</label>
                                <select name="id_customer" id="id_customer" class="form-control">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="service_name">Jenis Layanan</label>
                                <select name="service_name" id="service_name" class="form-control">
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                    @foreach ($services as $service)
                                        {{-- pastikan kamu kirimkan harga di dataset --}}
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                            {{ $service->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="order_date">Tanggal Pesanan</label>
                                <input type="date" name="order_date" id="order_date" class="form-control"
                                       value="{{ old('order_date', isset($order) ? $order->order_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                            </div>
                            <div class="mb-3">
                                <label for="order_end_date">Tanggal Selesai</label>
                                <input type="date" name="order_end_date" id="order_end_date" class="form-control"
                                       value="{{ old('order_end_date', isset($order) ? $order->order_end_date->format('Y-m-d') : now()->addDays(2)->format('Y-m-d')) }}">
                            </div>
                            <div class="mb-3">
                                <label for="notes">Note</label>
                                <textarea name="notes" id="notes" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col mb-3" align='right'>
                            <button type="button" id='addRow' class="btn btn-sm btn-primary">
                                <i class="fas fa-plus mr-1"></i> Tambah
                            </button>
                        </div>

                        <table class="table table-valign-middle text-center" id="detailTable">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Jenis Pesanan</td>
                                    <td>Qty (kg)</td>
                                    <td>Harga</td>
                                    <td>Subtotal</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <p><strong>Total : <span class="totalText">Rp. 0</span></strong></p>
                    <input type="hidden" name="total" id="totalValue">

                    <div class="row">
                        <div class="col mb-3" align="right">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fas fa-envelope-open-text mr-2"></i> Simpan
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light text-muted">
                                <i class="fas fa-reply mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const addRow = document.querySelector('#addRow');
    const tbody = document.querySelector('#detailTable tbody');
    const selectService = document.querySelector('#service_name');
    const selectNote = document.querySelector('#notes');

    addRow.addEventListener('click', () => {
        const optionService = selectService.options[selectService.selectedIndex];
        if (!selectService.value) {
            alert('Silahkan pilih layanan terlebih dahulu');
            return;
        }

        const priceService = parseInt(optionService.dataset.price);
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td></td>
            <td>
                <input type="hidden" name="id_service[]" value="${optionService.value}">
            </td>
            <td>
                <input type="number" class="form-control qtys" step="any" min="1" name="qty[]" value="1" required>
                <div class="invalid-feedback">Invalid quantity!</div>
                <input type="hidden" name="notes[]" value="${selectNote.value}">
            </td>
            <td>
                <input type="hidden" class="prices" value="${priceService}">
                Rp. ${priceService.toLocaleString('id-ID')}
            </td>
            <td>
                <input type="hidden" class="subtotals" name="subtotal[]" value="${priceService}">
                <span class="textSubtotal">Rp. ${priceService.toLocaleString('id-ID')}</span>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delRow">Hapus</button>
            </td>
        `;

        tbody.appendChild(tr);
        selectService.value = '';
        selectNote.value = '';
        updateNo();
        updateTotal();
    });

    tbody.addEventListener('click', (e) => {
        if (e.target.classList.contains('delRow')) {
            e.target.closest('tr').remove();
            updateNo();
            updateTotal();
        }
    });

    tbody.addEventListener('input', (e) => {
        if (e.target.classList.contains('qtys')) {
            const tr = e.target.closest('tr');
            const qty = parseFloat(e.target.value) || 0;
            const price = parseInt(tr.querySelector('.prices').value);
            const subTotal = qty * price;
            tr.querySelector('.subtotals').value = subTotal;
            tr.querySelector('.textSubtotal').textContent = `Rp. ${subTotal.toLocaleString('id-ID')}`;
            updateTotal();
        }
    });

    function updateNo() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }

    function updateTotal() {
        const subtotals = document.querySelectorAll('.subtotals');
        let sum = 0;
        subtotals.forEach(subTotal => {
            sum += parseInt(subTotal.value) || 0;
        });
        document.querySelector('.totalText').textContent = `Rp. ${sum.toLocaleString('id-ID')}`;
        document.querySelector('#totalValue').value = sum;
    }
</script>
@endsection
