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
        Schema::create('hall_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("subject_id");
            $table->date('date_start');
            $table->time('time_start');
            $table->date('date_end');
            $table->time('time_end');
            $table->integer('is_available')->default('1')->comment('0= not available, 1= available');
            $table->foreignId("hall_id");
            $table->foreignId("department_id");
            $table->foreignId("faculty_id");
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
        Schema::dropIfExists('hall_books');
    }
};
