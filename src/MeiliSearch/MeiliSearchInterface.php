<?php

namespace App\MeiliSearch;

interface MeiliSearchInterface{

    /**
     * @param string $name Nom de l'index à créer ou modifier
     * @param array $data {"id': int, "name": string, "content": string"}
     * @return mixed
     */
    public function createOrUpdate(string $name, array $data);

}