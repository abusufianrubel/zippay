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
        Schema::create('agent_packages', function (Blueprint $table) {
            
            $table->id();
            
            $table->string('name', 50)
                ->unique();

            $table->string('description')
                ->nullable()
                ->default(null);

            $table->decimal('commission', 20, 8);

            $table->string('is_default', 3)
                ->index('agent_packages_is_default_idx')
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
        Schema::dropIfExists('agent_packages');
    }
};
