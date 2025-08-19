<?php

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
        Schema::create('iuser__roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->string('system_name');
            $table->json('permissions')->nullable();

            // Audit fields
            $table->timestamps();
            //$table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iuser__roles');
    }
};
