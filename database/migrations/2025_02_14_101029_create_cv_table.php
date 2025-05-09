<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('title',255);
            $table->string('slug',255)->nullable();

            $table->date('birthday')->nullable();
            $table->tinyInteger('gender_status')->nullable();
            $table->tinyInteger('married_status')->nullable();
            $table->tinyInteger('is_child')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('permanent_address',255)->nullable();
            $table->string('actual_address',255)->nullable();
            $table->string('phone',13)->nullable();
            $table->string('email',255)->nullable();

            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->unsignedBigInteger('parent_category_id')->index()->nullable();
            $table->integer('working_hour')->nullable();
            $table->string('min_salary',255)->nullable();
            $table->string('max_salary',255)->nullable();
            $table->string('desired_address',255)->nullable();

            $table->json('skills')->nullable();
            $table->json('language')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('projects')->nullable();
            $table->json('hobby')->nullable();
            $table->json('socials')->nullable();
            $table->string('resume')->nullable();
            $table->text('motivation_letter')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->tinyInteger('is_new')->default(0)->nullable();
            $table->tinyInteger('is_premium')->default(0)->nullable();
            $table->integer('reads')->default(0)->nullable();
            $table->integer('share')->default(0)->nullable();

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
        Schema::dropIfExists('cv');
    }
}
