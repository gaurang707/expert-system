<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('display_name')->nullable();
            $table->string('timezone')->nullable();
            $table->string('language')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('email_notification')->nullable();
            $table->boolean('task_reminder')->nullable();
            $table->boolean('product_announcement')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('display_name');
            $table->dropColumn('timezone');
            $table->dropColumn('language');
            $table->dropColumn('bio');
            $table->dropColumn('email_notification');
            $table->dropColumn('task_reminder');
            $table->dropColumn('product_announcement');
        });
    }
};
