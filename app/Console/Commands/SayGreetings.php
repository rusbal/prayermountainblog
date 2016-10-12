<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SayGreetings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ray:greetings {name=Peter} {--greeting=Hi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Says a greetings';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->option('greeting') . ' ' . $this->argument('name'));
    }
}
