<?php

namespace App\Addons\Faq\Console\Commands;

use App\Addons\Faq\Models\Faq;
use App\Models\Metadata;
use Illuminate\Console\Command;

class CleanupOrphanedSectionMetadataCommand extends Command
{
    protected $signature = 'faq:cleanup-sections
                            {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Remove orphaned FAQ section metadata for sections that are no longer registered';

    public function handle(): int
    {
        $registeredSections = array_keys(Faq::getAvailableSections());
        $dryRun = $this->option('dry-run');

        if (empty($registeredSections)) {
            $this->warn('No sections are currently registered. All display_* metadata will be considered orphaned.');
        } else {
            $this->info('Currently registered sections: ' . implode(', ', $registeredSections));
        }

        $validKeys = array_map(fn ($section) => 'display_' . $section, $registeredSections);

        $orphanedQuery = Metadata::query()
            ->where('model_type', (new Faq())->getMorphClass())
            ->where('key', 'like', 'display_%');

        if (!empty($validKeys)) {
            $orphanedQuery->whereNotIn('key', $validKeys);
        }

        $orphanedCount = $orphanedQuery->count();

        if ($orphanedCount === 0) {
            $this->info('No orphaned section metadata found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$orphanedCount} orphaned metadata entries.");

        if ($dryRun) {
            $this->warn('Dry run mode - no changes will be made.');

            $orphanedQuery->get()->groupBy('key')->each(function ($items, $key) {
                $this->line("  - {$key}: {$items->count()} entries");
            });

            return Command::SUCCESS;
        }

        if (!$this->confirm("Delete {$orphanedCount} orphaned metadata entries?")) {
            $this->info('Operation cancelled.');
            return Command::SUCCESS;
        }

        $deleted = $orphanedQuery->delete();

        $this->info("Deleted {$deleted} orphaned metadata entries.");

        return Command::SUCCESS;
    }
}
