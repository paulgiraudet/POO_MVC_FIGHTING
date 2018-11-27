<?php 

declare(strict_types = 1);

class Character {
    protected   $id,
                $name,
                $damage;

    // const SELF_DAMAGE = "Mais pourquoi tu te tapes ?!";
    const DAMAGE_TAKEN = " a pris 5 points de dégâts !";
    const KILL = " est mort !";

    public function __construct(array $dataChar){
        $this->hydrate($dataChar);
    }    

    /**
     * hydrate our object
     *
     * @param array $dataChar
     * @return void
     */
    public function hydrate(array $dataChar){
        foreach ($dataChar as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * our three differents getter
     *
     * @return void
     */
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getDamage(){
        return $this->damage;
    }

    /**
     * setter for _id
     *
     * @param integer $id
     * @return void
     */
    public function setId($id){
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }
    }
    /**
     * setter for _name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name){
        if (is_string($name)) {
            $this->name = $name;
        }
    }
    /**
     * setter for _damage
     *
     * @param integer $damage
     * @return void
     */
    public function setDamage($damage){
        $damage = (int) $damage;
        // if ($damage >= 0 && $damage <= 100) {
            $this->damage = $damage;
        // }
        return $this;
    }

    /**
     * target the good char
     *
     * @param object $char
     * @return void
     */
    public function fight(Character $char){
        return $char->takeDamage();
    }
    /**
     * the good char takes damage
     *
     * @return void
     */
    public function takeDamage(){
        $this->damage += 5;

        return $this->damage;
        if ($this->damage >= 100) {
            return $this->getName() . self::KILL;
        }
        return $this->getName() . self::DAMAGE_TAKEN;
    }
}