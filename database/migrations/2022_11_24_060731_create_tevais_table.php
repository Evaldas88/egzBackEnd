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
        Schema::create('tevais', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->float('personalCode') ;
             $table->bigInteger('darzelis_id')->nullable()->unsigned();
            $table->foreign('darzelis_id')->references('id')->on('darzelis')->onDelete('set null');
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
        Schema::dropIfExists('tevais');
    }
};
