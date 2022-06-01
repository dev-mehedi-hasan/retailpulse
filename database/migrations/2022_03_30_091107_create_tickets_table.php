<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('medium')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('user_code')->nullable();
            $table->string('user_type')->nullable();
            $table->string('user_name')->nullable();
            $table->string('mobile_model')->nullable();
            $table->string('issue_type')->nullable();
            $table->longText('issue_description')->nullable();
            $table->string('status')->nullable();
            $table->longText('remarks')->nullable();
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('updated_at');
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('external_phone_number')->nullable();
            $table->string('external_created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
