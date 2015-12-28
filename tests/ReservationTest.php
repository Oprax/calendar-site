<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ReservationTest extends TestCase
{
    public $faker;

    public function setUp()
    {
    	parent::setUp();
    	$this->faker = Faker\Factory::create('fr_FR'); 
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->visit('/reservation/create?arrive_at=2015-2-10')
             ->see('Formulaire de Réservation')
             ->see('10/02/2015');

        $this->visit('/reservation/create?leave_at=2015-8-10')
             ->see('Formulaire de Réservation')
             ->see('10/08/2015');

        $this->visit('/reservation/create?arrive_at=2015-2-10&leave_at=2015-8-10')
             ->see('Formulaire de Réservation')
             ->see('10/02/2015')
             ->see('10/08/2015');

        $dt_arrive = $this->faker->dateTimeBetween('now', '+ 5 days')->format('d/m/Y');
        $dt_leave  = $this->faker->dateTimeBetween('+ 5 days', '+ 30 days')->format('d/m/Y');

        $name = $this->faker->firstName;
        $forename = $this->faker->lastName;
        $email = $this->faker->email;
        $nb_people = $this->faker->numberBetween($min = 1, $max = 15);

        // Good
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type($name, 'name')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type($nb_people, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Réservation')
             ->see(htmlentities("De $name $forename pour $nb_people personne(s).", ENT_QUOTES))
             ->see('Refusée');

        //// nb_people ////

        // nb_people < 1
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type($name, 'name')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type(0, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("La valeur de nb people doit &ecirc;tre sup&eacute;rieure &agrave; 1.");

        // nb_people > 15
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type($name, 'name')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type(16, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("La valeur de nb people ne peut &ecirc;tre sup&eacute;rieure &agrave; 15.");

        // nb_people missing
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type($name, 'name')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ nb people est obligatoire.");

        //// name ////

        // len(name) < 2
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type('Y', 'name')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type($nb_people, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le texte Nom doit contenir au moins 2 caract&egrave;res.");

        // name > 50
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type($this->faker->paragraph($nbSentences = 8), 'name')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type($nb_people, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le texte de Nom ne peut contenir plus de 50 caract&egrave;res.");

        // name missing
        $this->visit('/reservation/create')
             ->see('Formulaire de Réservation')
             ->type($forename, 'forename')
             ->type($email, 'email')
             ->type($nb_people, 'nb_people')
             ->type($dt_arrive, 'arrive_at')
             ->type($dt_leave, 'leave_at')
             ->press('Envoyer')
             ->see('Formulaire de Réservation')
             ->see("Le champ Nom est obligatoire.");
    }
}
