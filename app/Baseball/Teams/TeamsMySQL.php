<?php

namespace Artifacts\Baseball\Teams;

use Artifacts\Baseball\Teams\TeamsInterface;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
* The MySQL implementation of the team table class
*/

class TeamsMySQL extends Model implements TeamsInterface
{

    use Sortable;

    protected $table = 'teams';

    protected $primaryKey = 'team';

    public $incrementing = false;

    public $sortable = [
        'name',
        'city',
        'state',
        'country',
        'founded',
    ];

    /**
     * The number of records to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    public function getTeams($fields = null)
    {
        if (!$fields) {
            return TeamsMySQL::select('*')->sortable('team')->paginate();
        } else {
            return TeamsMySQL::select($fields)->get()->toArray();
        }
    }

}