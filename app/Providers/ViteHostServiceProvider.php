<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViteHostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * 
     * Este provider ajusta el archivo hot dinámicamente según el host
     * desde el cual el cliente está accediendo.
     */
    public function boot(): void
    {
        // Solo en modo desarrollo
        if (!app()->isProduction() && file_exists(public_path('hot'))) {
            // Solo actualizar para peticiones web, no consola
            if (app()->runningInConsole() === false) {
                $this->updateHotFile();
            }
        }
    }

    /**
     * Actualiza el archivo hot para usar el host actual del cliente
     */
    protected function updateHotFile(): void
    {
        // Obtener el host desde la solicitud HTTP actual
        $clientHost = request()->getHost();
        
        if ($clientHost) {
            $vitePort = 5174;
            $viteUrl = "http://{$clientHost}:{$vitePort}";
            
            // Actualizar el archivo hot
            $hotPath = public_path('hot');
            $currentContent = trim(@file_get_contents($hotPath));
            
            // Solo actualizar si es diferente
            if ($currentContent !== $viteUrl) {
                file_put_contents($hotPath, $viteUrl);
            }
        }
    }
}
