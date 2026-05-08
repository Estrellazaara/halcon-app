@extends('layouts.app')

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ──────────────────────────────────────────────────────────── -->
    <div style="margin-bottom:32px;">
        <h1 style="font-size:28px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 6px;">
            <i class="fa-solid fa-gauge-high" style="color:var(--hc-green); margin-right:10px;"></i>
            Panel de Control
        </h1>
        <p style="font-size:14px; color:#64748b; margin:0;">
            Bienvenido, <strong>{{ Auth::user()->name }}</strong> —
            <span class="hc-role-badge" style="background:rgba(22,101,52,0.1); color:var(--hc-green); border-color:rgba(22,101,52,0.3);">
                {{ Auth::user()->role->name }}
            </span>
        </p>
    </div>

    <!-- ── TARJETAS DE MÓDULOS ─────────────────────────────────────────────── -->
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">

        @if(Auth::user()->role->name === 'Admin')
        <div class="hc-card">
            <div class="hc-card-header" style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-users" style="font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700;">Gestión de Usuarios</div>
                    <div style="font-size:12px; opacity:0.8;">Módulo Admin</div>
                </div>
            </div>
            <div class="hc-card-body">
                <ul style="list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px;">
                    <li>
                        <a href="{{ route('users.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px; transition:color 0.2s;">
                            <i class="fa-solid fa-list" style="width:16px;"></i> Ver Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.create') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px; transition:color 0.2s;">
                            <i class="fa-solid fa-user-plus" style="width:16px;"></i> Crear Usuario
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('roles.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px; transition:color 0.2s;">
                            <i class="fa-solid fa-shield-halved" style="width:16px;"></i> Ver Roles
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif

        @if(in_array(Auth::user()->role->name, ['Admin', 'Sales']))
        <div class="hc-card">
            <div class="hc-card-header" style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-bag-shopping" style="font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700;">Ventas</div>
                    <div style="font-size:12px; opacity:0.8;">Gestión de pedidos</div>
                </div>
            </div>
            <div class="hc-card-body">
                <ul style="list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px;">
                    <li>
                        <a href="{{ route('orders.create') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-plus" style="width:16px;"></i> Crear Pedido
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-box" style="width:16px;"></i> Ver Pedidos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-tags" style="width:16px;"></i> Ver Productos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif

        @if(in_array(Auth::user()->role->name, ['Admin', 'Purchasing']))
        <div class="hc-card">
            <div class="hc-card-header" style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-cart-flatbed" style="font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700;">Compras</div>
                    <div style="font-size:12px; opacity:0.8;">Seguimiento de materiales</div>
                </div>
            </div>
            <div class="hc-card-body">
                <ul style="list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px;">
                    <li>
                        <a href="{{ route('orders.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-box" style="width:16px;"></i> Ver Pedidos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-tags" style="width:16px;"></i> Ver Productos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif

        @if(in_array(Auth::user()->role->name, ['Admin', 'Warehouse']))
        <div class="hc-card">
            <div class="hc-card-header" style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-warehouse" style="font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700;">Almacén</div>
                    <div style="font-size:12px; opacity:0.8;">Gestión de inventario</div>
                </div>
            </div>
            <div class="hc-card-body">
                <ul style="list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px;">
                    <li>
                        <a href="{{ route('orders.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-box" style="width:16px;"></i> Ver Pedidos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-tags" style="width:16px;"></i> Ver Productos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('order-items.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-list-check" style="width:16px;"></i> Items de Pedido
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif

        @if(in_array(Auth::user()->role->name, ['Admin', 'Route']))
        <div class="hc-card">
            <div class="hc-card-header" style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-truck" style="font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700;">Ruta</div>
                    <div style="font-size:12px; opacity:0.8;">Entregas y evidencias</div>
                </div>
            </div>
            <div class="hc-card-body">
                <ul style="list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px;">
                    <li>
                        <a href="{{ route('orders.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-box" style="width:16px;"></i> Ver Pedidos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('order-photos.index') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-green); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-camera" style="width:16px;"></i> Fotos de Entrega
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif

        @if(Auth::user()->role->name === 'Admin')
        <div class="hc-card">
            <div class="hc-card-header" style="background:var(--hc-orange); display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-box-archive" style="font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700;">Archivados</div>
                    <div style="font-size:12px; opacity:0.8;">Pedidos eliminados</div>
                </div>
            </div>
            <div class="hc-card-body">
                <ul style="list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px;">
                    <li>
                        <a href="{{ route('orders.archived') }}" style="display:flex; align-items:center; gap:10px; color:var(--hc-orange); font-weight:600; font-size:14px;">
                            <i class="fa-solid fa-rotate-left" style="width:16px;"></i> Pedidos Archivados
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
