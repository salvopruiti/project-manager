<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tag_task', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tag_id')->constrained();
            $table->foreignId('task_id')->constrained();
            $table->index(['tag_id', 'task_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_task');
    }
};
