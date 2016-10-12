<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('name_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('revision_title');
            $table->string('name');
            $table->text('verse');
            $table->text('meaning_function');
            $table->text('identical_titles');
            $table->text('significance');
            $table->text('responsibility');
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
        Schema::dropIfExists('revisions');
    }
}
