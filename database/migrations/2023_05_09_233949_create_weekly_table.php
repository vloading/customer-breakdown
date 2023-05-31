<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('sale_this_week');
            $table->string('gp_this_week')->unique();
            $table->string('total_amount_week');
            $table->string('mtd');
            $table->string('gp_3mos');
            $table->string('proj_qty');
            $table->string('proj_amount');
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
        Schema::dropIfExists('weekly');
    }
};