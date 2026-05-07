@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">All Orders</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<br>

    <a href="{{ route('orders.create') }}" class="btn-primary">Create Order</a>

    <br><br>

    <table class="panel-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Customer Number</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_number }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_datetime }}</td>
                    <td>

                        {{-- Ver → TODOS --}}
                        <a href="{{ route('orders.show', $order->id) }}" class="page-action-link">View details</a>

                        {{-- Editar → SOLO Admin --}}
                        @if(auth()->check() && auth()->user()->hasRole('Admin'))
                            | <a href="{{ route('orders.edit', $order->id) }}" class="page-action-link">Edit</a>
                        @endif

                        {{-- Eliminar → SOLO Admin --}}
                        @if(auth()->check() && auth()->user()->hasRole('Admin'))
                            | <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif

                        {{-- Subir foto → SOLO Route --}}
                        @if(auth()->check() && auth()->user()->hasRole('Route'))
                            | <a href="{{ route('order-photos.create') }}" class="page-action-link">Upload Photo</a>
                        @endif

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
