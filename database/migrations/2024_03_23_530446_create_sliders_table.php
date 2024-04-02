<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->jsonb('title')->nullable();
            $table->jsonb('text')->nullable();
            $table->string('image', 60)->nullable();
            $table->jsonb('button')->nullable();
            $table->string('type', 15)->default('main');
            $table->integer('order')->default(1);
            $table->string('url', 60)->default('javascript:void(0);');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (!app()->isLocal()) {
            return;
        }
        Schema::dropIfExists('sliders');
    }
};
