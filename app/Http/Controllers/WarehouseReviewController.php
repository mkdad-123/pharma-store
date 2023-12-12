<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseReviewRequest;
use App\Http\Resources\WarehouseReviewResource;
use App\Models\WarehouseReview;
use Mockery\Exception;

class WarehouseReviewController extends Controller
{
    public function store(WarehouseReviewRequest $request)
    {
        $data = $request->all();
        $data['pharmacist_id'] = auth()->guard('pharmacist')->id();
        $reviews = WarehouseReview::create($data);

        return response()->json([
            'status' => 201,
            'data' => $reviews
        ]);
    }

    public function showWarehouseRates($id)
    {
        try {
            $reviews = WarehouseReview::whereWarehouseId($id);

            $rateTotal = round($reviews->sum('rate')/$reviews->count(),1);

            return response()->json([
                'status' => 200,
                'total_rate' => $rateTotal,
                'data' => WarehouseReviewResource::collection($reviews->get())
            ]);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }

    }
}
