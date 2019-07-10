<?php

namespace Artifacts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Artifacts\Player\Player;
use Kyslik\ColumnSortable\Sortable;

class PlayerController extends Controller
{
     /**
     * Constructor
     */
    public function __construct()
    {
    }

  /**
     * Display players
     *
     * @return Response
     */
    public function index()
    {
        $players = Player::sortable()->paginate(500);
        return view('players', ['players' => $players]);
    }

    /**
     * Show the form for creating a new player
     *
     * @return Response
     */
    public function create()
    {
		return view('player', ['title' => 'Add Player']);
    }

    /**
     * Store a newly created player in the database
     *
     * @param Request request
     * @return Response
     */
    public function store(Request $request)
    {
	    $validator = $request->validate([
	        'first_name' => 'required|max:255',
	        'last_name' => 'required|max:255',
	        'team' => 'required|string'
	    ]);

        if ( isset($request->id)){
            $player = Player::findOrFail($request->id);
        } else {
            $player = new Player();
        }

        $player->first_name     = $request->first_name;
        $player->last_name      = $request->last_name;
        $player->team           = $request->team;
        $player->city           = $request->city;
        $player->state          = $request->state;
        $player->country        = $request->country;
        $player->birthdate      = $request->birthdate;        
        $player->draft_year     = $request->draft_year;
        $player->draft_round    = $request->draft_round;
        $player->draft_position = $request->draft_position;
        $player->debut_year     = $request->debut_year;
	    $player->save();

	    return redirect('/players');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $player = Player::find($id);
        return view('player', ['title' => 'Edit Player', 'player' => $player]);
    }


    /**
     * Search for player.
     *
     * @param  string  $q
     * @return Response
     */
    public function search(Request $request)
    {
        $q = $request->q;
        $players = [];
        if ($q != "") {
            $players = \DB::table('players')
                ->select('players.*')
                ->where('team', 'LIKE', '%' . $q . '%')
                ->orWhere('city', 'LIKE', '%' . $q . '%')
                ->orWhere('first_name', 'LIKE', '%' . $q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $q . '%')
                ->orWhere('state', 'LIKE', '%' . $q . '%')
                ->orWhere('country', 'LIKE', '%' . $q . '%')
                ->orWhere('draft_year', 'LIKE', '%' . $q . '%')
                ->orWhere('draft_round', 'LIKE', '%' . $q . '%')
                ->orWhere('debut_year', 'LIKE', '%' . $q . '%')
                ->paginate(15)
                ->appends(['q' => $q])
                ->setPath('');
            }
        if (count ( $players ) > 0) {
            return view('players', ['players' => $players]);
        } else {
            return view('players', ['players' => $players])->withMessage('No Details found. Try to search again !');
        }
    }

    /**
     * Remove the player from the database
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
	    Player::findOrFail($id)->delete();
	    return redirect('/players');
    }

}