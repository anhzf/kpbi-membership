<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\Invoice;
use App\Models\Membership;
use Illuminate\Console\Command;

class MigrateExistingDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:migrate-existing {--dry-run : Show what would be migrated without actually doing it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing memberships and invoices to create corresponding documents';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }

        $this->info('🚀 Starting document migration...');

        // Migrate memberships without documents
        $this->migrateMemberships($dryRun);

        // Migrate invoices without documents
        $this->migrateInvoices($dryRun);

        $this->info('✅ Document migration completed!');

        return Command::SUCCESS;
    }

    private function migrateMemberships(bool $dryRun = false)
    {
        $memberships = Membership::whereNull('document_id')
            ->with(['educationProgram.college', 'requests'])
            ->get();

        $count = $memberships->count();
        $this->info("📋 Found {$count} memberships without documents");

        if ($count === 0) {
            return;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($memberships as $membership) {
            try {
                if (!$dryRun) {
                    // Create document using the syncDocument method
                    $membership->syncDocument();
                    $this->line(" ✓ Membership #{$membership->id} -> Document #{$membership->document_id}");
                } else {
                    $this->line(" ✓ Would create document for Membership #{$membership->id}");
                }
                $bar->advance();
            } catch (\Exception $e) {
                $this->newLine();
                $this->error(" ✗ Failed to migrate Membership #{$membership->id}: " . $e->getMessage());
                $this->error("   Education Program: " . ($membership->educationProgram->name ?? 'N/A'));
                $this->error("   Degree: " . ($membership->educationProgram->degree?->value ?? 'N/A'));
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
    }

    private function migrateInvoices(bool $dryRun = false)
    {
        $invoices = Invoice::whereNull('document_id')->get();

        $count = $invoices->count();
        $this->info("💰 Found {$count} invoices without documents");

        if ($count === 0) {
            return;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($invoices as $invoice) {
            try {
                if (!$dryRun) {
                    // Create document using the syncDocument method
                    $invoice->syncDocument();
                    $this->line(" ✓ Invoice #{$invoice->id} -> Document #{$invoice->document_id}");
                } else {
                    $this->line(" ✓ Would create document for Invoice #{$invoice->id}");
                }
                $bar->advance();
            } catch (\Exception $e) {
                $this->error(" ✗ Failed to migrate Invoice #{$invoice->id}: " . $e->getMessage());
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
    }
}
