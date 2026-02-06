<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Check database connection
        $dbStatus = [
            'connected' => false,
            'message' => '',
            'details' => []
        ];

        try {
            \DB::connection()->getPdo();
            $dbStatus['connected'] = true;
            $dbStatus['message'] = 'Conexión exitosa a la base de datos';
            
            // Get database info
            $dbStatus['details'] = [
                'driver' => config('database.default'),
                'host' => config('database.connections.mysql.host'),
                'port' => config('database.connections.mysql.port'),
                'database' => config('database.connections.mysql.database'),
                'username' => config('database.connections.mysql.username'),
                'server_version' => \DB::select('SELECT VERSION() as version')[0]->version ?? 'N/A',
                'tables_count' => count(\DB::select('SHOW TABLES')),
            ];
        } catch (\Exception $e) {
            $dbStatus['connected'] = false;
            $dbStatus['message'] = 'Error de conexión: ' . $e->getMessage();
        }

        // Redirigir al listado de certificados tras login
        return redirect()->route('admin.certificados.lista');
    }
}
