@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-wrapper">
    <h1>Bienvenido al Dashboard</h1>
    <p>Estado de la base de datos:</p>
    <ul>
        <li>Conexión: {{ $dbStatus['connected'] ? 'Exitosa' : 'Fallida' }}</li>
        <li>Mensaje: {{ $dbStatus['message'] }}</li>
    </ul>
</div>
@endsection
