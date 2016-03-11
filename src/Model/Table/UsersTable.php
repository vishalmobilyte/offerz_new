<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
	public function initialize(array $config)
    {
        $this->hasMany('Clients');
        $this->hasMany('Offers_stat');
        //$this->BelongsTo('Offers_stat');
    }
}
?>