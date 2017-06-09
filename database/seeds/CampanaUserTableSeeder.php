<?php



use Illuminate\Database\Seeder;

use App\User;


Class CampanaUserTableSeeder extends Seeder
{
    /**
     *
     */
    public function run()
    {
        for($i=1; $i<=10; $i++)
        {
            $user = User::find($i);
            
            for($j=1; $j<=3;$j++)
            {
                $user->campanitas()->attach(rand(1,5));
            }
        }
        
        
    }
}

