<?php

interface XMLable {
    public function toXML();
}

class Personne implements XMLable {
    private $nom;
    private $prenom;
    private $login;
    private static $nbInstances = 0;


    function __construct($nom, $prenom, $login) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        self::$nbInstances++;
    }

    static function getNbInstances() {
        return self::$nbInstances;
    }

    function toXML() {
        $unePersonne = simplexml_load_string("<personne/>");
        $unePersonne->addChild("nom", $this->nom);
        $unePersonne->addChild("prenom", $this->prenom);
        $unePersonne->addChild("login", $this->login);

        return $unePersonne;
    }

    function __toString() {
        return $this->nom . " " . $this->prenom . " " . $this->login;
    }
}

class PersonneSecure extends Personne {
    private $md5pwd;

    function __construct($nom, $prenom, $login, $md5pwd) {
        parent::__construct($nom, $prenom, $login);
        $this->md5pwd = $md5pwd;
    }

    function toXML() {
        $unePersonne = parent::toXML();
        $unePersonne->addChild("md5pwd", $this->md5pwd);

        return $unePersonne;
    }

    function __toString() {
        return parent::__toString() . " " . $this->md5pwd;
    }
}

$personne = new Personne("BOUZIDI", "Sophiane", "sbouzidi");
$personneSecure = new PersonneSecure("BOUZIDI", "Sophiane", "sbouzidi", "azerty");

echo $personne;
echo "<br>";
echo $personneSecure;
echo "<br>";
echo $personne->getNbInstances();
echo "<br>";
echo $personne->toXML()->asXML();
echo "<br>";
echo $personneSecure->toXML()->asXML();