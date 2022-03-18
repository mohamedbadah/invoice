<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_nubmer');
            $table->date('invoice_Date');
            $table->date('due_date');
            $table->string('product');
            $table->foreignId('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->string('discount');
            $table->string('rate_vat');
            $table->decimal('Amount_collection', 8, 2)->nullable();
            $table->decimal('Amount_commission', 8, 2);
            $table->decimal('value_vat', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('payment_Date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
