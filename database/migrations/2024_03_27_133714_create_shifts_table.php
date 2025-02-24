<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('display');
            $table->string('color')->nullable();
            $table->string('textColor')->nullable();
            $table->float('hours');
            $table->boolean('flexLoc')->default(true);
            $table->boolean('active')->default(true);
            $table->dateTime('deletedAt')->nullable();
            $table->integer('deletedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
