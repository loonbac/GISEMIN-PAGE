@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-wrapper">
    <h1>Bienvenido al Dashboard</h1>
    <p>Estado de la base de datos:</p>
    <ul>
        <li>Conexión: {{ $dbStatus['connected'] ? 'Exitosa' : 'Fallida' }}</li>
        <li>Mensaje: {{ $dbStatus['message'] }}</li>
        @if(isset($dbStatus['details']))
            <li>Driver: {{ $dbStatus['details']['driver'] ?? '' }}</li>
            <li>Host: {{ $dbStatus['details']['host'] ?? '' }}</li>
            <li>Base de datos: {{ $dbStatus['details']['database'] ?? '' }}</li>
            <li>Usuario: {{ $dbStatus['details']['username'] ?? '' }}</li>
            <li>Versión: {{ $dbStatus['details']['server_version'] ?? '' }}</li>
            <li>Tablas: {{ $dbStatus['details']['tables_count'] ?? '' }}</li>
        @endif
    </ul>
</div>
@endsection
