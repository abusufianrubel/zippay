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
        Schema::table('deposits', function (Blueprint $table) {
            
            $table->foreignId('agent_id')
                ->nullable()->after('user_id')
                ->constrained('agents')
                ->onDelete('SET NULL');
        });

        Schema::table('transactions', function (Blueprint $table) {
            
            $table->foreignId('agent_id')
                ->nullable()->after('user_id')
                ->constrained('agents')
                ->onDelete('SET NULL');

            $table->decimal('agent_percentage', 8, 2)
            ->nullable()
            ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('agent_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('agent_id');
            $table->dropColumn('agent_percentage');
        });
    }
};
