<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('description')->nullable();
                $table->unsignedInteger('userId')->unsigned();
                $table->integer('estimatedTime')->nullable();
                $table->integer('usedTime')->nullable();
                $table->timestamp('createdAt')->nullable();
                $table->timestamp('completedAt')->nullable();
                $table->boolean('done')->default(0);
                $table->timestamps();
            });
        }

        Schema::table('tasks', function (Blueprint $table) {
                $table->foreign('userId', 'fk__tasks__userId')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
