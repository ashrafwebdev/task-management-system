<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('task_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE task_sessions ENGINE = InnoDB;'); // Ensure InnoDB
    }

    public function down()
    {
        Schema::dropIfExists('task_sessions');
    }
}
