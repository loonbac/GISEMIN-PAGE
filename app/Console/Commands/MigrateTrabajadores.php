<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateTrabajadores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-trabajadores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar usuarios unicos desde la tabla certificados a trabajadores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando migración de trabajadores...');

        $certificados = \App\Models\Certificado::select('dni', 'nombre')
                                              ->distinct()
                                              ->get();

        $count = 0;
        foreach ($certificados as $cert) {
            $exists = \App\Models\Trabajador::where('dni', $cert->dni)->exists();
            
            if (!$exists) {
                \App\Models\Trabajador::create([
                    'dni' => $cert->dni,
                    'nombre' => $cert->nombre,
                ]);
                $count++;
            }
        }

        $this->info("Se migraron {$count} trabajadores exitosamente.");
    }
}
