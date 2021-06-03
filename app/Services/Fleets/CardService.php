<?php


namespace App\Services\Fleets;

use App\Repositories\Fleets\CardCarRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Fleets\CardRepository;


class CardService
{

    protected $cardCarRepository;
    protected $card;

    public function __construct(CardRepository $card, CardCarRepository $cardCarRepository)
    {
        $this->cardCarRepository = $cardCarRepository;
        $this->card = $card;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->card->all();
    }

    /**
     * @return mixed
     */
    public function getCardDriverAvailable()
    {
        return $this->card->getCardDriverAvailable();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->card->paginate($limit, Auth::user()->customer_id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $card = $request->all();
        return $this->card->create($card)->orderBy('id')->get();
    }

    /**
     * @param Int $car_id
     * @return mixed
     */
    public function getAvailableCards(Int $car_id)
    {
        $used_cards = $this->cardCarRepository->usedCards($car_id);
        $used = [];
        foreach ($used_cards as $us) {
            $used[] = $us->card_id;
        }

        return $this->card->getAvailableCards($used);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $card = $this->card->create($request->all());
        return $card;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $card = $this->card->update($id, $request->all());
        return $card;
    }

    /**
     * @param Int $id
     * @return \Illuminate\Support\Collection|void
     */
    public function show(Int $id)
    {
        $card =  $this->card->show($id);
        return ($card) ? $card : abort(404);
    }


    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {
        return $this->card->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->card->find($id);
    }
}
