<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Services;
use Illuminate\Http\Request;


use App\Repositories\BoardingRepository;

class BoardingService
{

    /**
     * UserService constructor.
     * @param BoardingRepository $boarding
     */
    public function __construct(BoardingRepository $boarding)
    {
        $this->boarding = $boarding;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
       
        $boarding = $this->boarding->create($request->all());
        return $boarding;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        
        $boarding = $this->boarding->update($id, $request->all());        
        return $boarding;
    
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->boarding->paginate($limit);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->boarding->delete($id);
    }

}