<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_wallets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agent_id')
                ->index('agent_wallets_agent_id_idx')
                ->constrained('agents')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('currency_id')
                ->index('agent_wallets_currency_id_idx')
                ->constrained('currencies')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->decimal('balance', 20, 8)
                ->default(0);
                
            $table->string('is_default', 3)
                ->index('agent_wallets_is_default_idx')
                ->default('No')
                ->comment('Yes, No');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_wallets');
    }
};
