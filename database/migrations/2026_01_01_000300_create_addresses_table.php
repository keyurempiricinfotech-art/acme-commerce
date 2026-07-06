<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label')->default('shipping');
            $table->string('line_one');
            $table->string('line_two')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->char('country_code', 2);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
            $table->unique(['user_id', 'label']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
