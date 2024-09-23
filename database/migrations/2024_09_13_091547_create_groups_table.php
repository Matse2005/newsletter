<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string("group");
            $table->text("description")->nullable();
            $table->boolean("can_unsubscribe")->default(false);
            $table->boolean("editable")->default(true);
            $table->boolean("manual")->default(true);
            $table->json("emails")->nullable();
            $table->timestamps();
        });

        DB::table('groups')->insert([
            [
                'id' => 1,
                'group' => 'Ingeschreven',
                'description' => 'Alle e-mails aangemeld via de website',
                'can_unsubscribe' => 1,
                'editable' => 0,
                'manual' => 0,
                'emails' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
