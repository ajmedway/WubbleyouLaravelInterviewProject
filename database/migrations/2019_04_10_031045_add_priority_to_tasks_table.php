<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriorityToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('priority')->after('name');
            $table->index(['user_id', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Laravel 5.2 bug workaround...
            // https://stackoverflow.com/a/52768106/2429318
            $table->index('user_id');

            $table->dropIndex(['user_id', 'priority']);
            $table->dropColumn('priority');
        });
    }
}
