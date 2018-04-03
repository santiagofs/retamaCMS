<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('display_name', 50);
            $table->string('short_display_name', 50);
            $table->string('i18n', 20);
            $table->string('laravel_prefix', 2);
            $table->tinyInteger('is_default');
            $table->tinyInteger('is_enabled');
            $table->tinyInteger('is_active');
            $table->timestamps();

            $table->index(['is_enabled', 'is_default', 'is_active'], 'enabled');;
            $table->index(['i18n'], 'iana');
        });

        // Insert some stuff
        DB::table('languages')->insert(
            array(
                'name' => 'English',
                'display_name' => 'English',
                'short_display_name' => 'Eng',
                'i18n' => 'en_EN',
                'laravel_prefix' => 'en',
                'is_default' => 1,
                'is_enabled' => 1,
                'is_active' => 1,
            )
        );
        DB::table('languages')->insert(
            array(
                'name' => 'Spanish',
                'display_name' => 'Español',
                'short_display_name' => 'Esp',
                'i18n' => 'es_ES',
                'laravel_prefix' => 'es',
                'is_default' => 0,
                'is_enabled' => 1,
                'is_active' => 1,
            )
        );
        DB::table('languages')->insert(
            array(
                'name' => 'French',
                'display_name' => 'Français',
                'short_display_name' => 'Fr',
                'i18n' => 'fr_FR',
                'laravel_prefix' => 'fr',
                'is_default' => 0,
                'is_enabled' => 0,
                'is_active' => 0,
            )
        );
        DB::table('languages')->insert(
            array(
                'name' => 'Portuguese',
                'display_name' => 'Português',
                'short_display_name' => 'BR',
                'i18n' => 'pt_BR',
                'laravel_prefix' => 'pt',
                'is_default' => 0,
                'is_enabled' => 0,
                'is_active' => 0,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
