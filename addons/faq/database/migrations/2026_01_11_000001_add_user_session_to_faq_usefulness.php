<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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

            $table->unique(['faq_id', 'user_id'], 'faq_usefulness_user_unique');
            $table->unique(['faq_id', 'session_hash'], 'faq_usefulness_session_unique');
        });
    }

    public function down(): void
    {
        Schema::table('faq_usefulness', function (Blueprint $table) {
            $table->dropUnique('faq_usefulness_user_unique');
            $table->dropUnique('faq_usefulness_session_unique');
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'session_hash']);
        });
    }
};
