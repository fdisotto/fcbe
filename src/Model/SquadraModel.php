<?php

namespace FCBE\Model;

class SquadraModel extends BaseModel
{
    /**
     * @var SquadraGiocatoreModel[]
     */
    public array $titolari;

    /**
     * @var SquadraGiocatoreModel[]
     */
    public array $panchinari;

    /**
     * @var SquadraGiocatoreModel[]
     */
    public array $tribuna;
}
