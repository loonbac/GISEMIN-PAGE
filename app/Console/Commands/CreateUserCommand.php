<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un nuevo usuario administrador para el sistema';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('');
        $this->info('╔═══════════════════════════════════════╗');
        $this->info('║   GISEMIN - Crear Usuario Admin       ║');
        $this->info('╚═══════════════════════════════════════╝');
        $this->info('');

        // Solicitar nombre
        $name = $this->ask('Ingrese el nombre del usuario');
        if (empty($name)) {
            $this->error('El nombre es requerido.');
            return Command::FAILURE;
        }

        // Solicitar email
        $email = $this->ask('Ingrese el correo electrónico');
        
        // Validar email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return Command::FAILURE;
        }

        // Solicitar contraseña (oculta)
        $password = $this->secret('Ingrese la contraseña (mínimo 8 caracteres)');
        
        if (strlen($password) < 8) {
            $this->error('La contraseña debe tener al menos 8 caracteres.');
            return Command::FAILURE;
        }

        // Confirmar contraseña
        $passwordConfirm = $this->secret('Confirme la contraseña');

        if ($password !== $passwordConfirm) {
            $this->error('Las contraseñas no coinciden.');
            return Command::FAILURE;
        }

        // Confirmar creación
        $this->info('');
        $this->info('Datos del nuevo usuario:');
        $this->table(
            ['Campo', 'Valor'],
            [
                ['Nombre', $name],
                ['Email', $email],
                ['Contraseña', str_repeat('•', strlen($password))],
            ]
        );

        if (!$this->confirm('¿Desea crear este usuario?', true)) {
            $this->warn('Operación cancelada.');
            return Command::SUCCESS;
        }

        // Crear usuario
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info('');
            $this->info('✅ Usuario creado exitosamente!');
            $this->info("   ID: {$user->id}");
            $this->info("   Email: {$user->email}");
            $this->info('');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error al crear el usuario: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
