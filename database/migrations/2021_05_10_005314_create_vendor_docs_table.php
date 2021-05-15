<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement')->constrained('procurements');
            $table->foreignId('vendor')->constrained('vendors');
            $table->foreignId('item')->constrained('items');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('doc_type')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE vendor_docs ADD doc MEDIUMBLOB NULL AFTER doc_type");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_docs');
    }
}