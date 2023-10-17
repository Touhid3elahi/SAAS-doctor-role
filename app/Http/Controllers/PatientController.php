<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentRequest;

class PatientController extends Controller
{
    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $patient = $request->user();

        return response()->json([
            'name' => $patient->name,
            'condition' => $patient->condition,
        ]);
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAppointmentRequest(Request $request)
    {
        $patient = $request->user();
        $request->validate([
            'doctor_id' => 'required|integer',
            'requested_date_time' => 'required|date',
        ]);

        $appointmentRequest = new AppointmentRequest();
        $appointmentRequest->patient_id = $patient->id;
        $appointmentRequest->doctor_id = $request->input('doctor_id');
        $appointmentRequest->requested_date_time = $request->input('requested_date_time');
        $appointmentRequest->save();

        return response()->json(['message' => 'Appointment request created'], 201);
    }


}
