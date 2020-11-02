<?php

namespace App\Console\Commands;

use App\Facades\UUID;
use App\Profile;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an application user. Seeding the database is for testing environments, so use this command in production for your first admin user.';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        do
        {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                system('cls');
            } else {
                system('clear');
            }

            $this->info('Welcome to the user account creation wizard. If you just installed the application, we recommend you create your first admin user here. If you don\'t, you won\'t gain admin privileges after creating an account in the web interface.');
            $this->info('We\'ll ask some questions to get you started.');

            $username = $this->ask('Username');
            do
            {
                $password = $this->secret('Password');
                $password_confirm = $this->secret('Confirm Password');

                if ($password === $password_confirm)
                {
                    $password = Hash::make($password);
                    $matches = true;
                }
                else
                {
                    $this->error('Password doesn\'t match. Please try again.');
                    $matches = false;
                }
            }
            while(!$matches);

            $email = $this->ask('E-mail address');
            $name = $this->ask('First/Last Name');

            do
            {
                try
                {
                    $uuid = UUID::toUUID($this->ask('Minecraft username (Must be a valid Premium account)'));
                }
                catch (\InvalidArgumentException $e)
                {
                    $this->error($e->getMessage());
                    $hasError = true;
                }

                if (isset($hasError))
                {
                    $continue = true;
                }
                else
                {
                    $continue = false;
                }
                unset($hasError);
            }
            while($continue);


            $this->info('Please check if these details are correct: ');
            $this->info('Username: ' . $username);
            $this->info('Email: ' . $email);
            $this->info('Name: ' . $name);

        }
        while(!$this->confirm('Create user now? You can go back to correct any details.'));


        $user = User::create([
            'uuid' => $uuid,
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'originalIP' => '127.0.0.1',
            'password' => $password
        ]);

        if ($user)
        {
            $user->assignRole('admin', 'reviewer', 'user', 'hiringManager');
            Profile::create([
                'profileShortBio' => 'Random data '.rand(0, 1000),
                'profileAboutMe' => 'Random data '.rand(0, 1000),
                'socialLinks' => '[]',
                'avatarPreference' => 'gravatar',
                'userID' => $user->id,
            ]);

            $this->info('Account created! You may now login at ' . route('login') . '. Enjoy the app!');

            return 0;
        }
        else
        {
            $this->error('There was an unknown problem creating the user. There might have been errors above. Please try again.');
            return 1;
        }
    }
}
