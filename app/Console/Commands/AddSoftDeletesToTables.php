<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class AddSoftDeletesToTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:softdeletes';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add deleted_at column to tables that use SoftDeletes';
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
        $tables = DB::select("SELECT table_name FROM information_schema.columns WHERE table_schema = 'public' AND column_name = 'created_at'");

        foreach ($tables as $table) {
            $tableName = $table->table_name;
            $this->info("Adding deleted_at column to table: $tableName");

            DB::statement("ALTER TABLE $tableName ADD COLUMN IF NOT EXISTS deleted_at  TIMESTAMP NULL DEFAULT NULL");
        }

        $this->info('SoftDeletes added to tables successfully!');
    }
}
