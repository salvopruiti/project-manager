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
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->integer('priority');
            $table->integer('source')->default(0);
            $table->tinyInteger('status');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });

        Schema::table('tasks', function(Blueprint $table) {
            $table->foreignId('ticket_id')->nullable()->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function(Blueprint $table) {
            $table->dropConstrainedForeignId('ticket_id');
        });

        Schema::dropIfExists('tickets');
    }
}
