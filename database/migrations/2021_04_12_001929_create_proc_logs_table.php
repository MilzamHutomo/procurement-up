<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proc_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement')->constrained('procurements');
            $table->string('message');
            $table->foreignId('sender')->constrained('users');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('proc_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
