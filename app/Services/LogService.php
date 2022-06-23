<?php


namespace App\Services;

use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LogService
{
    public function __construct(LogRepository $log)
    {
        $this->log = $log;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->log->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 10000)
    {
        return $this->log->paginate($limit, Auth::user()->customer_id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->log->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $log = $this->log->create($request->all());

        return $log;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $log = $this->log->update($id, $request->all());

        return $log;
    }



    public function show(Int $id)
    {

        $log =  $this->log->find($id);

        return ($log) ? $log : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->log->delete($id);
    }

    public function edit($id)
    {
        return $this->log->find($id);
    }

    public function monitoringBoarding($device)
    {
        return $this->log->monitoringBoarding($device);
    }

    public function saveLog($user, $mensagem)
    {
        return $this->log->saveLog($user,  $mensagem);
    }
}
