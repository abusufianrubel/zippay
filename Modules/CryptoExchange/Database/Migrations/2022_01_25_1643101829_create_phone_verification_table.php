<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneVerificationTable extends Migration
{
    public function up()
    {
        Schema::create('phone_verification', function (Blueprint $table) {
    		$table->id();
            
    		$table->string('phone', 50)
                ->nullable();

    		$table->string('code', 16)
                ->nullable();

    		$table->string('status', 16);

    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_verification');
    }
}
