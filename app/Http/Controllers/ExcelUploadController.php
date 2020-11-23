<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class ExcelUploadController extends Controller
{
    public function showForm()
    {
        return view('upload');
    }

    public function store(Request $request)
    {   
        //get file
        $upload=$request->file('upload-file');
        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');

        $header= fgetcsv($file);

        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            // $escapedItem=preg_replace('/[^a-z], _/', '', $lheader);
            // array_push($escapedHeader, $escapedItem);
            array_push($escapedHeader, $lheader);
        }
        // dd($escapedHeader);

        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data
            foreach ($columns as $key => &$value) {
                // dd($value);
                // $value=preg_replace('/\D/','',$value);
            }

           $data= array_combine($escapedHeader, $columns);

           // setting type
           foreach ($data as $key => &$value) {
            $value=($key=="point" || $key=="duration")?(integer)$value: (string)$value;
           }

           // Table update
           $questioncol=$data['question'];
           $is_general=$data['is_general'];
           $categories=$data['categories'];
           $point=$data['point'];
           $icon_url=$data['icon_url'];
           $duration=$data['duration'];
           $choice_1=$data['choice_1'];
           $is_correct_choice_1=$data['is_correct_choice_1'];
           $icon_url_1=$data['icon_url_1'];
           $choice_2=$data['choice_2'];
           $is_correct_choice_2=$data['is_correct_choice_2'];
           $icon_url_2=$data['icon_url_2'];
           $choice_3=$data['choice_3'];
           $is_correct_choice_3=$data['is_correct_choice_3'];
           $icon_url_3=$data['icon_url_3'];
           $choice_4=$data['choice_4'];
           $is_correct_choice_4=$data['is_correct_choice_4'];
           $icon_url_4=$data['icon_url_4'];

           $question = new Question();
           $question->question = $questioncol;
           $question->is_general = $is_general;
           $question->categories = $categories;
           $question->point = $point;
           $question->icon_url = $icon_url;
           $question->duration = $duration;
           $question->choice_1 = $choice_1;
           $question->is_correct_choice_1 = $is_correct_choice_1;
           $question->icon_url_1 = $icon_url_1;
           $question->choice_2 = $choice_2;
           $question->is_correct_choice_2 = $is_correct_choice_2;
           $question->icon_url_2 = $icon_url_2;
           $question->choice_3 = $choice_3;
           $question->is_correct_choice_3 = $is_correct_choice_3;
           $question->icon_url_3 = $icon_url_3;
           $question->choice_4 = $choice_4;
           $question->is_correct_choice_4 = $is_correct_choice_4;
           $question->icon_url_4 = $icon_url_4;
        //    dd($question);
           $question->save();
           return view('welcome');  
        }
        
    }
}