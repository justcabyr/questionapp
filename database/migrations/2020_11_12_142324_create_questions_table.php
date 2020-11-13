<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('is_general')->default('TRUE');
            $table->string('categories');
            $table->integer('point')->default(5);
            $table->string('icon_url');
            $table->integer('duration')->default(10);
            $table->string('choice_1');
            $table->string('is_correct_choice_1');
            $table->string('icon_url_1');
            $table->string('choice_2');
            $table->string('is_correct_choice_2');
            $table->string('icon_url_2');
            $table->string('choice_3');
            $table->string('is_correct_choice_3');
            $table->string('icon_url_3');
            $table->string('choice_4');
            $table->string('is_correct_choice_4');
            $table->string('icon_url_4');
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
        Schema::dropIfExists('questions');
    }
}
