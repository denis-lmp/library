<?php

namespace Database\Seeders;

use App\Models\Book;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Book::create([
                'title'            => $faker->sentence,
                'publisher'        => $faker->company,
                'author'           => $faker->name,
                'genre'            => $faker->word,
                'publication_date' => $faker->date,
                'word_count'       => $faker->numberBetween(10000, 100000),
                'price'            => $faker->randomFloat(2, 5, 50)
            ]);
        }
    }
}
