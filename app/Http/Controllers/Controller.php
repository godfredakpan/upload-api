<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function uploadImage(Request $request)
    {
        try {

            $image = $request->image;
            $name = $request->name;
            $date = date('Y-m-dH:i:s');
            $path = public_path() . '/uploads/' . $name . '_' . $date;

            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
            } catch (\Exception $e) {
            }

            $image = str_replace('data:image/png;base64,', '', $image);

            $image = str_replace(' ', '+', $image);

            $imageName = $name.'.'.'png';

            \File::put($path. '/' . $imageName, base64_decode($image));

            $path = '/uploads/' . $name . '_' . $date . '/' . $imageName;

            return response()->json(['message' => 'Image uploaded successfully', 'status' => 'success', 'data' => $path]);

        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['message' => 'Image upload failed', 'status' => 'failed', 'data' => null]);
        }
    }

}
