<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Email;
use App\Models\Category;
use App\Models\Attachment;
use App\Models\Mail_Queue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company_Detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataController extends Controller
{
    public function data_view()
    {
        $companies = Company_Detail::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        return view('data', compact('companies', 'categories'));
    }

    public function data_store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required_without_all:email,phone,company_name',
            'email' => 'required_without_all:name,phone,company_name',
            'phone' => 'required_without_all:name,email,company_name',
            'company_name' => 'required_without_all:name,email,phone',
        ], [
            'name.required_without_all' => 'name is required',
            'email.required_without_all' => 'email is required',
            'phone.required_without_all' => 'Phone_no is required.',
            'company_name.required_without_all' => 'Company_name is required.',
        ]);

        $data = new Data();

        $data->name = $request->name;
        $data->phone_no = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->country = $request->country;
        $data->pincode = $request->pincode;
        $data->company_name = $request->company_name;
        $data->reference = $request->reference;
        $data->company_type = $request->company_type;
        $data->categories = json_encode(array_map('intval', $request->category ?? []));
        $data->status = $request->status ?? 0;

        // dd($data);
        $data->save();

        return redirect()->route('data.table')->with('primary', 'Contact details saved successfully!');
    }

    public function data_table(Request $request)
    {
        $datas = Data::paginate(25);

        foreach ($datas as $data) {
            $categoryIds = json_decode($data->categories, true);
            $data->category_names = Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
        }

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
        $data = Data::find($id);
        if (!$data) {
            return redirect()->back()->with('error', 'DATA NOT FOUND');;
        }
        $companies = Company_Detail::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        return view('data', compact('data', 'companies', 'categories'));
    }

    public function data_update(Request $request, string $id)
    {
        // dd($id);
        // dd($request->all());
        $request->validate([
            'name' => 'required_without_all:email,phone,company_name',
            'email' => 'required_without_all:name,phone,company_name',
            'phone' => 'required_without_all:name,email,company_name',
            'company_name' => 'required_without_all:name,email,phone',
        ], [
            'name.required_without_all' => 'name is required',
            'email.required_without_all' => 'email is required',
            'phone.required_without_all' => 'Phone_no is required.',
            'company_name.required_without_all' => 'Company_name is required.',
        ]);

        $data = Data::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'DATA NOT FOUND');;
        }

        $data->name = $request->name;
        $data->phone_no = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->country = $request->country;
        $data->pincode = $request->pincode;
        $data->company_name = $request->company_name;
        $data->reference = $request->reference;
        $data->company_type = $request->company_type;
        $data->categories = json_encode(array_map('intval', $request->category ?? []));
        $data->status = $request->status ?? 0;
        $data->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully',
                'data' => $data
            ]);
        }

        return redirect()->route('data.table')->with('success', 'Contact details Updated successfully!');
    }

    public function data_destroy(string $id)
    {
        $data = Data::find($id);
        if (!$data) {
            return redirect()->back()->with('error', 'DATA NOT FOUND');;
        }

        // Mail_Queue::where('user_id', $id)->delete();

        $data->delete();

        return redirect()->route('data.table');
    }

    public function mail()
    {
        $category = Category::pluck('name', 'id');
        return view('mail', compact('category'));
    }

    public function mail_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required',
            'category' => 'required'
        ]);

        $email = new Email();

        $email->name = $request->name;
        $email->message = $request->message;

        $file = $request->file('attachments');
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('attachments', $fileName, 'public');

            $attachment = new Attachment();
            $attachment->name = $fileName;
            $attachment->path = $filePath;
            $attachment->save();

            $email->attachments_id = $attachment->id;
        }

        $slug = Str::slug($request->name);
        $email->slug = url($slug);
        $email->category_id = $request->category;
        $email->status = $request->status ?? 0;

        $email->save();

        return redirect()->route('mail.table')->with('success', 'Email Stored successfully!');
    }

    public function mail_edit(string $id)
    {
        $category = Category::pluck('name', 'id');
        $email = Email::find($id);
        if (!$email) {
            return redirect()->back()->with('error', 'EMAIL NOT FOUND');;
        }
        return view('mail', compact('email', 'category'));
    }

    public function mail_update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required'
        ]);

        $email = Email::find($id);
        if (!$email) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        $email->name = $request->name;
        $email->message = $request->message;
        $email->category_id = $request->category;
        $email->status = $request->status ?? 0;

        $file = $request->file('attachments');

        if ($file) {
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
        $email = Email::with('attachment')->find($id);
        $attachment = $email->attachment;
        
        $email->delete();
        
        if ($attachment) {
            Storage::disk('public')->delete($attachment->path);
            $attachment->delete();
        }
        
          $emails = Email::with('attachment')->paginate(25);
      

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

    public function category()
    {
        $mail_template = Email::pluck('name', 'id');
        $categories = Category::Leftjoin('emails','emails.id','=','categories.mail_templet')
        ->select('categories.*','emails.name as mail_templet')->get();
        // dd($categories);
        return view('category', compact('mail_template', 'categories'));
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Category();

        $category->name = $request->name;
        $category->mail_templet = $request->mail_templet;

        $category->save();

        return redirect()->back();
    }

    public function mail_create()
    {
        $emails = Email::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $companies = Company_Detail::pluck('name', 'id');
        // dd($companies);

        $mail_queues = Mail_Queue::where('is_sent', 1)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('mail_create', compact('companies', 'categories', 'emails', 'mail_queues'));
    }

    public function create_mail_store(Request $request)
    {
        $request->validate([
            'search_user' => 'required',
            'mail_template' => 'required'
        ]);

        $attachmentIds = [];

        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('attachments', $fileName, 'public');

                $attachment = Attachment::create([
                    'name' => $fileName,
                    'path' => $filePath,
                ]);

                $attachmentIds[] = $attachment->id;
            }
        }

        if ($request->email != null) {
            $mail_send = new Mail_Queue();
            $mail_send->users_email = $request->email;
            $mail_send->mail_body = $request->mail_message;
            $mail_send->subject = $request->mail_subject;
            $mail_send->country = $request->country;
            $mail_send->attachment_ids = json_encode($attachmentIds);
            $mail_send->is_sent = 0;
            $mail_send->mail_sent_at = now()->setTimezone('Asia/Kolkata');
            $mail_send->save();
        }
        return redirect()->back();
    }

    public function get_reference(Request $request)
    {
        $userId = $request->input('user_id');
        $user = Data::find($userId);

        if ($user) {
            $reference = $user->reference;
            return response()->json([
                'success' => true,
                'reference' => $reference,
            ]);
        }
    }

    public function company_type()
    {
        $companies = Company_Detail::all();
        return view('company_type', compact('companies'));
    }

    public function store_company(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $company = new Company_Detail();

        $company->name = $request->name;
        $company->save();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $users = Data::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone_no', 'like', "%$query%")
            ->orWhere('company_name', 'like', "%$query%")
            ->get()
            ->map(function ($user) {
                $categoryIds = json_decode($user->categories, true) ?? [];

                $categoryNames = DB::table('categories')
                    ->whereIn('id', $categoryIds)
                    ->pluck('name');

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_no' => $user->phone_no,
                    'company_name' => $user->company_name,
                    'country' => $user->country,
                    'state' => $user->state,
                    'city' => $user->city,
                    'pincode' => $user->pincode,
                    'address' => $user->address,
                    'reference' => $user->reference,
                    'company_type' => $user->company_type,
                    'categories' => $categoryNames,
                ];
            });

        return response()->json($users);
    }

    public function show(Request $request)
    {
        $template = email::find($request->id);
        return response()->json([
            'message' => $template->message ?? ''
        ]);
    }

    public function mailHistory(Request $request)
    {
        $mail_queues = Mail_Queue::where('is_sent', 1)
            ->where('users_email', $request->email)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $emails = $mail_queues->map(function ($mail) {
            return [
                'subject' => $mail->subject,
                'mail_body' => $mail->mail_body,
                'mail_sent_at' => $mail->mail_sent_at ? $mail->mail_sent_at->format('d-m-y h:i:s A') : null,
            ];
        });

        return response()->json([
            'email' => $emails,
        ]);
    }

    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('mail.create');
        } 
        else {
            return redirect()->back()->withErrors(['password' => 'Invalid phone number or password']);
        }
        return redirect()->route('login.view')->withErrors(['email' => 'Invalid phone number or password']);
    }

    public function logout(Request $request)
    {

        // dd($request->all());
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } 


        return redirect()->route('login.view');
    }
}
