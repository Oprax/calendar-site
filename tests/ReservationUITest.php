<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Carbon\Carbon;

class ReservationUITest extends TestCase
{
    public $faker, $formatter;
    private $user, $dt_arrive, $dt_leave, $name, $forename, $email, $nb_people;

    public function setUp()
    {
        parent::setUp();

        $this->formatter = 'Y-m-d';

        $this->faker = Faker\Factory::create('fr_FR');

        $this->user = factory(App\User::class)->create();

        $this->dt_arrive = $this->faker->dateTimeBetween('now', '+ 5 days')
                                       ->format($this->formatter);

        $this->dt_leave  = $this->faker->dateTimeBetween('+ 5 days', '+ 30 days')
                                       ->format($this->formatter);

        $this->name = $this->faker->firstName;
        $this->forename = $this->faker->lastName;
        $this->email = $this->faker->email;
        $this->nb_people = $this->faker->numberBetween($min = 1, $max = 15);
    }

    public function testCreate()
    {
        $this->visit('/reservations/create?arrive_at=2015-02-10')
             ->see('Formulaire de Réservation')
             ->see('2015-02-10');

        $this->visit('/reservations/create?leave_at=2015-08-10')
             ->see('Formulaire de Réservation')
             ->see('2015-08-10');

        $this->visit('/reservations/create?arrive_at=2015-02-10&leave_at=2015-08-10')
             ->see('Formulaire de Réservation')
             ->see('2015-02-10')
             ->see('2015-08-10');
    }

    public function testCreateOK()
    {
        // Good
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Réservation')
             ->see(htmlentities("De $this->name $this->forename pour $this->nb_people personne(s).", ENT_QUOTES))
             ->see('Refusée');
    }

    public function testCreateName()
    {
        // len(name) < 2
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type('Y', 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le texte Nom doit contenir au moins 2 caract&egrave;res.");

        // name > 50
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->faker->paragraph($nbSentences = 8), 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le texte de Nom ne peut contenir plus de 50 caract&egrave;res.");

        // name missing
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ Nom est obligatoire.");
    }

    public function testCreateForename()
    {
        // len(forename) < 2
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type('X', 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le texte forename doit contenir au moins 2 caract&egrave;res.");

        // forename > 50
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->faker->paragraph($nbSentences = 8), 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le texte de forename ne peut contenir plus de 50 caract&egrave;res.");

        // forename missing
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ forename est obligatoire.");
    }

    public function testCreateEmail()
    {
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type('john.smithexample.net', 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ E-mail doit &ecirc;tre une adresse email valide.");

        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type('john.smith@example', 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ E-mail doit &ecirc;tre une adresse email valide.");

        // email missing
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->nb_people, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ E-mail est obligatoire.");
    }

    public function testCreateNbPeople()
    {
        // nb_people < 1
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type(0, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("La valeur de nb people doit &ecirc;tre sup&eacute;rieure &agrave; 1.");

        // nb_people > 15
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type(16, 'nb_people')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("La valeur de nb people ne peut &ecirc;tre sup&eacute;rieure &agrave; 15.");

        // nb_people missing
        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type($this->dt_arrive, 'arrive_at')
             ->type($this->dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ nb people est obligatoire.");
    }

    public function testCreateAt()
    {
        $dt_arrive = $this->faker->date($this->formatter, 'now');
        $dt_leave = $this->faker->date($this->formatter, $dt_arrive);

        $this->visit('/reservations/create')
             ->see('Formulaire de Réservation')
             ->type($this->name, 'name')
             ->type($this->forename, 'forename')
             ->type($this->email, 'email')
             ->type($this->nb_people, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ leave at doit &ecirc;tre une date post&eacute;rieure au $dt_arrive.");
    }

    public function testIndex()
    {
        $this->testCreateOK();

        $this->visit("/reservations?name__eq=$this->name")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?forename__eq=$this->forename")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?nb_people__eq=$this->nb_people")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?nb_people__lte=$this->nb_people")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?nb_people__gte=$this->nb_people")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?nb_people__lt=" . ($this->nb_people + 1))
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?nb_people__gt=" . ($this->nb_people - 1))
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $dt_arrive = Carbon::createFromFormat($this->formatter, $this->dt_arrive);
        $dt_leave = Carbon::createFromFormat($this->formatter, $this->dt_leave);

        $this->visit("/reservations?arrive_at__eq={$dt_arrive->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?arrive_at__gte={$dt_arrive->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?arrive_at__lte={$dt_arrive->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");


        $this->visit("/reservations?leave_at__eq={$dt_leave->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?leave_at__gte={$dt_leave->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?leave_at__lte={$dt_leave->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");


        $this->visit("/reservations?arrive_at__lte={$dt_leave->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");

        $this->visit("/reservations?leave_at__gte={$dt_arrive->toDateString()}")
             ->see("$this->name $this->forename")
             ->see("Du $this->dt_arrive au $this->dt_leave pour $this->nb_people personne(s)");
    }

    public function testShow()
    {
        $this->testCreate();
        $this->get("/reservations/1")
            ->assertResponseStatus(200);

        $this->get("/reservations/1337")
            ->assertResponseStatus(404);
    }

    public function testUpdate()
    {
        $this->testCreate();
        $this->actingAs($this->user)
            ->visit("/reservations/1/edit");

        $this->actingAs($this->user)
            ->get("/reservations/1337/edit")
            ->assertResponseStatus(404);
    }

    public function testDestroy()
    {
        $this->testCreate();
        $this->actingAs($this->user)
            ->delete("/reservations/1")
            ->assertResponseStatus(302);

        $this->actingAs($this->user)
            ->delete("/reservations/1337")
            ->assertResponseStatus(404);
    }
}
