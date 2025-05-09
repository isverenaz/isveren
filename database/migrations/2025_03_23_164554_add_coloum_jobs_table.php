<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->tinyInteger('is_premium')->default(0)->nullable()->after('reads');
            $table->tinyInteger('is_new')->default(0)->nullable()->after('is_premium');
            $table->tinyInteger('is_top')->default(0)->nullable()->after('is_new');
            $table->tinyInteger('is_featured')->default(0)->nullable()->after('is_top');
            $table->tinyInteger('is_paid')->default(0)->nullable()->after('is_featured');
            $table->date('start_date')->nullable()->after('is_paid');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
