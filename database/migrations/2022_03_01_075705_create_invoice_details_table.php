<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->foreign('invoice_id')->on('invoices')->references('id')->onDelete('cascade');
            $table->string('invoice_number', 50);
            $table->string('section', 999);
            $table->string('product', 50);
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->string('user', 300);
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
        Schema::dropIfExists('invoice_details');
    }
}
