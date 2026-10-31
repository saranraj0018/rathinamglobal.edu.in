<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAssistantAdmin extends Command
{
    protected $signature = 'assistant:make-admin {email} {--name=Administrator} {--password= : Leave empty to be prompted}';

    protected $description = 'Create (or promote) an administrator who can sign in to /admin';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $user = User::firstWhere('email', $email);

        if ($user === null) {
            $password = $this->option('password') ?: $this->secret('Password (min 12 characters)');

            if (strlen((string) $password) < 12) {
                $this->error('The password must be at least 12 characters.');

                return self::FAILURE;
            }

            $user = new User(['name' => $this->option('name'), 'email' => $email, 'password' => Hash::make($password)]);
        }

        $user->is_admin = true;
        $user->save();
        $this->info("{$email} is now an administrator.");

        return self::SUCCESS;
    }
}
