<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RestaurantTag;
use Illuminate\Support\Str;

class CreateRestaurantTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        $tags = [
            'Ethnic',
            'Fast food',
            'Fast casual',
            'Casual dining',
            'Premium casual',
            'Family style',
            'Fine dining',
            'Variations',
            'Brasserie and bistro',
            'Buffet and smörgåsbord',
            'Café',
            'Cafeteria',
            'Coffee house',
            'Destination restaurant',
            'Greasy spoon',
            'Tabletop cooking',
            'Mongolian barbecue',
            'Pub',
            'Teppanyaki-style'
        ];

        foreach($tags as &$tag) {
            $tag = [
                'name' => $tag,
                'slug' => Str::slug($tag)
            ];
        }

        RestaurantTag::insert($tags);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_tags');
    }
}
