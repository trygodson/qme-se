<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Models\DrugPrescription;
use App\Http\Controllers\Controller;
use App\Models\DrugprescriptionItem;
use App\Interfaces\IDrugprescriptionItemRepository;
use App\Http\Requests\DrugRequest\CreatePrescriptionRequest;

class DrugprescriptionItemController extends Controller
{
    private $drugprescriptionItemRepository;

    public function __construct(IDrugprescriptionItemRepository $drugprescriptionItemRepository) {
        $this->drugprescriptionItemRepository = $drugprescriptionItemRepository;
    }

    // private $drug_prescription;
    // private $drug_prescription_item;   
    
    // public function __construct(IDrugPrescriptionRepository $drug_prescription,IDrugPrescriptionItemRepository $drug_prescription_item)
    // {
    //     $this->drug_prescription = $drug_prescription;
    //     $this->drug_prescription_item = $drug_prescription_item;
    // }


    /**
     * @OA\Post  (
     *     path="/api/v1/drug/prescribe",
     *     tags={"Drug Prescription"},
     *     summary="doctor creates prescription",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreatePrescriptionRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

    public function store(CreatePrescriptionRequest $request){
      
        $drug_prescription = new DrugPrescription;

        $drug_prescription->total = $request->total;
        $drug_prescription->appointment_id = $request->appointment_id;

        $prescription = $drug_prescription->save();

        
        foreach($request->drugs as $drug){
            $data=[
                'name'=> $drug["name"],
                'dosage_description'=>$drug["dosage_description"],
                'amount'=>$drug["amount"]
            ];
            $drug_prescription->prescriptionitems()->create($data);
        }


        // $prescription = DrugPrescription::where('appointment_id', $request->appointment_id)->get();
        // $drug_prescription_id = $request->drug_prescription_id;

        // $prescription_item = new DrugprescriptionItem;

        // $prescription_item->drug_prescription_id = $drug_prescription_id;
        // $prescription_item->name = $request->name;
        // $prescription_item->dosage_description = $request->dosage_description;
        // $prescription_item->amount = $request->amount;

        // $prescription_item->save();

        // $prescription = $this->drug_prescription->add($prescription_data);
        // $prescription_item = $this->drug_prescription_item = $drug_prescription_item->add($prescription_data);




        return response()->json($drug_prescription, 200); 
    }

    /**
     * @OA\Get  (
     *     path="/api/v1/drug-prescription/byprescriptionid",
     *     tags={"Drug Prescription"},
     *     summary="doctor creates prescription",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreatePrescriptionRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getByPrescriptionId()
    {
        $drugprescription = $this->drugprescriptionItemRepository->getByPrescriptionId();
        return response()->json($drugprescription, 200);
    }


     /**
     * @OA\Post  (
     *     path="/api/v1/drug/prescription-item/delete/{id}",
     *     tags={"Drug Prescription"},
     *     summary="delete prescription id",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreatePrescriptionRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function delete($id)
    {
        $drugprescription = $this->drugprescriptionItemRepository->delete($id);
        return response()->json($drugprescription, 200);
    }
}
