<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishedToNameStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `names` CHANGE `status` `status` ENUM('Not started','Started','In progress','For review','Reviewed','Published') NOT NULL DEFAULT 'Not started'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `names` CHANGE `status` `status` ENUM('Not started','Started','In progress','For review','Reviewed') NOT NULL DEFAULT 'Not started'");
    }
}
