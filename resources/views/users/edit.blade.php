@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Edit User</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" />
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" />
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" />
        <br><br>

        <label>Role:</label>
        <select name="role_id">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Active:</label>
        <select name="is_active">
            <option value="1" @selected($user->is_active == 1)>Yes</option>
            <option value="0" @selected($user->is_active == 0)>No</option>
        </select>
        <br><br>

        <input type="submit" value="Edit User" />

    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
