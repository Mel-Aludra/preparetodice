<?php

namespace App\Entity;

abstract class Entity
{

    const CALCULATION_TYPES_CHOICE = [
        "Points" => "points",
        "Percent based on maximum resource value" => "percent_max",
        "Percent based on current resource value" => "percent_current"
    ];

    public function getClassName()
    {
        return lcfirst((new \ReflectionClass($this))->getShortName());
    }

    public function getDisplayableClassName()
    {
        $reflect = new \ReflectionClass($this);
        $shortName = $reflect->getShortName();
        $displayableName = strtolower(preg_replace('/(?<!\ )[A-Z]/', ' $0', $shortName));
        $displayableName = substr($displayableName, 1);
        return ucfirst($displayableName);
    }

    /**
     * @return string
     */
    public function getLightColor()
    {
        if(method_exists($this, "getColor")) {
            if($this->getColor() !== null) {
                return $this->getColor()->getLight();
            }
        }
        return "";
    }

    /**
     * @return string
     */
    public function getDarkColor()
    {
        if(method_exists($this, "getColor")) {
            if($this->getColor() !== null) {
                return $this->getColor()->getDark();
            }
        }
        return "";
    }

}