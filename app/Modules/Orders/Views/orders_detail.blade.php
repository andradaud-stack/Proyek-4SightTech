@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title mb-4">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('orders.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card kt-detail-card">
            <div class="card-header">
                Detail Data {{ $title }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row kt-detail-grid">
                            <div class='col-lg-2'><p>User Id</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $orders->user_id ?? $orders->pengguna_id ?? '-' }} @if($orders->pengguna)<span class="text-muted fw-normal">({{ $orders->pengguna->name }})</span>@endif</p></div>
									<div class='col-lg-2'><p>Table Id</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $orders->table_id }}</p></div>
									<div class='col-lg-2'><p>Status</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $orders->status }}</p></div>
									<div class='col-lg-2'><p>Metode Pembayaran</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $orders->metode_pembayaran }}</p></div>
									<div class='col-lg-2'><p>Status Pembayaran</p></div>
									<div class='col-lg-10'>
										<p class='fw-bold'>
											@if($orders->isPaid())
												<span class="badge bg-success">Sudah Dibayar</span>
											@elseif(in_array(strtolower($orders->status_pembayaran ?? ''), ['dibatalkan', 'batal']))
												<span class="badge bg-danger">Dibatalkan</span>
											@else
												<span class="badge bg-warning text-dark">Belum Bayar</span>
											@endif
										</p>
									</div>
									<div class='col-lg-2'><p>Total</p></div><div class='col-lg-10'><p class='fw-bold'>Rp {{ number_format($orders->total, 0, ',', '.') }}</p></div>
									
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card kt-detail-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order Items</span>
                <span class="badge bg-primary">{{ $orders->orderItems ? $orders->orderItems->count() : 0 }} Items</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle kt-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Menu</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders->orderItems ?? [] as $item)
                                <tr>
                                    <td>{{ $item->order_id }}</td>
                                    <td>{{ $item->menu->name ?? $item->menu_name }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal ?? ($item->price * $item->qty), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3"><i>Tidak ada item pada pesanan ini.</i></td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($orders->orderItems && $orders->orderItems->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end fw-bold">Total</th>
                                    <th class="text-end fw-bold">Rp {{ number_format($orders->total ?? $orders->orderItems->sum('subtotal'), 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection
