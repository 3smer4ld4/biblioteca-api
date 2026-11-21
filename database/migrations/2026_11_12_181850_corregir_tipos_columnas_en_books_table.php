<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->change();

            $table->unsignedInteger('cantidad')
                ->default(1)
                ->change();

            $table->unsignedInteger('disponibles')
                ->default(1)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->change();

            $table->unsignedInteger('cantidad')
                ->default(1)
                ->change();

            $table->unsignedInteger('disponibles')
                ->default(1)
                ->change();
        });
    }
};
