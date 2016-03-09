<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ClientsTable extends Table
{
	public function initialize(array $config)
    {
        $this->hasMany('Offers');
        $this->hasMany('Users');
        $this->hasMany('Invites');
    }
}
?>