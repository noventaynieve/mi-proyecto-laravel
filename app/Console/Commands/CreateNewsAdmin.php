<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

#[Signature('news:create-admin')]
#[Description('Create an administrator account for managing municipal news')]
class CreateNewsAdmin extends Command
{
    public function handle(): int
    {
        $name = trim((string) $this->ask('Nombre del administrador'));
        $email = strtolower(trim((string) $this->ask('Correo electrónico')));
        $password = (string) $this->secret('Contraseña (mínimo 12 caracteres)');
        $passwordConfirmation = (string) $this->secret('Confirma la contraseña');

        if (! hash_equals($password, $passwordConfirmation)) {
            $this->components->error('Las contraseñas no coinciden.');

            return self::FAILURE;
        }

        $validator = Validator::make(
            compact('name', 'email', 'password'),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
                'password' => ['required', Password::min(12)],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        $user->role = 'admin';
        $user->save();

        $this->components->info('La cuenta administradora se creó correctamente.');

        return self::SUCCESS;
    }
}
