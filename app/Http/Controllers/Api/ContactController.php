<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Contact;
use Illuminate\Http\Request;
use App\Repositories\Contact\ContactInterface;
use App\Http\Resources\ContactResource;
use Facade\FlareClient\Http\Response;
use App\Http\Requests\ContactRequest;
use App\Mail\MailContact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    protected $contactRepository;
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository=$contactRepository;
    }
    public function index(Request $request)
    {
        $data=$request->all();
        if($data){
            $contactResource=$this->contactRepository->getAllPaginate($data);
            if($contactResource)
                return ContactResource::collection($contactResource);
            return response()->json(["error","Contact not found",404]);

        }
        return response()->json(["error","Contact data not found",404]);
    }
    public function getListOnlyTrash(Request $request){

        $data=$request->all();
        if($data){
            $contactResource=$this->contactRepository->getAllTrash($data);
            if($contactResource)
                return ContactResource::collection($contactResource);
            return response()->json(["error","Contact not found",404]);

        }
        return response()->json(["error","Contact data not found",404]);
    }
    public function update(Request $request,$unique_id){
        $data=$request->all();
        if($data){
            $contactResource=$this->contactRepository->update($data,$unique_id);
            if($contactResource)
                return new ContactResource($contactResource);
            return response()->json(["error"=>"Contact not found"],404);
        }
        return response()->json(["error"=>"Contact data not found"],404);
    }
   
    public function destroy($unique_id)
    {
        $result=$this->contactRepository->delete($unique_id);
        if(!$result)
            return response()->json(["error","Contact not found"],404);
        return response()->json(null,204);
    }
    public function restore($unique_id){
        $result=$this->contactRepository->restore($unique_id);
        if(!$result)
            return response()->json(["error","Contact not found"],404);
        return response()->json(null,204);

    }
    public function store(ContactRequest $request){
        $data=$request->validated();
        if($data){
            $data['unique_id']=$this->contactRepository->generateUniqueId();
            $contactResource=$this->contactRepository->create($data);
            if($contactResource){
                Mail::to('mt240399@gmail.com')->send(new MailContact($contactResource));
                return new ContactResource($contactResource);

            }
            return response()->json(["error","Contact not found"],404);
        }
        return response()->json(["error","Contact data not found"],404);

    }

}
