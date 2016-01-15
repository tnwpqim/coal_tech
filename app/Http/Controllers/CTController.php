<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class CTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   	public function index()
    {
        return view('ct_form');
    }

    
    public function post_form(Request $request)
    {
    	$validation_rules = [
    	'product_name' => 'required',
    	'quantity' => 'required|integer',
    	'price' => 'required|integer'
    	];
    	 
    	$this->validate($request, $validation_rules);
    	date_default_timezone_set('America/New_York'); 
    	$arr_new_info = array(
    			"product_name" => $request->product_name,
				"quantity" => $request->quantity,
    			"price" => $request->price,
    			"curr_time" => time()
    	);

		$bool_file_exists = Storage::exists('coal_tech.txt');
		if ($bool_file_exists)
		{
			$str_contents = Storage::get('coal_tech.txt');
			$obj_info = json_decode($str_contents);
			$arr_info = array();
			foreach($obj_info as $key=>$obj_item)
			{
				$arr_info[$key] = (array)$obj_item;
			} 
			$arr_info[] = $arr_new_info;
			foreach ($arr_info as &$item)
			{
				$item['date_formatted'] = date('l, jS \of F Y', $item['curr_time']);
				$item['time_formatted'] = date('h:i:s A', $item['curr_time']);
			}
				
			$json_info = json_encode($arr_info);
			Storage::put('coal_tech.txt', $json_info);				
			return $arr_info;
		}
		else 
		{
			$json_info = json_encode(array(0 => $arr_new_info));
			Storage::put('coal_tech.txt', $json_info);				
			$arr_info[] = $arr_new_info;
			foreach ($arr_info as &$item)
			{
				$item['date_formatted'] = date('l, jS \of F Y', $item['curr_time']);
				$item['time_formatted'] = date('h:i:s A', $item['curr_time']);
			}
			return $arr_info;
		}
    }
    
    function post_reset()
    {
    	Storage::delete('coal_tech.txt');
    	return json_encode('');
    }
	}
