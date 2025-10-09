<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TailPaypalLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:paypal {--lines=50 : Number of lines to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tail PayPal logs for debugging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lines = $this->option('lines');
        $logPath = storage_path('logs/paypal-' . date('Y-m-d') . '.log');
        
        if (!file_exists($logPath)) {
            $this->error("No se encontró el archivo de log: {$logPath}");
            $this->info("Archivos de log disponibles:");
            $logFiles = glob(storage_path('logs/paypal-*.log'));
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