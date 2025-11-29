<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('faqs', 'product_id')) {
                $table->foreignId('product_id')
                    ->nullable()
                    ->after('group_id')
                    ->constrained('products')
                    ->nullOnDelete();
            }
        });

        $this->setGroupIdNullable();

        Schema::create('faq_usefulness', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')
                ->constrained('faqs')
                ->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->boolean('is_useful');
            $table->timestamps();

            $table->unique(['faq_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_usefulness');

        Schema::table('faqs', function (Blueprint $table) {
            if (Schema::hasColumn('faqs', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });

        $this->setGroupIdNotNullable();
    }
    private function driver(): string
    {
        return Schema::getConnection()->getDriverName();
    }

    private function setGroupIdNullable(): void
    {
        if (!Schema::hasColumn('faqs', 'group_id')) {
            return;
        }

        $driver = $this->driver();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE faqs MODIFY group_id BIGINT UNSIGNED NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE faqs ALTER COLUMN group_id DROP NOT NULL');
        }
    }

    private function setGroupIdNotNullable(): void
    {
        if (!Schema::hasColumn('faqs', 'group_id')) {
            return;
        }

        $driver = $this->driver();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE faqs MODIFY group_id BIGINT UNSIGNED NOT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE faqs ALTER COLUMN group_id SET NOT NULL');
        }
    }
};
