@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:0 auto; padding:0 24px;">

    <!-- HEADER -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#f0f4ff; letter-spacing:-0.02em; margin:0 0 6px;">
                <i class="fa-solid fa-camera" style="color:#8b5cf6; margin-right:10px;"></i>
                Subir Evidencias
            </h1>
            <p style="font-size:15px; color:#93c5fd; margin:0;">
                Pedido: <strong style="color:#f0f4ff;">{{ $order->invoice_number }}</strong>
                &nbsp;—&nbsp;
                <span class="badge badge-delivered">
                    <i class="fa-solid fa-circle-check"></i> Entregado
                </span>
            </p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="hc-alert-success" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="hc-alert-error" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Instrucciones -->
    <div class="hc-card" style="padding:20px; margin-bottom:24px; display:flex; align-items:center; gap:16px;">
        <div style="font-size:32px; color:#8b5cf6; flex-shrink:0;">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div>
            <p style="font-size:15px; font-weight:600; color:#f0f4ff; margin:0 0 4px;">Instrucciones</p>
            <p style="font-size:13px; color:#93c5fd; margin:0; line-height:1.6;">
                Sube las dos fotos de evidencia de la entrega. Formatos aceptados: <strong>JPG, PNG</strong>. Tamaño máximo: <strong>5 MB</strong> por foto.<br>
                Ambas fotos son requeridas antes de poder enviar.
            </p>
        </div>
    </div>

    <!-- FORMULARIO CON DRAG & DROP -->
    <form id="upload-form" action="{{ route('orders.upload-photos', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">

            <!-- ZONA 1: Foto de unidad cargada -->
            <div class="hc-card" style="padding:24px;">
                <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#93c5fd; margin:0 0 16px;">
                    <i class="fa-solid fa-truck" style="margin-right:6px; color:#3b82f6;"></i>Unidad cargada
                </p>

                <div id="zone-loaded"
                     onclick="document.getElementById('photo_loaded').click()"
                     ondragover="handleDragOver(event,'zone-loaded')"
                     ondragleave="handleDragLeave(event,'zone-loaded')"
                     ondrop="handleDrop(event,'zone-loaded','photo_loaded','preview-loaded','icon-loaded')"
                     style="border:2px dashed #1e3a8a; border-radius:16px; background:#0d1b4b; padding:32px 16px; text-align:center; cursor:pointer; transition:all 0.3s; min-height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center;">

                    <div id="icon-loaded" style="font-size:48px; color:#1e3a8a; margin-bottom:12px; transition:all 0.3s;">
                        <i class="fa-solid fa-truck"></i>
                    </div>
                    <p style="font-size:13px; color:#3d5a99; margin:0 0 4px;">Haz clic o arrastra tu foto aquí</p>
                    <p style="font-size:11px; color:#1e3a8a; margin:0;">JPG, PNG — máx. 5 MB</p>

                    <!-- Preview -->
                    <img id="preview-loaded" src="" alt="" style="display:none; max-width:100%; max-height:160px; border-radius:10px; margin-top:12px; object-fit:cover;">
                    <p id="filename-loaded" style="display:none; font-size:12px; color:#10b981; margin-top:8px; font-weight:600;"></p>
                </div>

                <input type="file" id="photo_loaded" name="photo_loaded" accept="image/jpeg,image/png" style="display:none;"
                       onchange="handleFileSelect(this,'preview-loaded','icon-loaded','filename-loaded','zone-loaded')">

                @error('photo_loaded')
                    <p style="color:#ef4444; font-size:12px; margin:8px 0 0;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- ZONA 2: Foto de material descargado -->
            <div class="hc-card" style="padding:24px;">
                <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#93c5fd; margin:0 0 16px;">
                    <i class="fa-solid fa-box-open" style="margin-right:6px; color:#10b981;"></i>Material descargado
                </p>

                <div id="zone-delivered"
                     onclick="document.getElementById('photo_delivered').click()"
                     ondragover="handleDragOver(event,'zone-delivered')"
                     ondragleave="handleDragLeave(event,'zone-delivered')"
                     ondrop="handleDrop(event,'zone-delivered','photo_delivered','preview-delivered','icon-delivered')"
                     style="border:2px dashed #1e3a8a; border-radius:16px; background:#0d1b4b; padding:32px 16px; text-align:center; cursor:pointer; transition:all 0.3s; min-height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center;">

                    <div id="icon-delivered" style="font-size:48px; color:#1e3a8a; margin-bottom:12px; transition:all 0.3s;">
                        <i class="fa-solid fa-boxes-packing"></i>
                    </div>
                    <p style="font-size:13px; color:#3d5a99; margin:0 0 4px;">Haz clic o arrastra tu foto aquí</p>
                    <p style="font-size:11px; color:#1e3a8a; margin:0;">JPG, PNG — máx. 5 MB</p>

                    <img id="preview-delivered" src="" alt="" style="display:none; max-width:100%; max-height:160px; border-radius:10px; margin-top:12px; object-fit:cover;">
                    <p id="filename-delivered" style="display:none; font-size:12px; color:#10b981; margin-top:8px; font-weight:600;"></p>
                </div>

                <input type="file" id="photo_delivered" name="photo_delivered" accept="image/jpeg,image/png" style="display:none;"
                       onchange="handleFileSelect(this,'preview-delivered','icon-delivered','filename-delivered','zone-delivered')">

                @error('photo_delivered')
                    <p style="color:#ef4444; font-size:12px; margin:8px 0 0;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                @enderror
            </div>

        </div><!-- /grid -->

        <!-- Barra de progreso (visible solo al enviar) -->
        <div id="progress-wrap" style="display:none; margin-bottom:20px;">
            <p style="font-size:13px; color:#93c5fd; margin:0 0 8px;">
                <i class="fa-solid fa-spinner fa-spin" style="margin-right:6px;"></i>
                Subiendo evidencias...
            </p>
            <div style="background:#0d1b4b; border-radius:999px; height:8px; overflow:hidden; border:1px solid #1e3a8a;">
                <div id="progress-bar"
                     style="height:100%; border-radius:999px; background:linear-gradient(90deg,#1e40af,#3b82f6); width:0%; transition:width 0.4s ease; box-shadow:0 0 10px rgba(59,130,246,0.6);">
                </div>
            </div>
        </div>

        <!-- Botón de envío -->
        <div style="display:flex; gap:14px; justify-content:flex-end; flex-wrap:wrap;">
            <a href="{{ route('orders.show', $order->id) }}" class="btn-secondary">
                <i class="fa-solid fa-xmark"></i> Cancelar
            </a>
            <button type="submit" id="submit-btn" class="btn-primary" disabled
                    style="opacity:0.4; cursor:not-allowed; transition:all 0.3s;">
                <i class="fa-solid fa-cloud-arrow-up"></i> Subir evidencias
            </button>
        </div>

    </form>

    <!-- Fotos ya subidas (si existen) -->
    @if($order->photo_loaded || $order->photo_delivered)
        <div class="hc-card" style="padding:24px; margin-top:28px;">
            <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#93c5fd; margin:0 0 16px;">
                <i class="fa-solid fa-images" style="margin-right:6px;"></i>Evidencias ya subidas
            </p>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                @if($order->photo_loaded)
                    <div style="border:1px solid rgba(59,130,246,0.3); border-radius:12px; overflow:hidden;">
                        <div style="padding:10px 14px; font-size:12px; font-weight:700; color:#93c5fd; background:rgba(59,130,246,0.1); display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-truck"></i> Unidad cargada
                        </div>
                        <img src="{{ asset('storage/' . $order->photo_loaded) }}" style="width:100%; display:block;">
                    </div>
                @endif
                @if($order->photo_delivered)
                    <div style="border:1px solid rgba(16,185,129,0.3); border-radius:12px; overflow:hidden;">
                        <div style="padding:10px 14px; font-size:12px; font-weight:700; color:#10b981; background:rgba(16,185,129,0.1); display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-box-open"></i> Material descargado
                        </div>
                        <img src="{{ asset('storage/' . $order->photo_delivered) }}" style="width:100%; display:block;">
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>

