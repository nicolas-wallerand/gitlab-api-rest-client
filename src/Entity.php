<?php

namespace ApiClientGitlab;

/**
 * Class Entity
 *
 * @package ApiClientGitlab
 */
class Entity
{
    /**
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $attribut => $valeur) {
            $attributPart = explode('_', $attribut);

            array_walk_recursive($attributPart, function (&$v) {
                $v = ucfirst($v);
            });
            $attribut = implode('', $attributPart);

            $methode = 'set' . ucfirst($attribut);

            if (is_callable([$this, $methode])) {
                $this->$methode($valeur);
            } else {
                //var_dump($methode);
            }
        }
    }
}