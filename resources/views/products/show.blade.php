@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Product Detail</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<table class="panel-table">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>${{ number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <th>Current Stock</th>
                <td>{{ $product->current_stock }}</td>
            </tr>
            <tr>
                <th>Minimum Stock</th>
                <td>{{ $product->minimum_stock }}</td>
            </tr>
            <tr>
                <th>Low Stock?</th>
                <td>{{ $product->isLowStock() ? 'Yes' : 'No' }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="{{ route('products.edit', $product->id) }}" class="page-action-link">Edit Product</a>
    <br>
    <a href="{{ route('products.index') }}" class="btn-secondary">Back to Products</a>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Product</button>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
