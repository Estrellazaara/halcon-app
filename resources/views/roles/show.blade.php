@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Role Detail</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<table class="panel-table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $role->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $role->name }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <h2>Users with this role</h2>
    <ul>
        @foreach($role->users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>

    <br>
    <a href="{{ route('roles.edit', $role->id) }}">Edit Role</a>
    <br>
    <a href="{{ route('roles.index') }}" class="btn-secondary">Back to Roles</a>

    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Role</button>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
