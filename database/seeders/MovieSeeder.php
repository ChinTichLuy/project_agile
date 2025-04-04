<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $movies = [
            [
                'title' => 'Avengers: Endgame',
                'description' => 'Sau sự kiện Thanos xóa sổ một nửa vũ trụ, các Avengers còn lại phải tập hợp lại để đảo ngược tình thế.',
                'director' => 'Anthony Russo, Joe Russo',
                'release_date' => '2019-04-26',
                'rating' => 8.4,
                'poster_path' => '/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
                'is_premium' => true,
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'Batman phải đối mặt với Joker, một tên tội phạm điên rồ đe dọa Gotham City.',
                'director' => 'Christopher Nolan',
                'release_date' => '2008-07-18',
                'rating' => 9.0,
                'poster_path' => '/qJ2tW6WMUDux911r6m7yRefrj2d.jpg',
                'is_premium' => true,
            ],
            [
                'title' => 'Inception',
                'description' => 'Một tên trộm chuyên đánh cắp bí mật từ tiềm thức của người khác được giao nhiệm vụ bất khả thi.',
                'director' => 'Christopher Nolan',
                'release_date' => '2010-07-16',
                'rating' => 8.8,
                'poster_path' => '/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg',
                'is_premium' => true,
            ],
            [
                'title' => 'Parasite',
                'description' => 'Một gia đình nghèo khó lên kế hoạch để làm việc cho một gia đình giàu có.',
                'director' => 'Bong Joon Ho',
                'release_date' => '2019-05-30',
                'rating' => 8.6,
                'poster_path' => '/7mF4fZxZgqXGZq7KdM3HxVQ9n9x.jpg',
                'is_premium' => false,
            ],
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Hai tù nhân kết bạn trong nhiều năm, tìm thấy sự an ủi và cuối cùng là sự cứu rỗi thông qua hành động tốt.',
                'director' => 'Frank Darabont',
                'release_date' => '1994-09-23',
                'rating' => 9.3,
                'poster_path' => '/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg',
                'is_premium' => false,
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
