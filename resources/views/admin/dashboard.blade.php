@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<h3 class="mb-4">Dashboard Admin</h3>
<div class="row g-3 mb-4">
  <div class="col-md-4"><div class="card text-center"><div class="card-body">
    <div class="fs-2">{{ $jmlPreorder }}</div>Total Pre-order
  </div></div></div>
  <div class="col-md-4"><div class="card text-center"><div class="card-body">
    <div class="fs-2">{{ $jmlProduk }}</div>Jenis Produk
  </div></div></div>
  <div class="col-md-4"><div class="card text-center"><div class="card-body">
    <div class="fs-2">{{ $jmlLangganan }}</div>Langganan Aktif
  </div></div></div>
</div>
<a href="{{ route('admin.produk.index') }}" class="btn btn-success me-2">Kelola Produk</a>
<a href="{{ route('admin.jadwal.index') }}" class="btn btn-success me-2">Jadwal Panen</a>
<a href="{{ route('admin.preorder.index') }}" class="btn btn-success">Pre-order</a>
<a href="{{ route('admin.langganan.index') }}" class="btn btn-success me-2">Data Langganan</a>
@endsection