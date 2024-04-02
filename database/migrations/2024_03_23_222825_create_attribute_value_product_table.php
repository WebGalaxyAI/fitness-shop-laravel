<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_value_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\AttributeValue::class)->constrained()
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (!app()->isLocal()) {
            return;
        }
        Schema::dropIfExists('attribute_value_product');
    }
};
