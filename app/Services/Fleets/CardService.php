<?php


namespace App\Services\Fleets;
use Illuminate\Http\Request;
use App\Repositories\Fleets\CardRepository;


class CardService
{
    public function __construct(CardRepository $card)
    {
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
    public function addCardDriver()
    {
        return $this->card->addCardDriver();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->card->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $card = $request->all();

        return $this->card->create($card)->orderBy('id')->get();
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
