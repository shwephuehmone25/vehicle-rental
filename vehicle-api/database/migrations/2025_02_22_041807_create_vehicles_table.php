<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('brand')->index();
            $table->string('model');
            $table->year('year');
            $table->enum('type', ['Car', 'Bike', 'Van', 'Truck', 'SUV']);
            $table->decimal('price_per_day', 10, 2)->default(0);
            $table->boolean('availability')->default(true)->index();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('owner_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('financial_status', ['Active', 'Suspended', 'Bankrupt'])->default('Active')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
