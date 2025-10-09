<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TailPaymentLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:payments {--lines=50 : Number of lines to show} {--provider= : Filter by provider (paypal or payphone)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tail payment logs (PayPal and PayPhone) for debugging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lines = $this->option('lines');
        $provider = $this->option('provider');
        $today = date('Y-m-d');
        
        if ($provider) {
            $this->showProviderLogs($provider, $lines, $today);
        } else {
            $this->showAllPaymentLogs($lines, $today);
        }
    }

    private function showProviderLogs($provider, $lines, $today)
    {
        $logPath = storage_path("logs/{$provider}-{$today}.log");
        
        if (!file_exists($logPath)) {
            $this->error("No se encontró el archivo de log: {$logPath}");
            $this->showAvailableLogs($provider);
            return;
        }

        $this->info("=== LOGS DE " . strtoupper($provider) . " ===");
        $this->info("Mostrando las últimas {$lines} líneas de: {$logPath}");
        $this->line(str_repeat('-', 80));
        
        $command = "tail -n {$lines} " . escapeshellarg($logPath);
        passthru($command);
    }

    private function showAllPaymentLogs($lines, $today)
    {
        $paypalPath = storage_path("logs/paypal-{$today}.log");
        $payphonePath = storage_path("logs/payphone-{$today}.log");
        
        $this->info("=== LOGS DE PAGOS DEL DÍA: {$today} ===");
        $this->line(str_repeat('=', 80));
        
        // PayPal Logs
        if (file_exists($paypalPath)) {
            $this->info("🔵 PAYPAL LOGS (últimas {$lines} líneas):");
            $this->line(str_repeat('-', 80));
            $command = "tail -n {$lines} " . escapeshellarg($paypalPath);
            passthru($command);
            $this->line("");
        } else {
            $this->warn("❌ No se encontraron logs de PayPal para hoy");
        }

        // PayPhone Logs
        if (file_exists($payphonePath)) {
            $this->info("🟢 PAYPHONE LOGS (últimas {$lines} líneas):");
            $this->line(str_repeat('-', 80));
            $command = "tail -n {$lines} " . escapeshellarg($payphonePath);
            passthru($command);
        } else {
            $this->warn("❌ No se encontraron logs de PayPhone para hoy");
        }

        if (!file_exists($paypalPath) && !file_exists($payphonePath)) {
            $this->error("No se encontraron logs de pagos para hoy");
            $this->showAvailableLogs();
        }
    }

    private function showAvailableLogs($provider = null)
    {
        $this->info("Archivos de log disponibles:");
        
        if ($provider) {
            $logFiles = glob(storage_path("logs/{$provider}-*.log"));
        } else {
            $logFiles = array_merge(
                glob(storage_path('logs/paypal-*.log')),
                glob(storage_path('logs/payphone-*.log'))
            );
            sort($logFiles);
        }

        foreach ($logFiles as $file) {
            $this->line("  - " . basename($file));
        }
        
        if (empty($logFiles)) {
            $this->warn("No hay archivos de log disponibles");
        }
    }
}