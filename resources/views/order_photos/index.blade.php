@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">All Order Photos</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<br>

    <a href="{{ route('order-photos.create') }}" class="btn-primary">Create Order Photo</a>

    <br><br>

    <table class="panel-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order</th>
                <th>Type</th>
                <th>Uploaded By</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($photos as $photo)
                <tr>
                    <td>{{ $photo->id }}</td>
                    <td>{{ $photo->order->invoice_number ?? '' }}</td>
                    <td>{{ $photo->type }}</td>
                    <td>{{ $photo->user->name ?? '' }}</td>
                    <td>
                        <a href="{{ route('order-photos.show', $photo->id) }}" class="page-action-link">View details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
