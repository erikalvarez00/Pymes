<?php

namespace App\Http\Controllers;

use App\Area;

use App\Question;

use App\Closed_answer;

use Illuminate\Http\Request;

class questionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::join('categories', 'questions.id_category', '=', 'categories.id_category')
            ->join('areas', 'areas.id_area', '=', 'categories.id_area')
            ->get();

        return view('questions.questions', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Obtener todas las areas con al menos una categoría
        $categories = self::getCategories();

        return view('questions.createQuestions', compact('areas', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Question::create([
            'id_category' => $request -> id_category,
            'question' => $request -> question,
            'type' => $request -> typeQuestion,
            'status' => ($request -> status == null) ? 0:1
        ]);

        if($request -> typeQuestion === "3"){
            $id = Question::all() -> last() -> id_question;

            foreach ($request -> opciones as $inciso) {
                Closed_answer::create([
                    'id_question' => $id,
                    'closed_answer' => $inciso
                ]);
            }
        }

        return redirect('questions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::where('id_question', $id) -> first();

        $categories = self::getCategories();

        $options = Closed_answer::where('id_question', $id) -> get();

        return view('questions.editQuestions', compact('question', 'categories', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Variables auxiliares
        $older_type = Question::where('id_question', $id) -> first() -> type;
        $types = ["1" => "Binary", "2" => "Open", "3" => "MultipleC"];

        // Actualizar la pregunta
        Question::where('id_question', $id) -> update([
            'id_category' => $request -> id_category,
            'question' => $request -> question,
            'type' => $request -> typeQuestion,
            'status' => ($request -> status == null) ? 0:1
        ]);

        // Comprobación de cambio de pregunta
        if($older_type === "MultipleC" && $types[$request -> typeQuestion] !== $older_type){
            // Si el tipo cambia desde las de opción múltiple a otro tipo
            // Debemos eliminar todas las opciones
            Closed_answer::where('id_question', $id) -> delete();
        }else if($older_type !== "MultipleC" && $types[$request -> typeQuestion] === "MultipleC"){
            // Si la pregunta ahora es de opcion multiple
            // Añadimos las nuevas opciones
            foreach ($request -> opciones as $inciso) {
                Closed_answer::create([
                    'id_question' => $id,
                    'closed_answer' => $inciso
                ]);
            }
        }else {
            // Ahora bien, si no cambia pueden suceder tres cosas
            // Se añaden y actualizan, se eliminan y actualizan o se actualizan incisos
            if($types[$request -> typeQuestion] === "MultipleC"){
                $new_options_count = count($request -> opciones);
                $older_options_count = Closed_answer::where('id_question', $id) -> count();

                if ($older_options_count > $new_options_count) {
                    // En caso de eliminarse incisos

                    // Actualizamos los primeros
                    for ($i = 0; $i < $new_options_count ; $i++) { 
                        (Closed_answer::where('id_question', $id) -> get())[$i] -> update([
                            'id_question' => $id,
                            'closed_answer' => ($request -> opciones)[$i]
                        ]);
                    }

                    // Eliminamos los ultimos
                    while($older_options_count > $new_options_count){
                        Closed_answer::where('id_question', $id) -> get() -> last() -> delete();
                        $older_options_count--;
                    }
                }else if($new_options_count > $older_options_count){
                    // Si se añaden incisos

                    // Actualizamos los primeros
                    for ($i = 0; $i < $older_options_count ; $i++) { 
                        (Closed_answer::where('id_question', $id) -> get())[$i] -> update([
                            'id_question' => $id,
                            'closed_answer' => ($request -> opciones)[$i]
                        ]);
                    }

                    // Agregamos los ultimos
                    for ($i = $older_options_count; $i < $new_options_count; $i++) { 
                        Closed_answer::create([
                            'id_question' => $id,
                            'closed_answer' => ($request -> opciones)[$i]
                        ]);
                    }
                } else {
                    // Si se mantiene el mismo numero de incisos

                    // Actualizamos los incisos simplemente
                    for ($i = 0; $i < $new_options_count ; $i++) { 
                        (Closed_answer::where('id_question', $id) -> get())[$i] -> update([
                            'id_question' => $id,
                            'closed_answer' => ($request -> opciones)[$i]
                        ]);
                    }
                }
            }
        }

        return redirect('questions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::findOrFail($id) -> delete();
        Closed_answer::where('id_question', $id) -> delete();

        return redirect('questions');
    }

    public function getCategories(){
        return Area::join('categories', 'areas.id_area', '=', 'categories.id_area')
            ->orderBy('areas.area')
            ->orderBy('categories.category')
            ->groupBy('areas.id_area', 'areas.area', 'categories.category', 'categories.id_category')
            ->get();
    }
}
