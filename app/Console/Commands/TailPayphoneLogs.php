<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TailPayphoneLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:payphone {--lines=50 : Number of lines to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tail PayPhone logs for debugging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lines = $this->option('lines');
        $logPath = storage_path('logs/payphone-' . date('Y-m-d') . '.log');
        
        if (!file_exists($logPath)) {
            $this->error("No se encontró el archivo de log: {$logPath}");
            $this->info("Archivos de log disponibles:");
            $logFiles = glob(storage_path('logs/payphone-*.log'));
            foreach ($logFiles as $file) {
                $this->line("  - " . basename($file));
            }
            return;
        }

        $this->info("Mostrando las últimas {$lines} líneas de: {$logPath}");
        $this->line(str_repeat('-', 80));
        
        $command = "tail -n {$lines} " . escapeshellarg($logPath);
        passthru($command);
    }
}