<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::orderBy('id', 'asc')->get();
        $response = [
            'status' => 'success',
            'message' => 'Ditemukan '.count($contacts).' kontak',
            'contacts' => $contacts
        ];
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:contacts',
            'telephone_number' => 'required|min:11'
        ];
        $messages = [
            'name.required' => 'Tolong sertakan nama kontak',
            'email.required' => 'Tolong sertakan email kontak',
            'email.unique' => 'Maaf email telah digunakan',
            'telephone_number.required' => 'Tolong sertakan nomor kontak',
            'telephone_number.min' => 'Tolong tuliskan setidaknya 11 digit angka',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Permintaan tidak dapat diproses',
                'errors' => $validator->errors()
            ], 400);
        }

        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->telephone_number = $request->telephone_number;
        $contact->save();

        $is_saved = Contact::where('name', '=', $request->name)
                            ->where('email', '=', $request->email)
                            ->latest()
                            ->get();
        if (empty($is_saved)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Kontak gagal ditambahkan'
            ], 500);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Kontak dengan nama '.$request->name.' berhasil ditambahkan'
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $response = [
                'status' => 'success',
                'message' => 'Kontak ditemukan',
                'contact' => $contact
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Kontak tidak ditemukan',
            ];
            return response()->json($response, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::find($id);
        if (empty($contact)) {
            $response = [
                'status' => 'fail',
                'message' => 'Kontak tidak ditemukan',
            ];
            return response()->json($response, 404);
        }

        $rules_email = ($contact->email === $request->email)? 'required': 'required|unique:contacts';
        $rules = [
            'name' => 'required',
            'email' => $rules_email,
            'telephone_number' => 'required|min:11'
        ];
        $messages = [
            'name.required' => 'Tolong sertakan nama kontak',
            'email.required' => 'Tolong sertakan email kontak',
            'email.unique' => 'Maaf email telah digunakan',
            'telephone_number.required' => 'Tolong sertakan nomor kontak',
            'telephone_number.min' => 'Tolong tuliskan setidaknya 11 digit angka',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Permintaan tidak dapat diproses',
                'errors' => $validator->errors()
            ], 400);
        }

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->telephone_number = $request->telephone_number;
        $contact->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Kontak berhasil diperbarui',
            'contact' => $contact
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        if (empty($contact)) {
            $response = [
                'status' => 'fail',
                'message' => 'Kontak tidak ditemukan',
            ];
            return response()->json($response, 404);
        }

        $contact->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kontak berhasil dihapus',
        ], 200);
    }
}
