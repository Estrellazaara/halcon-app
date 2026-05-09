@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Order Photo Detail</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<table class="panel-table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $photo->id }}</td>
            </tr>
            <tr>
                <th>Order</th>
                <td>{{ $photo->order->invoice_number ?? '' }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ $photo->type }}</td>
            </tr>
            <tr>
                <th>Uploaded By</th>
                <td>{{ $photo->user->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Photo</th>
                <td>
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" width="300">
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="{{ route('order-photos.edit', $photo->id) }}">Edit Order Photo</a>
    <br>
    <a href="{{ route('order-photos.index') }}" class="btn-secondary">Back to Order Photos</a>

    <form action="{{ route('order-photos.destroy', $photo->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Order Photo</button>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
