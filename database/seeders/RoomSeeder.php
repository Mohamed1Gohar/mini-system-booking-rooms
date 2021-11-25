<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 6; $i++) {
            Room::create([
                'room_number' => $i,
                'number_of_beds' => rand(1,4),
                'price' => rand(100,300)
            ]);
        }

    }
}
