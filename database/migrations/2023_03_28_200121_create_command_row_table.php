<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('zip_code');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->string('status');
            $table->date('order_date');
            $table->date('closing_date')->nullable();
            $table->timestamps();
        });

        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('carrier');
            $table->date('delivery_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('version');
            $table->float('weight');
            $table->string('serial_number')->nullable();
            $table->foreignId('order_id')->constrained()->nullable();
            $table->foreignId('parcel_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('parcels');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('customers');
    }
};
