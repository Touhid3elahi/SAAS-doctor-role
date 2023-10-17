<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $doctor = $request->user();
        return response()->json([
            'name' => $doctor->name,
            'specialty' => $doctor->specialty,

        ]);
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAppointment(Request $request)
    {
        $doctor = $request->user();
        $request->validate([
            'patient_id' => 'required|integer',
            'appointment_date_time' => 'required|date',
        ]);

        // Your logic to create the appointment goes here
        $appointment = new Appointment();
        $appointment->doctor_id = $doctor->id;
        $appointment->patient_id = $request->input('patient_id');
        $appointment->appointment_date_time = $request->input('appointment_date_time');
        $appointment->save();

        return response()->json(['message' => 'Appointment created'], 201);
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $doctor = $request->user();

        $request->validate([
            'name' => 'required|string',
            'specialty' => 'required|string',
        ]);

        $doctor->name = $request->input('name');
        $doctor->specialty = $request->input('specialty');



        $doctor->save();

        return response()->json(['message' => 'Profile updated'], 200);
    }

    /**
     * Delete a patient appointment.
     *
     * @param Request $request
     * @param int $appointmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAppointment(Request $request, $appointmentId)
    {
        // Find the appointment and perform deletion logic
        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        // Ensure that the appointment belongs to the authenticated doctor
        if ($appointment->doctor_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted'], 200);
    }

    /**
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAppointments(Request $request)
    {
        $doctor = $request->user(); // Retrieve the authenticated doctor user
        // Fetch and return a list of the doctor's appointments
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        return response()->json(['appointments' => $appointments], 200);
    }
}
