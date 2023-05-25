<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function pintarFormulario(){
        return view('correos.formcontacto');
    }

    public function procesarFormulario(Request $request){
        $request->validate([
            'nombre'=>['required', 'string', 'min:3'],
            'email'=>['required', 'email'],
            'contenido'=>['required', 'string', 'min:10']
        ]);
        //hemos pasado las validaciones enviamos el email
        try{
            Mail::to('responsable@correo.es')
            ->send(new ContactoMailable(nombre: $request->nombre,email: $request->email, contenido:$request->contenido));
        }catch(\Exception $ex){
            return redirect()->route('inicio')->with('info', 'No se pudo enviar el correo, intenteló más tarde');
        }
        return redirect()->route('inicio')->with('info', 'Se ha enviado el correo');
    }
}
