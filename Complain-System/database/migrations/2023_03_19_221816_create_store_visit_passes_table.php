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
        Schema::create('store_visit_passes', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('StudentId');
            $table->string('RelationOfStudent');
            $table->string('Date');
            $table->string('VisitHour');
            $table->string('Purpose');
            $table->string('VisitingStatus')->nullable();
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
        Schema::dropIfExists('store_visit_passes');
    }
};
