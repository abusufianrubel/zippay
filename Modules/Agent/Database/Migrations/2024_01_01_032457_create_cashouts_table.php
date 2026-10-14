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
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('agent_id')
                ->constrained('agents')
                ->onDelete('cascade');

            $table->foreignId('agent_package_id')
                ->nullable()
                ->constrained('agent_packages')
                ->nullOnDelete();

            $table->foreignId('currency_id')
                ->constrained('currencies')
                ->onDelete('cascade');

            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->onDelete('cascade');

            $table->string('uuid')
                ->unique();

            $table->string('payment_method_info');
            $table->decimal('agent_percentage', 8, 2);
            $table->decimal('charge_percentage', 8, 2);
            $table->decimal('charge_fixed', 8, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashouts');
    }
};