<script>
let loadedSelected    = false;
let deliveredSelected = false;

function checkBothSelected() {
    const btn = document.getElementById('submit-btn');
    if (loadedSelected && deliveredSelected) {
        btn.disabled = false;
        btn.style.opacity   = '1';
        btn.style.cursor    = 'pointer';
    } else {
        btn.disabled = true;
        btn.style.opacity   = '0.4';
        btn.style.cursor    = 'not-allowed';
    }
}

function handleFileSelect(input, previewId, iconId, filenameId, zoneId) {
    const file = input.files[0];
    if (!file) return;

    const preview  = document.getElementById(previewId);
    const icon     = document.getElementById(iconId);
    const filename = document.getElementById(filenameId);
    const zone     = document.getElementById(zoneId);

    // Mostrar preview
    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
        icon.style.display    = 'none';
        filename.textContent  = '✓ ' + file.name;
        filename.style.display = 'block';
        zone.style.borderColor = '#3b82f6';
        zone.style.boxShadow   = '0 0 0 3px rgba(59,130,246,0.2)';
        zone.style.borderStyle = 'solid';
    };
    reader.readAsDataURL(file);

    // Marcar qué zona está lista
    if (input.id === 'photo_loaded')     { loadedSelected    = true; }
    if (input.id === 'photo_delivered')  { deliveredSelected = true; }
    checkBothSelected();
}

function handleDragOver(e, zoneId) {
    e.preventDefault();
    const zone = document.getElementById(zoneId);
    zone.style.borderColor = '#3b82f6';
    zone.style.background  = 'rgba(59,130,246,0.06)';
    zone.style.boxShadow   = '0 0 0 3px rgba(59,130,246,0.2)';
}
function handleDragLeave(e, zoneId) {
    const zone = document.getElementById(zoneId);
    zone.style.borderColor = '#1e3a8a';
    zone.style.background  = '#0d1b4b';
    zone.style.boxShadow   = '';
}
function handleDrop(e, zoneId, inputId, previewId, iconId) {
    e.preventDefault();
    handleDragLeave(e, zoneId);
    const file  = e.dataTransfer.files[0];
    if (!file) return;
    const input = document.getElementById(inputId);
    // Asignar el archivo al input
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    handleFileSelect(input, previewId, iconId, inputId + '-fn', zoneId);
}

// Barra de progreso simulada al enviar
document.getElementById('upload-form').addEventListener('submit', function() {
    document.getElementById('progress-wrap').style.display = 'block';
    const bar = document.getElementById('progress-bar');
    let w = 0;
    const interval = setInterval(() => {
        w = Math.min(w + Math.random() * 15, 90);
        bar.style.width = w + '%';
        if (w >= 90) clearInterval(interval);
    }, 200);
});
</script>

@endsection
