<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\Tarea;

class TareaApiController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');

        $form = collect($request->input('form'))->pluck('value', 'name');

        // if no proyecto has been selected, show no options
        if (! $form['proyecto']) {
            return [];
        }

        // if a proyecto has been selected, only show articles in that proyecto
        if ($form['proyecto']) {
            $options = Proyecto::find($form['proyecto'])->tareas();
        }

        if ($search_term) {
            $results = $options->where('nombre', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $options->paginate(10);
    }

    public function show($id)
    {
        return Tarea::find($id);
    }
}
