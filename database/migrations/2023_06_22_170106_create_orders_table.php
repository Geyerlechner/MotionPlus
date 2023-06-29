<?php

use App\Models\Customer;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order');
            $table->date('deadline');
            $table->string('priority');
            $table->integer('estimated_effort')->nullable();
            $table->integer('actual_expense')->default(0);
            $table->text('description');
            $table->string('documentation')->nullable();
            $table->boolean('completed')->default(0);
            $table->double('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(Customer::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
