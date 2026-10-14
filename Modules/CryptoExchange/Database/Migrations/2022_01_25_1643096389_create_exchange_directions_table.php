<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeDirectionsTable extends Migration
{
    public function up()
    {
        Schema::create('exchange_directions', function (Blueprint $table) {
			
			$table->id();

			$table->foreignId('from_currency_id')
				->nullable()
				->constrained('currencies')
				->onUpdate('cascade')
				->onDelete('restrict');

			$table->foreignId('to_currency_id')
				->nullable()
				->constrained('currencies')
				->onUpdate('cascade')
				->onDelete('restrict');

			$table->string('type', 100);
			
	        $table->string('exchange_from', 30)
				->default('local');

			$table->decimal('exchange_rate', 20, 8)
				->nullable();

			$table->decimal('fees_percentage', 20, 8)
				->default(0);

			$table->decimal('fees_fixed', 20, 8)
				->default(0);

			$table->decimal('min_amount', 20, 8)
				->default(0);

			$table->decimal('max_amount', 20, 8)
				->default(0);

			$table->text('payment_instruction')
				->nullable();

			$table->text('gateways')
				->nullable();

	        $table->string('status', 11)
				->default('Active');

			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('exchange_directions');
    }
}
