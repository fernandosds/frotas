<?php


namespace App\Services\Fleets;

use Illuminate\Http\Request;
use App\Repositories\Fleets\CarRepository;
use App\Repositories\Fleets\CardCarRepository;


class CarService
{
    protected $cardCarRepository;
    protected $car;

    public function __construct(CarRepository $car, CardCarRepository $cardCarRepository)
    {
        $this->car = $car;
        $this->cardCarRepository = $cardCarRepository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->car->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->car->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $car = $request->all();

        return $this->car->create($car)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $car = $this->car->create($request->all());

        return $car;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $car = $this->car->update($id, $request->all());
        return $car;
    }

    /**
     * @param Int $id
     * @return \Illuminate\Support\Collection|void
     */
    public function show(Int $id)
    {

        $car =  $this->car->show($id);

        return ($car) ? $car : abort(404);
    }


    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->car->delete($id);
    }

    /**
     * @param $card_id
     * @return mixed
     */
    public function getAvailableCars($card_id = null)
    {
        $used_cars = $this->cardCarRepository->usedCars($card_id);
        $used = [];
        foreach ($used_cars as $us) {
            $used[] = $us->car_id;
        }
        return $this->car->getAvailableCars($used);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->car->find($id);
    }
}
