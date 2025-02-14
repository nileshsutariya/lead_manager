<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Email;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataController extends Controller
{
    public function data_view()
    {
        return view('data');
    }

    public function data_store(Request $request)
    {
        $request->validate([
            'name' => 'required_without_all:email,phone,company_name',
            'email' => 'required_without_all:name,phone,company_name',
            'phone' => 'required_without_all:name,email,company_name',
            'company_name' => 'required_without_all:name,email,phone',

            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            // 'company_name' => 'required',
            'designation' => 'required',
        ], [
            'name.required_without_all' => 'The name field is required',
            'email.required_without_all' => 'The email field is required',
            'phone.required_without_all' => 'The phone_no field is required',
            'company_name.required_without_all' => 'The company_name field is required',
        ]);

        $data = new Data();

        $data->name = $request->name ?? '';
        $data->phone_no = $request->phone ?? '';
        $data->email = $request->email ?? '';
        $data->address = $request->address;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->country = $request->country;
        $data->pincode = $request->pincode;
        $data->company_name = $request->company_name ?? '';
        $data->designation = $request->designation;

        $data->save();

        return redirect()->route('data.table');
    }

    public function data_table(Request $request)
    {
        $datas = Data::paginate(25);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('data_table', compact('datas'))->render(),
                'pagination' => (string) $datas->links()
            ]);
        }
        return view('data_table', compact('datas'));
    }
    public function data_edit(string $id)
    {
        $data = Data::findorfail($id);
        return view('data', compact('data'));
    }

    public function data_update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required_without_all:email,phone,company_name',
            'email' => 'required_without_all:name,phone,company_name',
            'phone' => 'required_without_all:name,email,company_name',
            'company_name' => 'required_without_all:name,email,phone',

            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            // 'company_name' => 'required',
            'designation' => 'required',
        ], [
            'name.required_without_all' => 'The name field is required',
            'email.required_without_all' => 'The email field is required',
            'phone.required_without_all' => 'The phone_no field is required',
            'company_name.required_without_all' => 'The company_name field is required',
        ]);

        $data = Data::findorfail($id);

        $data->name = $request->name ?? '';
        $data->phone_no = $request->phone ?? '';
        $data->email = $request->email ?? '';
        $data->address = $request->address;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->country = $request->country;
        $data->pincode = $request->pincode;
        $data->company_name = $request->company_name ?? '';
        $data->designation = $request->designation;

        $data->save();

        return redirect()->route('data.table');
    }

    public function data_destroy(string $id)
    {
        $data = Data::findOrFail($id);
        $data->delete();

        return redirect()->route('data.table');
    }

    public function mail()
    {
        return view('mail');
    }

    public function mail_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required'
        ]);

        $email = new Email();

        $email->name = $request->name;
        $email->message = $request->message;

        $file = $request->file('attachments');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('attachments', $fileName, 'public');

        $attachment = new Attachment();
        $attachment->name = $fileName;
        $attachment->path = $filePath;
        $attachment->save();

        $email->attachments_id = $attachment->id;

        $slug = Str::slug($request->name);
        $email->slug = url($slug);

        $email->status = $request->status ?? 0;

        $email->save();

        return redirect()->route('mail.table')->with('success', 'Email Stored successfully!');
    }

    public function mail_edit(string $id)
    {
        $email = Email::findorfail($id);
        return view('mail', compact('email'));
    }

    public function mail_update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required'
        ]);
    
        $email = Email::findOrFail($id);
        $email->name = $request->name;
        $email->message = $request->message;
        $email->status = $request->status ?? 0;
    
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('attachments', $fileName, 'public');
    
            $attachment = new Attachment();
            $attachment->name = $fileName;
            $attachment->path = $filePath;
            $attachment->save();
    
            $oldAttachment = $email->attachment;
            $email->attachments_id = $attachment->id;
            $email->save();
    
            if ($oldAttachment) {
                Storage::disk('public')->delete($oldAttachment->path);
                $oldAttachment->delete();
            }
        }
    
        $email->slug = url(Str::slug($request->name));
        $email->save();
    
        return redirect()->route('mail.table')->with('success', 'Email updated successfully!');
    }

    public function mail_table(Request $request)
    {
        $emails = Email::with('attachment')->paginate(25); 
    
        if ($request->ajax()) {
            return response()->json([
                'html' => view('mail_table', compact('emails'))->render(),
                'pagination' => (string) $emails->links('pagination::bootstrap-5')
            ]);
        }
    
        return view('mail_table', compact('emails'));
    }
    public function mail_destroy(string $id)
    {
        $email = Email::with('attachment')->findOrFail($id);
        $attachment = $email->attachment;

        $email->delete();

        if ($attachment) {
            Storage::disk('public')->delete($attachment->path);
            $attachment->delete();
        }
        
        $emails = Email::with('attachment')->get();

        return view('mail_table', compact('emails'));
    }

    public function sample_csv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'Phone_No',
                'Email',
                'Address',
                'Country',
                'State',
                'City',
                'PinCode',
                'Company_Name',
                'Designation'
            ]);

            $users = Data::all();

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->phone_no,
                    $user->email,
                    $user->address,
                    $user->country,
                    $user->state,
                    $user->city,
                    $user->pincode,
                    $user->company_name,
                    $user->designation
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function import_csv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        $Count = 0;

        foreach ($data as $index => $row) {
            if ($index === 0) continue;
            if (!empty($row[0]))
                Data::create([
                    'name' => $row[0],
                    'phone_no' => $row[1],
                    'email' => $row[2],
                    'address' => $row[3],
                    'country' => $row[4],
                    'state' => $row[5],
                    'city' => $row[6],
                    'pincode' => $row[7],
                    'company_name' => $row[8],
                    'designation' => $row[9],
                ]);
            $Count++;
        }

        return redirect()->back()->with('success', "{$Count} records imported successfully.");
    }
}
