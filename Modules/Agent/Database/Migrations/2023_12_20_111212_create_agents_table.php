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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agent_package_id')
                ->index('agents_agent_package_id_idx')
                ->constrained('agent_packages')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('country_id')
                ->index('agents_country_id_idx')
                ->constrained('countries')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('first_name', 50)
                ->index('agents_first_name_idx');

            $table->string('last_name', 50)
                ->index('agents_last_name_idx');
                
            $table->string('email', 100)
                ->unique();

            $table->string('password', 191);

            $table->char('iso2', 2)
                ->nullable()
                ->default(null);

            $table->string('dial_code', 10)
                ->nullable()
                ->default(null);

            $table->string('phone', 20)
                ->unique()
                ->nullable()
                ->default(null);

            $table->string('formatted_phone', 30)
                ->nullable()
                ->default(null);

            $table->string('photo', 100)
                ->nullable()
                ->default(null);

            $table->text('address')
                ->nullable()
                ->default(null);

            $table->string('city', 50)
                ->nullable()
                ->default(null);

            $table->string('state', 50)
                ->nullable()
                ->default(null);

            $table->string('timezone', 50)
                ->nullable()
                ->default(null);

            $table->string('status', 9)
                ->default('Active')
                ->index('agents_status_idx')
                ->comment('Active, Suspended, Inactive');

            $table->string('business_name', 50)
                ->nullable()
                ->index('agents_business_name_idx');

            $table->string('type', 30)
                ->default('Agent');

            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('agents');
    }
};
