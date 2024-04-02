<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();

            $table->foreignIdFor(\App\Models\Brand::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('sku', 100)->unique();
            $table->jsonb('name');
            $table->string('slug', 150)->unique()->nullable();
            $table->json('description')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->decimal('price', 12)->nullable();
            $table->decimal('sale_price', 12)->nullable();
            $table->boolean('active')->default(1);

            $table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
        if (!app()->isLocal()) {
            return;
        }
		Schema::dropIfExists('products');
	}
};
