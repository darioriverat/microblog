<?php

use App\Entry;
use App\User;
use Illuminate\Database\Seeder;

class SampleData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@jobsity.com',
            'twitter_user' => 'taylorotwell',
        ]);

        $user2 = factory(User::class)->create([
            'twitter_user' => 'J7mbo',
        ]);
        $user3 = factory(User::class)->create([
            'twitter_user' => 'zeevs',
        ]);

        $userStack = [$user, $user2, $user3];

        for ($i=1; $i<=10; $i++) {
            $this->createUserEntry($userStack[array_rand($userStack)]);
        }
    }

    private function createUserEntry($user)
    {
        factory(Entry::class)->create([
            'created_by' => $user->id,
        ]);
    }
}
