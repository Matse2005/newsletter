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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('title');
            $table->string('local');
            $table->json('translations');
            $table->timestamps();
        });

        // Insert default row(s) into the languages table
        DB::table('languages')->insert([
            [
                'key' => 'default',
                'title' => 'Default',
                'local' => 'Default',
                'translations' => json_encode([
                    "email" => [
                        "footer" => [
                            "company" => "Your Company Heuvelstraat 106/2 3390 Tielt-Winge Belgium",
                            "in_browser" => "Open this newsletter in the browser",
                            "click_here" => "click here",
                            "send_to" => "This email has been sent to",
                            "privacy_statement" => "Privacy Statement",
                            "tos" => "Terms & Conditions",
                            "unsubscibe" => "Unsubscribe",
                            "urls" => [
                                "privacy_statement" => "https://www.dezittere-philac.be/content/2-privacy-statement",
                                "tos" => "https://www.dezittere-philac.be/content/3-algemene-voorwaarden"
                            ]
                        ]
                    ],
                    "pages" => [
                        "unsubscribe" => [
                            "title" => "Dezittere Philac",
                            "unsubscribe" => "Unsubscribe",
                            "description" => "You have successfully unsubscribed from our newsletter. If you'd like to receive our updates again, you can re-subscribe at any time.",
                            "subscribe_again" => "Subscribe Again",
                            "url" => [
                                "subscribe_again" => "https://www.dezittere-philac.be/#footer"
                            ]
                        ]
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
