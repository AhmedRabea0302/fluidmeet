<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacy;
use App\PharmacyImages;

class PharmacyController extends Controller
{
    public function getAddPharmacy() {
        return view('site.pages.pharmacy.addpharmacy');
    }

    public function postAddPharmacy(Request $request) {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'bio' => 'required',
            'lat' => 'required',
        ];

        $messages = [
            'name.required' => 'Please enter the Pharmacy name',
            'address.required' => 'Please enter the Pharmacy address',
            'phone1.required' => 'Please enter the first mobile number',
            'phone2.required' => 'Please enter the second mobile number',
            'bio.required' => 'Please enter the Bio',
            'lat.required' => 'Please Choose The Pharmacy Location on map',
        ];


        $request->validate($rules, $messages);

        $pharmacy = new Pharmacy();
        $pharmacyImages = new PharmacyImages();

        $pharmacy->name = $request->name;
        $pharmacy->address = $request->address;
        $pharmacy->lat = $request->lat;
        $pharmacy->lng = $request->lng;
        $pharmacy->phone1 = $request->phone1;
        $pharmacy->phone2 = $request->phone2;
        $pharmacy->bio = $request->bio;
        if($request->delivery == 'on') {
            $pharmacy->delivery = 1;
        } else {
            $pharmacy->delivery = 0;
        }

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
            // dd($images);
            foreach($images as $index=>$image) {
                $file_name   = time() . $index . '.' . $image->getClientOriginalExtension();
                $destination = 'storage/uploads/images/pharmacy_images';
                $image->move($destination, $file_name);

                PharmacyImages::create([
                    'pharmacy_id' => $pharmacy->id,
                    'image' => $file_name
                ]);
            }
        }

        return redirect()->route('home')->with('message', 'Pharmacy Added Successfully!');

    }

    public function getUpdatePharmacy(Request $request, $id){
        $pharmacy = Pharmacy::with('pharmImages')->find($id);
        return view('site.pages.pharmacy.update', ['pharmacy' => $pharmacy]);
    }

    public function postUpdatePharmacy(Request $request, $id) {
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


        $request->validate($rules, $messages);

        $pharmacy = Pharmacy::find($id);

        $pharmacy->name = $request->name;
        $pharmacy->address = $request->address;
        $pharmacy->lat = $request->lat;
        $pharmacy->lng = $request->lng;
        $pharmacy->phone1 = $request->phone1;
        $pharmacy->phone2 = $request->phone2;
        $pharmacy->bio = $request->bio;
        if($request->delivery == 'on') {
            $pharmacy->delivery = 1;
        } else {
            $pharmacy->delivery = 0;
        }

        $file = $request->file('image');
       
        if(!empty($file)) {
            unlink('storage/uploads/images/logos/' . '/' . $pharmacy->image);
            $file_name   = time() . '.' . $file->getClientOriginalExtension();
            $destination = 'storage/uploads/images/logos';
            $file->move($destination, $file_name);
            $pharmacy->image = $file_name;
        }

        $pharmacy->update();

        return redirect()->back()->with('message', 'Pharmacy Updated Successfully!');

    }

    public function deletePharmacy(Request $request) {
        $pharm = Pharmacy::find($request->id);
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

    }
}
