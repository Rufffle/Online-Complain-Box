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
        Schema::create('parents_complains', function (Blueprint $table) {
            $table->id();
            $table->string('ParentsName');
            $table->string('ComplainType');
            $table->string('ComplainSection');
            $table->string('message');
            $table->string('ComplainStatus')->nullable();
            $table->string('userID')->nullable();
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
        Schema::dropIfExists('parents_complains');
    }
};
