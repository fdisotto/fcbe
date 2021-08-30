<?php

namespace FCBE\Model\Updater;

use FCBE\Model\BaseModel;

class UpdaterModel extends BaseModel
{
    /**
     * @var CalciatoriUpdaterModel
     */
    public CalciatoriUpdaterModel $calciatori;

    /**
     * @var GiornataUpdaterModel[]
     */
    public array $giornate;
}
