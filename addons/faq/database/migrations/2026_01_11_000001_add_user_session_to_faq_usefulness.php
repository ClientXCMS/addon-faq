<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new columns and foreign key
        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->after('faq_id');

            $table->string('session_hash', 64)
                ->nullable()
                ->after('ip_address');

            $table->foreign('user_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete();

            // Create simple index on faq_id before dropping the old unique constraint
            // MySQL needs an index on faq_id for the foreign key
            $table->index('faq_id', 'faq_usefulness_faq_id_index');
        });

        // Drop old unique constraint (faq_id + ip_address) - no longer needed
        // We now track by user_id or session_hash instead of IP
        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->dropUnique('faq_usefulness_faq_id_ip_address_unique');
        });

        // Add new unique constraints
        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->unique(['faq_id', 'user_id'], 'faq_usefulness_user_unique');
            $table->unique(['faq_id', 'session_hash'], 'faq_usefulness_session_unique');
        });
    }

    public function down(): void
    {
        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->dropUnique('faq_usefulness_user_unique');
            $table->dropUnique('faq_usefulness_session_unique');
        });

        // Restore old unique constraint
        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->unique(['faq_id', 'ip_address'], 'faq_usefulness_faq_id_ip_address_unique');
        });

        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->dropIndex('faq_usefulness_faq_id_index');
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'session_hash']);
        });
    }
};
