<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('label_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Label::class)->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (!app()->isLocal()) {
            return;
        }
        Schema::dropIfExists('label_product');
    }
};
