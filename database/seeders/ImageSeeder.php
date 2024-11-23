<?php

namespace Database\Seeders;

use Carbon\Factory;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class ImageSeeder extends Seeder
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run(): void
    {
        $directory = 'poster';
        $default = 'poster/default';

        if (!Storage::disk('public')->exists($default)) {
            Storage::disk('public')->makeDirectory($default);
        }

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        if (!Storage::disk('public')->exists($default . '/default.jpg')) {
            $fileName = 'default.jpg';
            $filePath = storage_path("app/public/{$default}/{$fileName}");
            $text = "Default poster for new film";
            $this->createFileJpg($filePath, $text);
        }

        for ($i = 0; $i < 10; $i++) {
            $fileName = "image_{$i}.jpg";
            $filePath = storage_path("app/public/{$directory}/{$fileName}");
            $text = "Poster {$i} for new film";
            $this->createFileJpg($filePath, $text);
        }


//            $width = 640;
//            $height = 480;
//
//            $image = imagecreatetruecolor($width, $height);
//
//            $backgroundColor = imagecolorallocate(
//                $image,
//                $this->faker->numberBetween(0, 255),
//                $faker->numberBetween(0, 255),
//                $faker->numberBetween(0, 255),
//            );
//            imagefill($image, 0, 0, $backgroundColor);
//
//            $textColor = imagecolorallocate($image, 255, 255, 255); // Белый цвет
//            $text = "Poster {$i} for new film";
//            imagestring($image, 10, 10, 10, $text, $textColor);
//
//            imagejpeg($image, $filePath);
//
//            imagedestroy($image);

        }

    private function createFileJpg(string $filePath, string $text): void
    {
        $width = 640;
        $height = 480;

        $image = imagecreatetruecolor($width, $height);

        $backgroundColor = imagecolorallocate(
            $image,
            $this->faker->numberBetween(0, 255),
            $this->faker->numberBetween(0, 255),
            $this->faker->numberBetween(0, 255),
        );
        imagefill($image, 0, 0, $backgroundColor);

        $textColor = imagecolorallocate($image, 255, 255, 255); // Белый цвет
        imagestring($image, 10, 10, 10, $text, $textColor);

        imagejpeg($image, $filePath);

        imagedestroy($image);
   }
}
