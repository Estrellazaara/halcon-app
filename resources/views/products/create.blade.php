@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Create Product</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <label>Name *</label>
    <input type="text" name="name" />
    <br><br>

    <label>Description</label>
    <input type="text" name="description" />
    <br><br>

    <label>Price *</label>
    <input type="number" name="price" step="0.01" min="0" />
    <br><br>

    <label>Current Stock *</label>
    <input type="number" name="current_stock" />
    <br><br>

    <label>Minimum Stock *</label>
    <input type="number" name="minimum_stock" />
    <br><br>

    <button type="submit" class="btn-primary">Create Product</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
