<?php

namespace App\Http\Api;


use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category as CategoryR;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getList()
    {
        $data = new CategoryCollection(Category::where('status', 1)->get());
        $response = $this->responseJson($data);
        return $response;
    }

    public function getInfo(Request $request)
    {
        // $id = $request->id;
        // $data = new CategoryR(Category::find($id));
        // $response = $this->responseJson($data);
        // return $response;
    }


}