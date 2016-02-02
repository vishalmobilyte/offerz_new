<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OffersTable extends Table
{
	  public function initialize(array $config)
    {
        $this->belongsTo('Clients');
    }

}
?>