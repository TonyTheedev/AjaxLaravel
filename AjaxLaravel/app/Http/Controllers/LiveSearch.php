<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearch extends Controller
{
    function index()
    {
		////$test = DB::table('personetest')->get();
		return view('live_search'
		    //,compact('test')
		    );

		//$html_output='';
		//$requete = $request->get('query');
		//if($request != ''){
		//return view('live_search',compact('dataa'));

		//$html_output='';
		//$dataa = DB::table('personetest')
		//         ->select('personetest.nom_personne')
		//         ->Where('nom_personne', 'like', '%hi%')
		//         ->value('nom_personne');

		//if($dataa != null)
		//{
		//    $html_output .= '<strong>'.$dataa.'</strong>';
		//    //$html_output = 'existe !';
		//}
		//else
		//{
		//    $html_output .= 'Pas de donnée disponible';
		//}

		//$dataaa = array(
		//    'LesDonnee'=> $html_output
		//    );
		////echo json_encode($dataa);
		//return view('live_search',compact('dataaa'));
    }

	function actionn(Request $request){
		if($request->ajax()){
			$html_output='';
			$requete = $request->get('query');
			$dataa = DB::table('personetest')
			     ->select('personetest.nom_personne')
		         ->Where('nom_personne', 'like', '%'.$requete.'%')
		         ->value('nom_personne');

			if($dataa != null)
				$html_output .= '<strong>'.$dataa.'</strong>';
			else
				$html_output .= 'Pas de donnée disponible';

			$dataaa = array(
			    'LesDonnee'=> $html_output
			    );
			//echo json_encode($dataa);
			echo json_encode($dataaa);
		}
	}

    function action(Request $request)
    {
		if($request->ajax())
		{
			$output = ' ';
			$query = $request->get('query');
			if($query != '')
			{
				$data = DB::table('personetest')
				  //->where('id_personne', 'like', '%'.$query.'%')
				  ->Where('nom_personne', 'like', '%'.$query.'%')
				  //->orWhere('date_naissance', 'like', '%'.$query.'%')
				  //->orWhere('sexe', 'like', '%'.$query.'%')
				  ->orderBy('id_personne', 'desc')
				  ->get();
			}
			else
			{
				$data = DB::table('personetest')
				  ->orderBy('id_personne', 'desc')
				  ->get();
			}
			$total_row = $data->count();
			if($total_row > 0)
			{
				foreach($data as $row)
				{
					$output .= '
        <tr>
         <td>'.$row->id_personne.'</td>
         <td>'.$row->nom_personne.'</td>
         <td>'.$row->date_naissance.'</td>
         <td>'.$row->sexe.'</td>
        </tr>
        ';
				}
			}
			else
			{
				$output = '
       <tr>
        <td align="center" colspan="5">Pas de données dans la Base de donnée</td>
       </tr>
       ';
			}
			$data = array(
			 'table_data'  => $output,
			 'total_data'  => $total_row
			);

			echo json_encode($data);
		}
    }
}
