<?php

use Illuminate\Database\Migrations\Migration;

class AlterLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function ($table) {
            $table->string('script', 20)->nullable()->after('abbr');
            $table->string('native', 20)->nullable()->after('script');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function ($table) {
            $table->dropColumn('script');
            $table->dropColumn('native');
        });
    }
}
