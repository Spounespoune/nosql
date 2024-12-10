<?php

namespace App\Command\ElasticSearch;

use Elastic\Elasticsearch\ClientBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'testElastic', description: 'Test elasticsearch command')]
class ElasticSearchTestCommande extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {

        $client = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200'])
            ->setBasicAuthentication('elastic', 'test')
            ->build();

        if ($client->indices()->exists(['index' => 'movies'])) {
            $client->indices()->delete(['index' => 'movies']);
        }

        try {
            $client->indices()->create([
                "index" => "movies",
                "body" => [
                    "mappings" => [
                        "dynamic" => "strict",
                        "properties" => [
                            "directors" => ["type" => "keyword"],
                            "release_date" => [
                                "type" => "date",
                                "format" => "yyyy-MM-dd'T'HH:mm:ss'Z'",
                            ],
                            "genres" => ["type" => "keyword"],
                            "plot" => ["type" => "text"],
                            "title" => ["type" => "text"],
                            "rank" => ["type" => "integer"],
                            "running_time_secs" => ["type" => "integer"],
                            "actors" => ["type" => "keyword"],
                            "year_exact" => ["type" => "keyword"],
                            "year_numeric" => ["type" => "integer"],
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $exception) {
            dump($exception->getMessage());
        }

        try {
            dump($client->bulk($this->dataProvider())->asArray());
        } catch (\Exception $exception) {
            dump($exception->getMessage());
        }

        return Command::SUCCESS;
    }


    private function dataProvider(): array
    {
        return [
            'body' => [
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["David Fincher"],
                    "release_date" => "1999-10-15T00:00:00Z",
                    "genres" => ["Drama", "Thriller"],
                    "plot" => "A man becomes disillusioned with his job and life and forms an underground fight club with a soap salesman.",
                    "title" => "Fight Club",
                    "rank" => 5,
                    "running_time_secs" => 7500,
                    "actors" => ["Brad Pitt", "Edward Norton", "Helena Bonham Carter"],
                    "year_exact" => "1999",
                    "year_numeric" => 1999
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Christopher Nolan"],
                    "release_date" => "2010-07-16T00:00:00Z",
                    "genres" => ["Action", "Adventure", "Sci-Fi"],
                    "plot" => "A thief who enters the dreams of others to steal secrets from their subconscious is given a chance to have his criminal record erased if he can successfully perform an inception.",
                    "title" => "Inception",
                    "rank" => 8.8,
                    "running_time_secs" => 8880,
                    "actors" => ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Ellen Page"],
                    "year_exact" => "2010",
                    "year_numeric" => 2010
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["James Cameron"],
                    "release_date" => "1997-12-19T00:00:00Z",
                    "genres" => ["Drama", "Romance"],
                    "plot" => "A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.",
                    "title" => "Titanic",
                    "rank" => 7.8,
                    "running_time_secs" => 10500,
                    "actors" => ["Leonardo DiCaprio", "Kate Winslet", "Billy Zane"],
                    "year_exact" => "1997",
                    "year_numeric" => 1997
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Martin Scorsese"],
                    "release_date" => "2006-10-06T00:00:00Z",
                    "genres" => ["Crime", "Drama", "Thriller"],
                    "plot" => "An undercover cop and a mole in the police attempt to identify each other while infiltrating an Irish gang in Boston.",
                    "title" => "The Departed",
                    "rank" => 8.5,
                    "running_time_secs" => 8400,
                    "actors" => ["Leonardo DiCaprio", "Matt Damon", "Jack Nicholson"],
                    "year_exact" => "2006",
                    "year_numeric" => 2006
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Quentin Tarantino"],
                    "release_date" => "1994-10-14T00:00:00Z",
                    "genres" => ["Crime", "Drama"],
                    "plot" => "The lives of two mob hitmen, a boxer, a gangster's wife, and a pair of diner bandits intertwine in four tales of violence and redemption.",
                    "title" => "Pulp Fiction",
                    "rank" => 8.9,
                    "running_time_secs" => 8100,
                    "actors" => ["John Travolta", "Uma Thurman", "Samuel L. Jackson"],
                    "year_exact" => "1994",
                    "year_numeric" => 1994
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Ridley Scott"],
                    "release_date" => "1979-06-22T00:00:00Z",
                    "genres" => ["Horror", "Sci-Fi"],
                    "plot" => "After a space merchant vessel perceives an unknown transmission as a distress signal, it lands on a distant planet. The crew discovers a deadly alien life form that is now hunting them.",
                    "title" => "Alien",
                    "rank" => 8.4,
                    "running_time_secs" => 7200,
                    "actors" => ["Sigourney Weaver", "Tom Skerritt", "John Hurt"],
                    "year_exact" => "1979",
                    "year_numeric" => 1979
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Peter Jackson"],
                    "release_date" => "2001-12-19T00:00:00Z",
                    "genres" => ["Action", "Adventure", "Fantasy"],
                    "plot" => "A young hobbit sets out on a perilous journey to destroy a powerful ring that could bring darkness to the world.",
                    "title" => "The Lord of the Rings: The Fellowship of the Ring",
                    "rank" => 8.8,
                    "running_time_secs" => 10800,
                    "actors" => ["Elijah Wood", "Ian McKellen", "Viggo Mortensen"],
                    "year_exact" => "2001",
                    "year_numeric" => 2001
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Steven Spielberg"],
                    "release_date" => "1993-06-11T00:00:00Z",
                    "genres" => ["Adventure", "Sci-Fi", "Thriller"],
                    "plot" => "During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run wild.",
                    "title" => "Jurassic Park",
                    "rank" => 8.1,
                    "running_time_secs" => 8400,
                    "actors" => ["Sam Neill", "Laura Dern", "Jeff Goldblum"],
                    "year_exact" => "1993",
                    "year_numeric" => 1993
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Ridley Scott"],
                    "release_date" => "2000-09-10T00:00:00Z",
                    "genres" => ["Action", "Drama", "War"],
                    "plot" => "In 1992, the U.S. military sends a platoon of soldiers into Somalia to capture a warlord. When the mission goes awry, the soldiers must fight to survive.",
                    "title" => "Black Hawk Down",
                    "rank" => 7.7,
                    "running_time_secs" => 9000,
                    "actors" => ["Josh Hartnett", "Ewan McGregor", "Tom Sizemore"],
                    "year_exact" => "2001",
                    "year_numeric" => 2001
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["The Wachowskis"],
                    "release_date" => "1999-03-31T00:00:00Z",
                    "genres" => ["Action", "Sci-Fi"],
                    "plot" => "A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.",
                    "title" => "The Matrix",
                    "rank" => 8.7,
                    "running_time_secs" => 8160,
                    "actors" => ["Keanu Reeves", "Laurence Fishburne", "Carrie-Anne Moss"],
                    "year_exact" => "1999",
                    "year_numeric" => 1999
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Stanley Kubrick"],
                    "release_date" => "1968-04-03T00:00:00Z",
                    "genres" => ["Adventure", "Sci-Fi"],
                    "plot" => "After discovering a mysterious artifact buried beneath the lunar surface, a spacecraft is sent to the moons of Jupiter to find its origins.",
                    "title" => "2001: A Space Odyssey",
                    "rank" => 8.3,
                    "running_time_secs" => 9000,
                    "actors" => ["Keir Dullea", "Gary Lockwood", "William Sylvester"],
                    "year_exact" => "1968",
                    "year_numeric" => 1968
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["George Lucas"],
                    "release_date" => "1977-05-25T00:00:00Z",
                    "genres" => ["Action", "Adventure", "Fantasy"],
                    "plot" => "A young farmer joins a rebellion against the evil Galactic Empire, leading to a confrontation with the Empire's forces.",
                    "title" => "Star Wars: Episode IV - A New Hope",
                    "rank" => 8.6,
                    "running_time_secs" => 8160,
                    "actors" => ["Mark Hamill", "Harrison Ford", "Carrie Fisher"],
                    "year_exact" => "1977",
                    "year_numeric" => 1977
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["James Cameron"],
                    "release_date" => "1984-10-26T00:00:00Z",
                    "genres" => ["Action", "Sci-Fi"],
                    "plot" => "A cyborg is sent from the future to kill the mother of the leader of a future resistance movement.",
                    "title" => "The Terminator",
                    "rank" => 8.0,
                    "running_time_secs" => 5400,
                    "actors" => ["Arnold Schwarzenegger", "Linda Hamilton", "Michael Biehn"],
                    "year_exact" => "1984",
                    "year_numeric" => 1984
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Christopher Nolan"],
                    "release_date" => "2012-07-20T00:00:00Z",
                    "genres" => ["Action", "Adventure", "Crime"],
                    "plot" => "With the help of allies, Batman attempts to stop an insurrection led by a masked terrorist known as Bane.",
                    "title" => "The Dark Knight Rises",
                    "rank" => 8.4,
                    "running_time_secs" => 9120,
                    "actors" => ["Christian Bale", "Tom Hardy", "Anne Hathaway"],
                    "year_exact" => "2012",
                    "year_numeric" => 2012
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Martin Scorsese"],
                    "release_date" => "1990-09-19T00:00:00Z",
                    "genres" => ["Crime", "Drama"],
                    "plot" => "The story of the rise and fall of the infamous Henry Hill, from his start as a small-time mobster to his involvement in major crimes.",
                    "title" => "Goodfellas",
                    "rank" => 8.7,
                    "running_time_secs" => 8700,
                    "actors" => ["Robert De Niro", "Ray Liotta", "Joe Pesci"],
                    "year_exact" => "1990",
                    "year_numeric" => 1990
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Francis Ford Coppola"],
                    "release_date" => "1972-03-24T00:00:00Z",
                    "genres" => ["Crime", "Drama"],
                    "plot" => "The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.",
                    "title" => "The Godfather",
                    "rank" => 9.2,
                    "running_time_secs" => 10800,
                    "actors" => ["Marlon Brando", "Al Pacino", "James Caan"],
                    "year_exact" => "1972",
                    "year_numeric" => 1972
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Steven Spielberg"],
                    "release_date" => "1982-06-11T00:00:00Z",
                    "genres" => ["Adventure", "Family", "Sci-Fi"],
                    "plot" => "A young boy befriends a stranded alien, and together they attempt to return him to his spaceship.",
                    "title" => "E.T. the Extra-Terrestrial",
                    "rank" => 7.8,
                    "running_time_secs" => 7800,
                    "actors" => ["Henry Thomas", "Drew Barrymore", "Peter Coyote"],
                    "year_exact" => "1982",
                    "year_numeric" => 1982
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Christopher Nolan"],
                    "release_date" => "2023-07-21T00:00:00Z",
                    "genres" => ["Drama", "History"],
                    "plot" => "The story of J. Robert Oppenheimer and his role in the creation of the atomic bomb.",
                    "title" => "Oppenheimer",
                    "rank" => 8.6,
                    "running_time_secs" => 10800,
                    "actors" => ["Cillian Murphy", "Emily Blunt", "Matt Damon"],
                    "year_exact" => "2023",
                    "year_numeric" => 2023
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Greta Gerwig"],
                    "release_date" => "2023-07-21T00:00:00Z",
                    "genres" => ["Comedy", "Adventure"],
                    "plot" => "Barbie and Ken go on a journey of self-discovery in the real world.",
                    "title" => "Barbie",
                    "rank" => 7.0,
                    "running_time_secs" => 6840,
                    "actors" => ["Margot Robbie", "Ryan Gosling", "America Ferrera"],
                    "year_exact" => "2023",
                    "year_numeric" => 2023
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Denis Villeneuve"],
                    "release_date" => "2021-10-22T00:00:00Z",
                    "genres" => ["Sci-Fi", "Adventure"],
                    "plot" => "A noble family becomes embroiled in a war for control over the desert planet Arrakis.",
                    "title" => "Dune",
                    "rank" => 8.1,
                    "running_time_secs" => 9300,
                    "actors" => ["Timothée Chalamet", "Rebecca Ferguson", "Oscar Isaac"],
                    "year_exact" => "2021",
                    "year_numeric" => 2021
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Jon Watts"],
                    "release_date" => "2021-12-17T00:00:00Z",
                    "genres" => ["Action", "Adventure"],
                    "plot" => "Peter Parker seeks help from Doctor Strange to restore his secret identity.",
                    "title" => "Spider-Man: No Way Home",
                    "rank" => 8.3,
                    "running_time_secs" => 8820,
                    "actors" => ["Tom Holland", "Zendaya", "Benedict Cumberbatch"],
                    "year_exact" => "2021",
                    "year_numeric" => 2021
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Matt Reeves"],
                    "release_date" => "2022-03-04T00:00:00Z",
                    "genres" => ["Action", "Crime"],
                    "plot" => "Batman investigates corruption in Gotham City and faces the Riddler.",
                    "title" => "The Batman",
                    "rank" => 7.8,
                    "running_time_secs" => 10500,
                    "actors" => ["Robert Pattinson", "Zoë Kravitz", "Colin Farrell"],
                    "year_exact" => "2022",
                    "year_numeric" => 2022
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["James Gunn"],
                    "release_date" => "2023-05-05T00:00:00Z",
                    "genres" => ["Action", "Sci-Fi"],
                    "plot" => "The Guardians of the Galaxy embark on a mission to protect one of their own.",
                    "title" => "Guardians of the Galaxy Vol. 3",
                    "rank" => 8.2,
                    "running_time_secs" => 9000,
                    "actors" => ["Chris Pratt", "Zoe Saldana", "Dave Bautista"],
                    "year_exact" => "2023",
                    "year_numeric" => 2023
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Rian Johnson"],
                    "release_date" => "2022-12-23T00:00:00Z",
                    "genres" => ["Mystery", "Comedy"],
                    "plot" => "Detective Benoit Blanc investigates a murder mystery on a private Greek island.",
                    "title" => "Glass Onion: A Knives Out Mystery",
                    "rank" => 7.1,
                    "running_time_secs" => 8220,
                    "actors" => ["Daniel Craig", "Edward Norton", "Janelle Monáe"],
                    "year_exact" => "2022",
                    "year_numeric" => 2022
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Joseph Kosinski"],
                    "release_date" => "2022-05-27T00:00:00Z",
                    "genres" => ["Action", "Drama"],
                    "plot" => "Pete 'Maverick' Mitchell returns to train a new generation of Top Gun pilots.",
                    "title" => "Top Gun: Maverick",
                    "rank" => 8.4,
                    "running_time_secs" => 7800,
                    "actors" => ["Tom Cruise", "Miles Teller", "Jennifer Connelly"],
                    "year_exact" => "2022",
                    "year_numeric" => 2022
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Steven Spielberg"],
                    "release_date" => "2022-11-11T00:00:00Z",
                    "genres" => ["Drama"],
                    "plot" => "A coming-of-age story inspired by Spielberg's own childhood.",
                    "title" => "The Fabelmans",
                    "rank" => 7.6,
                    "running_time_secs" => 9000,
                    "actors" => ["Gabriel LaBelle", "Michelle Williams", "Paul Dano"],
                    "year_exact" => "2022",
                    "year_numeric" => 2022
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Sam Mendes"],
                    "release_date" => "2019-12-25T00:00:00Z",
                    "genres" => ["War", "Drama"],
                    "plot" => "Two British soldiers are assigned a dangerous mission during World War I.",
                    "title" => "1917",
                    "rank" => 8.3,
                    "running_time_secs" => 7200,
                    "actors" => ["George MacKay", "Dean-Charles Chapman", "Benedict Cumberbatch"],
                    "year_exact" => "2019",
                    "year_numeric" => 2019
                ],
                ['index' => ['_index' => 'movies']],
                [
                    "directors" => ["Todd Phillips"],
                    "release_date" => "2019-10-04T00:00:00Z",
                    "genres" => ["Drama", "Thriller"],
                    "plot" => "The origin story of the iconic villain, the Joker.",
                    "title" => "Joker",
                    "rank" => 8.4,
                    "running_time_secs" => 7320,
                    "actors" => ["Joaquin Phoenix", "Robert De Niro", "Zazie Beetz"],
                    "year_exact" => "2019",
                    "year_numeric" => 2019
                ]
            ]
        ];
    }
}