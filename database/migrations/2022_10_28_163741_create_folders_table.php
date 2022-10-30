<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('foldername');
            $table->timestamps();
        });

        DB::table('folders')->insert([
            'id' => 1,
            'foldername' => 'Documents',
        ]);

        DB::table('folders')->insert([
            'id' => 2,
            'foldername' => 'Media',
        ]);

        DB::table('folders')->insert([
            'id' => 3,
            'foldername' => 'Brandbook',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folders');
    }
}
