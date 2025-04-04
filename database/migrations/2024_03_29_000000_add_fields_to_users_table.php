<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
            $table->foreignId('subscription_id')->nullable()->after('role');
            $table->timestamp('subscription_expires_at')->nullable()->after('subscription_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropForeign(['subscription_id']);
            $table->dropColumn('subscription_id');
            $table->dropColumn('subscription_expires_at');
        });
    }
};
