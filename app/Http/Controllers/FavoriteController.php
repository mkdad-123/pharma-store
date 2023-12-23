<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function storeMedicine($id)
    {
        $favorite_medicine = new Favorite();
        $favorite_medicine['medicine_id'] = $id;
        $favorite_medicine['pharmacist_id'] = auth()->guard('pharmacist')->id();
        $favorite_medicine->save();

        return response()->json([
            'status' => 200,
            'message' => 'The medicine has been added to your favorites list',
            'data'=> [],
        ]);

    }

    public function storeWarehouse($id)
    {
        $favorite_medicine = new Favorite();
        $favorite_medicine['warehouse_id'] = $id;
        $favorite_medicine['pharmacist_id'] = auth()->guard('pharmacist')->id();
        $favorite_medicine->save();

        return response()->json([
            'status' => 200,
            'message' => 'The warehouse has been added to your favorites list',
            'data'=> [],
        ]);
    }

    public function showMedicine()
    {
        $favorites = Favorite::favoriteMedicines()
            ->with('medicine')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $favorites,
        ]);
    }

    public function showWarehouse()
    {

        $favorites = Favorite::favoriteWarehouse()
            ->with('warehouse')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $favorites,
        ]);
    }

    public function getTopFavoriteMedicines()
    {
        $topMedicines = Favorite::select('medicine_id', DB::raw('COUNT(*) as favorites_count'))
            ->groupBy('medicine_id')
            ->orderByDesc('favorites_count')
            ->with('medicine:id,commercial_name')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => '',
            'data'=> $topMedicines,
        ]);
    }

}
