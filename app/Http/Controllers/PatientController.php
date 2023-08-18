<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientController extends Controller
{
   public function GetAllStates(){
    $states=DB::table('provinces')->get();
    return $states;
   }

   public function ajaxGetDistrictsFromStateId(Request $request){
      //return json_encode($request->post());
    $districts=DB::table('districts')->where('province_id','=',$request->provinceId)->get();
    return $districts;
   }

   public function ajaxGetMunicipalIdFromDistrictId(Request $request){
    $municipals=DB::table('municipals')->where('disrtict_id','==',$request->districtId)->get();
    return $municipals;
   }

   public function insertUpdatePatient(Request $request){

    $request->validate([
        'full_name'=>'required',
        'mobile_number'=>'required',
        'age'=>'required',
        'dob'=>'required',
        'state_id'=>'required',
        'district_id'=>'required',
        'vdc_id'=>'required'
    ]);
        $dob=Carbon::parse($request->input('dob'))->format('Y-m-d H:i:s');

    if($request->input('id') != 0){
            $register=  Patient::find($request->input('id'));
            $register->{'full-name'}= $request->input('full_ame');
            $register->{'mobile-number'}=$request->input('mobile_number');
            $register->age=$request->input('age');
            $register->dob=$dob;
            $register->state_id=$request->input('state_id');
            $register->district_id=$request->input('district_id');
            $register->vdc_id=$request->input('vdc_id');
            $register->save();

    }else{

            $register= new Patient();
            $register->{'full-name'}= $request->input('full_name');
            $register->{'mobile-number'}=$request->input('mobile_number');
            $register->age=$request->input('age');
            $register->dob=$dob;
            $register->state_id=$request->input('state_id');
            $register->district_id=$request->input('district_id');
            $register->vdc_id=$request->input('vdc_id');
            $register->save();
    }
    return $register;

   }

}
