@extends('layouts.app')

@section('page-css')
<style>
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .status-menunggu_konfirmasi {
        background-color: #fef3c7;
        color: #92400e;
    }
    .status-diproses {
        background-color: #dbeafe;
        color: #0c4a6e;
    }
    .status-siap_disajikan {
        background-color: #c7d2fe;
        color: #312e81;
    }
    .status-selesai {
        background-color: #dcfce7;
        color: #166534;
    }
    .status-dibatalkan {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .order-card {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: white;
    }
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .order-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }
    .order-info-item {
        display: flex;
        flex-direction: column;
    }
    .order-info-label {
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    .order-info-value {
        color: #1f2937;
    }
    .order-items {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .order-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .status-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .status-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .status-btn-primary {
        background-color: #3b82f6;
        color: white;
    }
    .status-btn-primary:hover {
        background-color: #2563eb;
    }
    .status-btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }
    .status-btn-secondary:hover {
        background-color: #d1d5db;
    }
</style>
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title mb-4">
        <div class="row align-items-end mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="kt-eyebrow mb-1">Pesanan Customer</p>
                <h3 class="mb-0">Manajemen Status Pesanan</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order Management</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        @include('include.flash')
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Pesanan</h5>
            </div>
            <div class="card-body">
                @forelse($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <h5 class="mb-1">Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h5>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>

                        <div class="order-info">
                            <div class="order-info-item">
                                <span class="order-info-label">Pelanggan</span>
                                <span class="order-info-value">{{ $order->pengguna->name ?? '-' }}</span>
                            </div>
                            <div class="order-info-item">
                                <span class="order-info-label">Meja</span>
                                <span class="order-info-value">Meja {{ $order->tabel->table_number ?? '-' }}</span>
                            </div>
                            <div class="order-info-item">
                                <span class="order-info-label">Metode Pembayaran</span>
                                <span class="order-info-value">{{ ucfirst($order->metode_pembayaran ?? '-') }}</span>
                            </div>
                            <div class="order-info-item">
                                <span class="order-info-label">Status Pembayaran</span>
                                <span class="order-info-value">
                                    @if(in_array(strtolower($order->status_pembayaran ?? ''), ['sudah_bayar', 'lunas', 'paid']))
                                        <span class="badge bg-success">Sudah Dibayar</span>
                                    @elseif(in_array(strtolower($order->status_pembayaran ?? ''), ['dibatalkan', 'batal']))
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                    @endif
                                </span>
                            </div>
                            <div class="order-info-item">
                                <span class="order-info-label">Total</span>
                                <span class="order-info-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="order-items">
                            <strong>Menu yang dipesan:</strong>
                            @forelse($order->orderItems as $item)
                                <div class="order-item">
                                    <span>{{ $item->menu_name }} x{{ $item->qty }}</span>
                                    <span>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                                </div>
                            @empty
                                <p class="mb-0">Tidak ada item</p>
                            @endforelse
                        </div>

                        <div class="order-actions">
                            @if($order->status === 'menunggu_konfirmasi')
                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="diproses">
                                    <button type="submit" class="status-btn status-btn-primary" onclick="return confirm('Terima pesanan ini?')">
                                        ✓ Terima Pesanan
                                    </button>
                                </form>
                            @elseif($order->status === 'diproses')
                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="siap_disajikan">
                                    <button type="submit" class="status-btn status-btn-primary">
                                        ✓ Siap Disajikan
                                    </button>
                                </form>
                            @elseif($order->status === 'siap_disajikan')
                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="status-btn status-btn-primary">
                                        ✓ Selesai
                                    </button>
                                </form>
                            @endif

                            @if(!in_array(strtolower($order->status_pembayaran ?? ''), ['sudah_bayar', 'lunas', 'paid']) && $order->status !== 'dibatalkan')
                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_pembayaran" value="sudah_bayar">
                                    <button type="submit" class="status-btn" style="background-color: #10b981; color: white;" onclick="return confirm('Konfirmasi bahwa pembayaran untuk pesanan #{{ $order->id }} sudah diterima?')">
                                        ✓ Konfirmasi Bayar
                                    </button>
                                </form>
                            @endif

                            @if($order->status !== 'selesai' && $order->status !== 'dibatalkan')
                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="dibatalkan">
                                    <button type="submit" class="status-btn status-btn-secondary" onclick="return confirm('Batalkan pesanan ini?')">
                                        ✗ Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info" role="alert">
                        <strong>Tidak ada pesanan!</strong> Semua pesanan sudah diproses.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection
