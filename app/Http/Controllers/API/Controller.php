<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $model;
    protected $orderBy;
    protected $with;

    public function index()
    {
        $query = new $this->model();
        if(isset($this->orderBy)){
            $query = $query->orderBy($this->orderBy[0], $this->orderBy[1]);
        }
        if(isset($this->with)){
            $query = $query->with($this->with);
        }
        $datas = $query->get();
        return response()->json($datas, 200);
    }

    public function show(string $id)
    {
        $query = new $this->model();
        if(isset($this->with)){
            $query = $query->with($this->with);
        }
        $data = $query->findOrFail($id);
        return response()->json($data, 200);
    }

    public function destroy(string $id)
    {
        $this->model::destroy($id);
        
        return response()->json([
            "message" => "success"
        ], 200);
    }
}
