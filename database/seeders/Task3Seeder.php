<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Audience;

class Task3Seeder extends Seeder
{
    public function run(): void
    {
        $uSok = $this->user('sok123');
        $uSao = $this->user('sao');
        $uDara = $this->user('d.dara');

        $uVeasna = $this->user('veasna');
        $uSamnang = $this->user('samnang');
        $uRatana = $this->user('ratana');

        $aSok = Author::firstOrCreate(['name' => 'Sok'], ['user_id' => $uSok->id]);
        $aSao = Author::firstOrCreate(['name' => 'Sao'], ['user_id' => $uSao->id]);
        $aDara = Author::firstOrCreate(['name' => 'Dara'], ['user_id' => $uDara->id]);

        $artClimate = $this->article($aSok->id, 'Climate changes in the last 3 years');
        $artGlobal  = $this->article($aSok->id, 'Global warming is in its critical stage');
        $artNextGen = $this->article($aSao->id, 'Computers in the next generation');
        $artQuantum = $this->article($aSao->id, 'Quantum computers, is it coming?');
        $artChem    = $this->article($aDara->id, 'Chemistry in nature form');
        $artWater   = $this->article($aDara->id, 'The origin of water');

        $samSubs = $this->subscribe($uSamnang->id, 'Samnang', [$artNextGen->id, $artChem->id, $artWater->id]);
        $veaSubs = $this->subscribe($uVeasna->id, 'Veasna', [$artClimate->id, $artWater->id, $artQuantum->id]);
        $ratSubs = $this->subscribe($uRatana->id, 'Ratana', [$artClimate->id, $artGlobal->id]);

        $artClimate->comments()->firstOrCreate(
            ['name' => 'Thank you to all the subscribers', 'user_id' => $uSok->id]
        );

        $aSao->comments()->firstOrCreate(
            ['name' => 'Your article is amazing', 'user_id' => $uSamnang->id]
        );

        $samFirst = $samSubs[0] ?? null;
        if ($samFirst) {
            $samFirst->comments()->firstOrCreate(
                ['name' => 'Welcome to read my article', 'user_id' => $uSao->id]
            );
        }

        $artQuantum->comments()->firstOrCreate(
            ['name' => "I can't wait this thing happening", 'user_id' => $uVeasna->id]
        );
    }

    private function user(string $username): User
    {
        return User::firstOrCreate(
            ['name' => $username],
            ['email' => $username . '@app.test', 'password' => Hash::make('password')]
        );
    }

    private function article(int $authorId, string $name): Article
    {
        return Article::firstOrCreate(['name' => $name, 'author_id' => $authorId]);
    }

    private function subscribe(int $userId, string $audienceName, array $articleIds): array
    {
        $subs = [];
        foreach ($articleIds as $articleId) {
            $subs[] = Audience::firstOrCreate(
                ['user_id' => $userId, 'article_id' => $articleId],
                ['name' => $audienceName]
            );
        }
        return $subs;
    }
}

