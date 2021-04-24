<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacy;
use App\PharmacyImages;
use Validator;
class PharmacyController extends Controller
{
    public function getAllPharms() {
        $pharms = Pharmacy::with('pharmImages')->orderBy('created_at', 'DES')->get();
        if(count($pharms)) {
            foreach($pharms as $pharm) {
                $pharm['logo_url'] = url('storage/uploads/images/logos') . '/' . $pharm->image;
            }
            
            return response()->json($pharms);
        } else {
            return response()->json('No Added Pharmacies Yet!');
        }
        
    }

    public function addPharmacy(Request $request) {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'bio' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'image' => 'required',
            'images' => 'required',
            'delivery' => 'required'
        ];

        $messages = [
            'name.required' => 'Please enter the Pharmacy name',
            'address.required' => 'Please enter the Pharmacy address',
            'phone1.required' => 'Please enter the first mobile number',
            'phone2.required' => 'Please enter the second mobile number',
            'bio.required' => 'Please enter the Bio',
            'lat.required' => 'Please Choose The Pharmacy Location Lat',
            'lat.required' => 'Please Choose The Pharmacy Location Lang',
            'image.required' => 'Please Upload Pharmacy Logo',
            'images.required' => 'Please Upload Pharmacy Images',
            'delivery.required' => 'Please Provide Delivery State',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return response()->json(['message' => $validator->customMessages]);
        }

        $pharmacy = new Pharmacy();
        $pharmacyImages = new PharmacyImages();

        $pharmacy->name = $request->name;
        $pharmacy->address = $request->address;
        $pharmacy->lat = $request->lat;
        $pharmacy->lng = $request->lng;
        $pharmacy->phone1 = $request->phone1;
        $pharmacy->phone2 = $request->phone2;
        $pharmacy->bio = $request->bio;
        $pharmacy->delivery = $request->delivery;
    
        $file = $request->file('image');
       
        if(!empty($file)) {
            $file_name   = time() . '.' . $file->getClientOriginalExtension();
            $destination = 'storage/uploads/images/logos';
            $file->move($destination, $file_name);
            $pharmacy->image = $file_name;
        }

        $pharmacy->save();

        if ($request->hasfile('images')) {
            $images = $request->file('images');
            foreach($images as $image) {
                $file_name   = time() . '.' . $image->getClientOriginalExtension();
                $destination = 'storage/uploads/images/pharmacy_images';
                $image->move($destination, $file_name);

                $pharmacyImages->create([
                    'pharmacy_id' => $pharmacy->id,
                    'image' => $file_name
                ]);
            }
        }

        return response()->json(['code' => 200, 'message' => 'Pharmacy Added Successfully!', 'data' => $pharmacy->id]);

    }

    public function updatePharmacy(Request $request) {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'bio' => 'required',
        ];

        $messages = [
            'name.required' => 'Please enter the Pharmacy name',
            'address.required' => 'Please enter the Pharmacy address',
            'phone1.required' => 'Please enter the first mobile number',
            'phone2.required' => 'Please enter the second mobile number',
            'bio.required' => 'Please enter the Bio',
        ];

        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'bio' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'delivery' => 'required'
        ];

        $messages = [
            'name.required' => 'Please enter the Pharmacy name',
            'address.required' => 'Please enter the Pharmacy address',
            'phone1.required' => 'Please enter the first mobile number',
            'phone2.required' => 'Please enter the second mobile number',
            'bio.required' => 'Please enter the Bio',
            'lat.required' => 'Please Choose The Pharmacy Location Lat',
            'lat.required' => 'Please Choose The Pharmacy Location Lang',
            'delivery.required' => 'Please Provide Delivery State',
        ];


        $request->validate($rules, $messages);

        $pharmacy = Pharmacy::find($request->pharm_id);

        if($pharmacy) {
            $pharmacy->name = $request->name;
            $pharmacy->address = $request->address;
            $pharmacy->lat = $request->lat;
            $pharmacy->lng = $request->lng;
            $pharmacy->phone1 = $request->phone1;
            $pharmacy->phone2 = $request->phone2;
            $pharmacy->bio = $request->bio;
            $pharmacy->delivery = $request->delivery;


            $file = $request->file('image');
        
            if(!empty($file)) {
                unlink('storage/uploads/images/logos/' . '/' . $pharmacy->image);
                $file_name   = time() . '.' . $file->getClientOriginalExtension();
                $destination = 'storage/uploads/images/logos';
                $file->move($destination, $file_name);
                $pharmacy->image = $file_name;
            }

            $pharmacy->update();

            return response()->json(['code' => 200, 'message' => 'Pharmacy Updated Successfully!', 'data' => $pharmacy->id]);

        } else {
            return response()->json('No Pharmacy with this ID!');
        }
    }

    public function deletePharmacy(Request $request, $id) {
        $pharm = Pharmacy::find($id);
        if($pharm) {
            $pharmImages = $pharm->pharmImages;
            foreach($pharmImages as $img) {
                $img->delete();
                try {
                    unlink('storage/uploads/images/pharmacy_images/' . $img->image);
                } catch(Exception $e) {
                    echo $e;
                }
            }
    
            if($pharm->image) {
                try {
                    unlink('storage/uploads/images/logos/' . $pharm->image);
                } catch(Exception $e) {
                    echo $e;
                }
            }
    
            $pharm->delete();
            return response()->json(['Message' => 'Deleted Successfully!', 'code' => '200']);
        } else {
            return response()->json('Nothing Found with this ID!');
        }

    }

}
