<?php


namespace App\Services;

use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ContactService
{
    public function __construct(ContactRepository $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->contact->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->contact->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $dados = $request->all();

        return $this->contact->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        
        $contact = $this->contact->create($request->all());

        return $contact;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        
        $contact = $this->contact->update($id, $request->all());        
        return $contact;
    
    }

    public function show(Int $id)
    {

        $contact =  $this->contact->find($id);

        return ($contact) ? $contact : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->contact->delete($id);
    }

    public function edit($id)
    {
        return $this->contact->find($id);
    }
}
