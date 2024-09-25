<?php

namespace Database\Seeders;

use App\Models\Manga;
use App\Models\MangaVolume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MangasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manga::create([
            "name"=> "Recado a Adolf",
            "on_going" => 0,
            "about" => "Osamu Tezuka explora a ascensão do nazismo em 'Recado a Adolf', um mangá que mistura suspense e drama histórico em uma narrativa envolvente.",
            "volumes" => 2,
            "publisher_id" => 2,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Buda",
            "on_going" => 0,
            "about" => "Osamu Tezuka nos convida a uma jornada épica ao lado de Siddhartha Gautama. Em 'Buda', acompanhamos a busca pela iluminação e o despertar espiritual de um dos maiores líderes religiosos da história.",
            "volumes" => 8,
            "publisher_id" => 3,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Satsuma Gishiden",
            "on_going" => 0,
            "about" => "O mestre do gekiga, Hiroshi Hirata, nos brinda com 'Satsuma Gishiden', um clássico que retrata a vida dos samurais com realismo e maestria. A obra é um marco no mangá histórico.",
            "volumes" => 3,
            "publisher_id" => 2,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Tomie",
            "on_going" => 0,
            "about" => "Uma beleza fatal e aterrorizante. Tomie, de Junji Ito, é um mergulho profundo no horror psicológico, explorando temas como obsessão, morte e a natureza humana.",
            "volumes" => 2,
            "publisher_id" => 2,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Cidade das Lápides",
            "on_going" => 0,
            "about" => "Uma coletânea de contos perturbadores, 'Cidade das Lápides' de Junji Ito nos apresenta um universo sombrio e cheio de mistérios. Cada história é uma nova dose de terror psicológico.",
            "volumes" => 1,
            "publisher_id" => 2,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "As Crônicas da Era do Gelo",
            "on_going" => 0,
            "about" => "Em um futuro congelado, a humanidade luta pela sobrevivência. 'As Crônicas da Era do Gelo' de Jiro Taniguchi nos leva a uma jornada épica em um mundo pós-apocalíptico, onde a natureza impera e a tecnologia é crucial.",
            "volumes" => 2,
            "publisher_id" => 2,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "A Valise do Professor",
            "on_going" => 0,
            "about" => "Uma valise, um segredo e uma amizade improvável. 'A Valise do Professor' de Jiro Taniguchi é uma história tocante sobre as conexões humanas e a passagem do tempo.",
            "volumes" => 2,
            "publisher_id" => 2,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Tutor Hitman Reborn",
            "on_going" => 0,
            "about" => "Um bebê hitman e seu aluno improvável. 'Tutor Hitman Reborn' é uma mistura explosiva de comédia, ação e drama, que te fará rir e chorar!",
            "volumes" => 42,
            "publisher_id" => 1,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Boa Noite Punpun",
            "on_going" => 0,
            "about" => "A vida de Punpun, um garoto comum, não é nada comum. 'Boa Noite Punpun' é uma história tocante e perturbadora sobre o crescimento e as dificuldades da vida adulta.",
            "volumes" => 12,
            "publisher_id" => 3,
            "user_id" => 1
        ]);

        Manga::create([
            "name"=> "Fragmentos do horror",
            "on_going" => 0,
            "about" => "Fragmentos de terror puro. Junji Ito está de volta com uma nova coletânea de histórias que vão te deixar sem ar. Uma experiência aterrorizante garantida.",
            "volumes" => 1,
            "publisher_id" => 4,
            "user_id" => 1
        ]);

        

       
    }
}
