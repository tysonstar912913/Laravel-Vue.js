<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddColumnsToTimecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "ALTER TABLE `timecards` CHANGE `check_in` `check_in` INT(11) NULL";
        DB::statement($sql);
        
        $sql = "ALTER TABLE `timecards` CHANGE `check_out` `check_out` INT(11) NULL";
        DB::statement($sql);

        Schema::table('timecards', function (Blueprint $table) {
          
            $table->dropColumn('entry');
            $table->string('cost_code', 100)->nullable();
            $table->string('time_type', 100)->nullable();
            $table->string('equipment', 100)->nullable();
            $table->string('classification', 100)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_absent')->nullable();
            $table->integer('duration')->nullable();
            $table->tinyInteger('is_open')->nullable();
            $table->date('entry_date')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timecards');
    }
}
