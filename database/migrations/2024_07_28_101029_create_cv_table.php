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
            $table->unsignedBigInteger('city_id')->index();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
            $table->string('image',512)->nullable();
            $table->string('name',255)->nullable();
            $table->string('surname',255)->nullable();
            $table->text('description')->nullable();
            $table->date('birthday');
            $table->string('phone',255)->nullable();
            $table->string('email',255)->nullable();
            $table->tinyInteger('marriage')->default(0);
            $table->integer('gender');
            ///staj
            $table->unsignedBigInteger('profession_id')->index();
            $table->foreign('profession_id')->references('id')->on('jobs')->onDelete('restrict');
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->integer('work_exp')->nullable();
            $table->integer('education_type')->nullable();
            $table->unsignedBigInteger('type_id')->index();
            $table->foreign('type_id')->references('id')->on('job_types')->onDelete('restrict');
            $table->string('min_salary')->nullable();
            $table->string('max_salary')->nullable();
            $table->string('cv_file',512)->nullable();
            //islediyi yerler
            $table->json('work_experience')->nullable();
            $table->json('education')->nullable();
            $table->json('diploma_certificate')->nullable();
            $table->json('language_skills')->nullable();
            $table->json('work_skills')->nullable();
            $table->json('driving_license')->nullable();
            $table->json('portfolio')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('reads')->index()->default(0);
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
